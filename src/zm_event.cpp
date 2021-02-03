//
// ZoneMinder Event Class Implementation
// Copyright (C) 2001-2008 Philip Coombes
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
//

#include <fcntl.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <sys/un.h>
#include <sys/uio.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <getopt.h>
#include <arpa/inet.h>
#include <glob.h>

#include "zm.h"
#include "zm_db.h"
#include "zm_time.h"
#include "zm_signal.h"
#include "zm_event.h"
#include "zm_monitor.h"

//#define USE_PREPARED_SQL 1

const char * Event::frame_type_names[3] = { "Normal", "Bulk", "Alarm" };
#define MAX_DB_FRAMES 120
char frame_insert_sql[ZM_SQL_LGE_BUFSIZ] = "INSERT INTO `Frames` (`EventId`, `FrameId`, `Type`, `TimeStamp`, `Delta`, `Score`) VALUES ";

int Event::pre_alarm_count = 0;

Event::PreAlarmData Event::pre_alarm_data[MAX_PRE_ALARM_FRAMES] = { { 0 } };

Event::Event(
    Monitor *p_monitor,
    struct timeval p_start_time,
    const std::string &p_cause,
    const StringSetMap &p_noteSetMap
    ) :
  id(0),
  monitor(p_monitor),
  start_time(p_start_time),
  end_time({0,0}),
  cause(p_cause),
  noteSetMap(p_noteSetMap),
  frames(0),
  alarm_frames(0),
  alarm_frame_written(false),
  tot_score(0),
  max_score(0),
  //path(""),
  //snapshit_file(),
  //alarm_file(""),
  videoStore(nullptr),
  //video_name(""),
  //video_file(""),
  last_db_frame(0),
  have_video_keyframe(false),
  //scheme
  save_jpegs(0)
{
  std::string notes;
  createNotes(notes);

  struct timeval now;
  gettimeofday(&now, 0);

  if ( !start_time.tv_sec ) {
    Warning("Event has zero time, setting to now");
    start_time = now;
  } else if ( start_time.tv_sec > now.tv_sec ) {
    char buffer[26];
    char buffer_now[26];
    struct tm* tm_info;

    tm_info = localtime(&start_time.tv_sec);
    strftime(buffer, 26, "%Y:%m:%d %H:%M:%S", tm_info);
    tm_info = localtime(&now.tv_sec);
    strftime(buffer_now, 26, "%Y:%m:%d %H:%M:%S", tm_info);

    Error(
        "StartDateTime in the future starttime %u.%u >? now %u.%u difference %d\n%s\n%s",
        start_time.tv_sec, start_time.tv_usec, now.tv_sec, now.tv_usec,
        (now.tv_sec-start_time.tv_sec),
        buffer, buffer_now
        );
    start_time = now;
  }

  unsigned int state_id = 0;
  zmDbRow dbrow;
  if ( dbrow.fetch("SELECT Id FROM States WHERE IsActive=1") ) {
    state_id = atoi(dbrow[0]);
  }

  // Copy it in case opening the mp4 doesn't work we can set it to another value
  save_jpegs = monitor->GetOptSaveJPEGs();
  Storage * storage = monitor->getStorage();

  char sql[ZM_SQL_MED_BUFSIZ];
  snprintf(sql, sizeof(sql),
      "INSERT INTO `Events` "
      "( `MonitorId`, `StorageId`, `Name`, `StartDateTime`, `Width`, `Height`, `Cause`, `Notes`, `StateId`, `Orientation`, `Videoed`, `DefaultVideo`, `SaveJPEGs`, `Scheme` )"
      " VALUES "
      "( %d, %d, 'New Event', from_unixtime( %ld ), %d, %d, '%s', '%s', %d, %d, %d, '%s', %d, '%s' )",
      monitor->Id(), 
      storage->Id(),
      start_time.tv_sec,
      monitor->Width(),
      monitor->Height(),
      cause.c_str(),
      notes.c_str(), 
      state_id,
      monitor->getOrientation(),
      ( monitor->GetOptVideoWriter() != 0 ? 1 : 0 ),
			( monitor->GetOptVideoWriter() != 0 ? "video.mp4" : "" ),
      monitor->GetOptSaveJPEGs(),
      storage->SchemeString().c_str()
      );

  db_mutex.lock();
  while ( mysql_query(&dbconn, sql) ) {
    db_mutex.unlock();
    Error("Can't insert event: %s. sql was (%s)", mysql_error(&dbconn), sql);
    db_mutex.lock();
  }
  id = mysql_insert_id(&dbconn);

  if ( !SetPath(storage) ) {
    // Try another
    Warning("Failed creating event dir at %s", storage->Path());

    std::string sql = stringtf("SELECT `Id` FROM `Storage` WHERE `Id` != %u", storage->Id());
    if ( monitor->ServerId() )
      sql += stringtf(" AND ServerId=%u", monitor->ServerId());

    Debug(1, "%s", sql.c_str());
    storage = nullptr;

    MYSQL_RES *result = zmDbFetch(sql.c_str());
    if ( result ) {
      for ( int i = 0; MYSQL_ROW dbrow = mysql_fetch_row(result); i++ ) {
        storage = new Storage(atoi(dbrow[0]));
        if ( SetPath(storage) )
          break;
        delete storage;
        storage = nullptr;
      }  // end foreach row of Storage
      mysql_free_result(result);
      result = nullptr;
    }
    if ( !storage ) {
      Info("No valid local storage area found.  Trying all other areas.");
      // Try remote
      sql = "SELECT `Id` FROM `Storage` WHERE ServerId IS NULL";
      if ( monitor->ServerId() )
        sql += stringtf(" OR ServerId != %u", monitor->ServerId());

      MYSQL_RES *result = zmDbFetch(sql.c_str());
      if ( result ) {
        for ( int i = 0; MYSQL_ROW dbrow = mysql_fetch_row(result); i++ ) {
          storage = new Storage(atoi(dbrow[0]));
          if ( SetPath(storage) )
            break;
          delete storage;
          storage = nullptr;
        }  // end foreach row of Storage
        mysql_free_result(result);
        result = nullptr;
      }
    }
    if ( !storage ) {
      storage = new Storage();
      Warning("Failed to find a storage area to save events.");
    }
    sql = stringtf("UPDATE Events SET StorageId = '%d' WHERE Id=%" PRIu64, storage->Id(), id);
    db_mutex.lock();
    int rc = mysql_query(&dbconn, sql.c_str());
    db_mutex.unlock();
    if ( rc ) {
      Error("Can't update event: %s. sql was (%s)", mysql_error(&dbconn), sql.c_str());
    }
  }
  Debug(1, "Using storage area at %s", path.c_str());

  db_mutex.unlock();
  video_name = "";

  snapshot_file = path + "/snapshot.jpg";
  alarm_file = path + "/alarm.jpg";

  /* Save as video */

  if ( monitor->GetOptVideoWriter() != 0 ) {
    std::string container = monitor->OutputContainer();
    if ( container == "auto" || container == "" ) {
      if ( monitor->OutputCodec() == AV_CODEC_ID_H264 ) {
        container = "mp4";
      } else {
        container = "mkv";
      }
    }
        
    video_name = stringtf("%" PRIu64 "-%s.%s", id, "video", container.c_str());
    snprintf(sql, sizeof(sql), "UPDATE Events SET DefaultVideo = '%s' WHERE Id=%" PRIu64, video_name.c_str(), id);
    db_mutex.lock();
    if ( mysql_query(&dbconn, sql) ) {
      db_mutex.unlock();
      Error("Can't update event: %s. sql was (%s)", mysql_error(&dbconn), sql);
      return;
    }
    db_mutex.unlock();
    video_file = path + "/" + video_name;
    Debug(1, "Writing video file to %s", video_file.c_str());
    Camera * camera = monitor->getCamera();
    videoStore = new VideoStore(
        video_file.c_str(),
        container.c_str(),
        camera->get_VideoStream(),
        camera->get_VideoCodecContext(),
        ( monitor->RecordAudio() ? camera->get_AudioStream() : nullptr ),
        ( monitor->RecordAudio() ? camera->get_AudioCodecContext() : nullptr ),
        monitor );

    if ( !videoStore->open() ) {
      delete videoStore;
      videoStore = nullptr;
      save_jpegs |= 1; // Turn on jpeg storage
    }
  }  // end if GetOptVideoWriter
} // Event::Event( Monitor *p_monitor, struct timeval p_start_time, const std::string &p_cause, const StringSetMap &p_noteSetMap, bool p_videoEvent )

Event::~Event() {
  // We close the videowriter first, because if we finish the event, we might try to view the file, but we aren't done writing it yet.

  /* Close the video file */
  if ( videoStore != nullptr ) {
    Debug(2, "Deleting video store");
    delete videoStore;
    videoStore = nullptr;
  }

  // endtime is set in AddFrame, so SHOULD be set to the value of the last frame timestamp.
  if ( !end_time.tv_sec ) {
    Warning("Empty endtime for event.  Should not happen.  Setting to now.");
    gettimeofday(&end_time, nullptr);
  }
  struct DeltaTimeval delta_time;
  DELTA_TIMEVAL(delta_time, end_time, start_time, DT_PREC_2);
  Debug(2, "start_time:%d.%d end_time%d.%d", start_time.tv_sec, start_time.tv_usec, end_time.tv_sec, end_time.tv_usec);

#if 0  // This closing frame has no image. There is no point in adding a db record for it, I think. ICON
  if ( frames > last_db_frame ) {
    frames ++;
    Debug(1, "Adding closing frame %d to DB", frames);
    frame_data.push(new Frame(id, frames, NORMAL, end_time, delta_time, 0));
  }
#endif
  if ( frame_data.size() )
    WriteDbFrames();

  // update frame deltas to refer to video start time which may be a few frames before event start
  struct timeval video_offset = {0};
  struct timeval video_start_time = monitor->GetVideoWriterStartTime();
  if ( video_start_time.tv_sec > 0 ) {
     timersub(&video_start_time, &start_time, &video_offset);
     Debug(1, "Updating frames delta by %d sec %d usec",
           video_offset.tv_sec, video_offset.tv_usec);
     UpdateFramesDelta(video_offset.tv_sec + video_offset.tv_usec*1e-6);
  } else {
     Debug(3, "Video start_time %d sec %d usec not valid -- frame deltas not updated",
           video_start_time.tv_sec, video_start_time.tv_usec);
  }

  // Should not be static because we might be multi-threaded
  char sql[ZM_SQL_LGE_BUFSIZ];
  snprintf(sql, sizeof(sql),
      "UPDATE Events SET Name='%s%" PRIu64 "', EndDateTime = from_unixtime(%ld), Length = %s%ld.%02ld, Frames = %d, AlarmFrames = %d, TotScore = %d, AvgScore = %d, MaxScore = %d WHERE Id = %" PRIu64 " AND Name='New Event'",
      monitor->EventPrefix(), id, end_time.tv_sec,
      delta_time.positive?"":"-", delta_time.sec, delta_time.fsec,
      frames, alarm_frames,
      tot_score, (int)(alarm_frames?(tot_score/alarm_frames):0), max_score,
      id);
  db_mutex.lock();
  while ( mysql_query(&dbconn, sql) && !zm_terminate ) {
    db_mutex.unlock();
    Error("Can't update event: %s reason: %s", sql, mysql_error(&dbconn));
    sleep(1);
    db_mutex.lock();
  }
  if ( !mysql_affected_rows(&dbconn) ) {
    // Name might have been changed during recording, so just do the update without changing the name.
    snprintf(sql, sizeof(sql),
        "UPDATE Events SET EndDateTime = from_unixtime(%ld), Length = %s%ld.%02ld, Frames = %d, AlarmFrames = %d, TotScore = %d, AvgScore = %d, MaxScore = %d WHERE Id = %" PRIu64,
        end_time.tv_sec,
        delta_time.positive?"":"-", delta_time.sec, delta_time.fsec,
        frames, alarm_frames,
        tot_score, (int)(alarm_frames?(tot_score/alarm_frames):0), max_score,
        id);
    while ( mysql_query(&dbconn, sql) && !zm_terminate ) {
      db_mutex.unlock();
      Error("Can't update event: %s reason: %s", sql, mysql_error(&dbconn));
      sleep(1);
      db_mutex.lock();
    }
  }  // end if no changed rows due to Name change during recording
  db_mutex.unlock();
}  // Event::~Event()

void Event::createNotes(std::string &notes) {
  if ( !notes.empty() ) {
    notes.clear();
    for ( StringSetMap::const_iterator mapIter = noteSetMap.begin(); mapIter != noteSetMap.end(); ++mapIter ) {
      notes += mapIter->first;
      notes += ": ";
      const StringSet &stringSet = mapIter->second;
      for ( StringSet::const_iterator setIter = stringSet.begin(); setIter != stringSet.end(); ++setIter ) {
        if ( setIter != stringSet.begin() )
          notes += ", ";
        notes += *setIter;
      }
    }
  } else {
    notes = "";
  }
}  // void Event::createNotes(std::string &notes)

bool Event::WriteFrameImage(
    Image *image,
    struct timeval timestamp,
    const char *event_file,
    bool alarm_frame) const {

  int thisquality = 
    (alarm_frame && (config.jpeg_alarm_file_quality > config.jpeg_file_quality)) ?
    config.jpeg_alarm_file_quality : 0;   // quality to use, zero is default

  bool rc;

  if ( !config.timestamp_on_capture ) {
    // stash the image we plan to use in another pointer regardless if timestamped.
    // exif is only timestamp at present this switches on or off for write
    Image *ts_image = new Image(*image);
    monitor->TimestampImage(ts_image, &timestamp);
    rc = ts_image->WriteJpeg(event_file, thisquality,
        (monitor->Exif() ? timestamp : (timeval){0,0}));
    delete(ts_image);
  } else {
    rc = image->WriteJpeg(event_file, thisquality,
        (monitor->Exif() ? timestamp : (timeval){0,0}));
  }

  return rc;
}  // end Event::WriteFrameImage( Image *image, struct timeval timestamp, const char *event_file, bool alarm_frame )

bool Event::WritePacket(ZMPacket &packet) {
  
  if ( videoStore->writePacket(&packet) < 0 )
    return false;
  return true;
}  // bool Event::WriteFrameVideo

void Event::updateNotes(const StringSetMap &newNoteSetMap) {
  bool update = false;

  //Info( "Checking notes, %d <> %d", noteSetMap.size(), newNoteSetMap.size() );
  if ( newNoteSetMap.size() > 0 ) {
    if ( noteSetMap.size() == 0 ) {
      noteSetMap = newNoteSetMap;
      update = true;
    } else {
      for ( StringSetMap::const_iterator newNoteSetMapIter = newNoteSetMap.begin();
          newNoteSetMapIter != newNoteSetMap.end();
          ++newNoteSetMapIter ) {
        const std::string &newNoteGroup = newNoteSetMapIter->first;
        const StringSet &newNoteSet = newNoteSetMapIter->second;
        //Info( "Got %d new strings", newNoteSet.size() );
        if ( newNoteSet.size() > 0 ) {
          StringSetMap::iterator noteSetMapIter = noteSetMap.find(newNoteGroup);
          if ( noteSetMapIter == noteSetMap.end() ) {
            //Info( "Can't find note group %s, copying %d strings", newNoteGroup.c_str(), newNoteSet.size() );
            noteSetMap.insert(StringSetMap::value_type(newNoteGroup, newNoteSet));
            update = true;
          } else {
            StringSet &noteSet = noteSetMapIter->second;
            //Info( "Found note group %s, got %d strings", newNoteGroup.c_str(), newNoteSet.size() );
            for ( StringSet::const_iterator newNoteSetIter = newNoteSet.begin();
                newNoteSetIter != newNoteSet.end();
                ++newNoteSetIter ) {
              const std::string &newNote = *newNoteSetIter;
              StringSet::iterator noteSetIter = noteSet.find(newNote);
              if ( noteSetIter == noteSet.end() ) {
                noteSet.insert(newNote);
                update = true;
              }
            } // end for
          } // end if ( noteSetMap.size() == 0
        } // end if newNoteSetupMap.size() > 0
      } // end foreach newNoteSetMap
    } // end if have old notes
  } // end if have new notes

  if ( update ) {
    std::string notes;
    createNotes(notes);

    Debug(2, "Updating notes for event %d, '%s'", id, notes.c_str());
    static char sql[ZM_SQL_LGE_BUFSIZ];
#if USE_PREPARED_SQL
    static MYSQL_STMT *stmt = 0;

    char notesStr[ZM_SQL_MED_BUFSIZ] = "";
    unsigned long notesLen = 0;

    if ( !stmt ) {
      const char *sql = "UPDATE `Events` SET `Notes` = ? WHERE `Id` = ?";

      stmt = mysql_stmt_init(&dbconn);
      if ( mysql_stmt_prepare(stmt, sql, strlen(sql)) ) {
        Fatal("Unable to prepare sql '%s': %s", sql, mysql_stmt_error(stmt));
      }

      /* Get the parameter count from the statement */
      if ( mysql_stmt_param_count(stmt) != 2 ) {
        Error("Unexpected parameter count %ld in sql '%s'", mysql_stmt_param_count(stmt), sql);
      }

      MYSQL_BIND  bind[2];
      memset(bind, 0, sizeof(bind));

      /* STRING PARAM */
      bind[0].buffer_type = MYSQL_TYPE_STRING;
      bind[0].buffer = (char *)notesStr;
      bind[0].buffer_length = sizeof(notesStr);
      bind[0].is_null = 0;
      bind[0].length = &notesLen;

      bind[1].buffer_type= MYSQL_TYPE_LONG;
      bind[1].buffer= (char *)&id;
      bind[1].is_null= 0;
      bind[1].length= 0;

      /* Bind the buffers */
      if ( mysql_stmt_bind_param(stmt, bind) ) {
        Error("Unable to bind sql '%s': %s", sql, mysql_stmt_error(stmt));
      }
    } // end if ! stmt

    strncpy(notesStr, notes.c_str(), sizeof(notesStr));

    if ( mysql_stmt_execute(stmt) ) {
      Error("Unable to execute sql '%s': %s", sql, mysql_stmt_error(stmt));
    }
#else
    static char escapedNotes[ZM_SQL_MED_BUFSIZ];

    mysql_real_escape_string(&dbconn, escapedNotes, notes.c_str(), notes.length());

    snprintf(sql, sizeof(sql), "UPDATE `Events` SET `Notes` = '%s' WHERE `Id` = %" PRIu64, escapedNotes, id);
    db_mutex.lock();
    if ( mysql_query(&dbconn, sql) ) {
      Error("Can't insert event: %s", mysql_error(&dbconn));
    }
    db_mutex.unlock();
#endif
  }  // end if update
}  // void Event::updateNotes(const StringSetMap &newNoteSetMap)

void Event::AddFrames(int n_frames, Image **images, struct timeval **timestamps) {
  for ( int i = 0; i < n_frames; i += ZM_SQL_BATCH_SIZE ) {
    AddFramesInternal(n_frames, i, images, timestamps);
  }
}

void Event::AddFramesInternal(int n_frames, int start_frame, Image **images, struct timeval **timestamps) {
  char *frame_insert_values = (char *)&frame_insert_sql + 90; // 90 == strlen(frame_insert_sql); 
  //static char sql[ZM_SQL_LGE_BUFSIZ];
  //strncpy(sql, "INSERT INTO `Frames` (`EventId`, `FrameId`, `TimeStamp`, `Delta`) VALUES ", sizeof(sql));
  int frameCount = 0;
  for ( int i = start_frame; i < n_frames && i - start_frame < ZM_SQL_BATCH_SIZE; i++ ) {
    if ( timestamps[i]->tv_sec <= 0 ) {
      Debug(1, "Not adding pre-capture frame %d, zero or less than 0 timestamp", i);
      continue;
    } else if ( timestamps[i]->tv_sec < 0 ) {
      Warning( "Not adding pre-capture frame %d, negative timestamp", i );
      continue;
    } else {
      Debug( 3, "Adding pre-capture frame %d, timestamp = (%d), start_time=(%d)", i, timestamps[i]->tv_sec, start_time.tv_sec );
    }

    frames++;

    if ( save_jpegs & 1 ) {
			std::string event_file = stringtf(staticConfig.capture_file_format, path.c_str(), frames);
      Debug(1, "Writing pre-capture frame %d", frames);
      WriteFrameImage(images[i], *(timestamps[i]), event_file.c_str());
    }
    //If this is the first frame, we should add a thumbnail to the event directory
    // ICON: We are working through the pre-event frames so this snapshot won't 
    // neccessarily be of the motion.  But some events are less than 10 frames, 
    // so I am changing this to 1, but we should overwrite it later with a better snapshot.
    if ( frames == 1 ) {
      WriteFrameImage(images[i], *(timestamps[i]), snapshot_file.c_str());
    }

    struct DeltaTimeval delta_time;
    DELTA_TIMEVAL(delta_time, *(timestamps[i]), start_time, DT_PREC_2);
    // Delta is Decimal(8,2) so 6 integer digits and 2 decimal digits
    if ( delta_time.sec > 999999 ) {
      Warning("Invalid delta_time from_unixtime(%ld), %s%ld.%02ld", 
           timestamps[i]->tv_sec,
           (delta_time.positive?"":"-"),
           delta_time.sec,
           delta_time.fsec);
        delta_time.sec = 0;
    }

    frame_insert_values += snprintf(frame_insert_values,
        sizeof(frame_insert_sql)-(frame_insert_values-(char *)&frame_insert_sql),
        "\n( %" PRIu64 ", %d, 'Normal', from_unixtime(%ld), %s%ld.%02ld, 0 ),",
        id, frames, timestamps[i]->tv_sec, delta_time.positive?"":"-", delta_time.sec, delta_time.fsec);

    frameCount++;
  } // end foreach frame

  if ( frameCount ) {
    *(frame_insert_values-1) = '\0';
    db_mutex.lock();
    int rc = mysql_query(&dbconn, frame_insert_sql);
    db_mutex.unlock();
    if ( rc ) {
      Error("Can't insert frames: %s, sql was (%s)", mysql_error(&dbconn), frame_insert_sql);
    } else {
      Debug(1, "INSERT %d/%d frames sql %s", frameCount, n_frames, frame_insert_sql);
    }
    last_db_frame = frames;
  } else {
    Debug(1, "No valid pre-capture frames to add");
  }
  end_time = *timestamps[n_frames-1];
}  // void Event::AddFramesInternal(int n_frames, int start_frame, Image **images, struct timeval **timestamps)

void Event::AddPacket(ZMPacket *packet) {

  have_video_keyframe = have_video_keyframe || ( ( packet->codec_type == AVMEDIA_TYPE_VIDEO ) && packet->keyframe );
  Debug(2, "have_video_keyframe %d codec_type %d == video? %d packet keyframe %d",
      have_video_keyframe, packet->codec_type, (packet->codec_type == AVMEDIA_TYPE_VIDEO), packet->keyframe);
  dumpPacket(&packet->packet, "Adding to event");
  if ( videoStore ) {
    if ( have_video_keyframe )  {
      videoStore->writePacket(packet);
    } else {
      Debug(2, "No video keyframe yet, not writing");
    }
    //FIXME if it fails, we should write a jpeg
  }
  if ( ( packet->codec_type == AVMEDIA_TYPE_VIDEO ) or packet->image )
    AddFrame(packet->image, *(packet->timestamp), packet->score, packet->analysis_image);
  end_time = *packet->timestamp;
  return;
}

void Event::WriteDbFrames() {
  char *frame_insert_values_ptr = (char *)&frame_insert_sql + 90; // 90 == strlen(frame_insert_sql); 

	/* Each frame needs about 63 chars.  So if we buffer too many frames, we will exceed the size of frame_insert_sql;
	 */
  Debug(1, "Inserting %d frames", frame_data.size());
  while ( frame_data.size() ) {
    Frame *frame = frame_data.front();
    frame_data.pop();
    frame_insert_values_ptr += snprintf(frame_insert_values_ptr,
        sizeof(frame_insert_sql)-(frame_insert_values_ptr-(char *)&frame_insert_sql),
        "\n( %" PRIu64 ", %d, '%s', from_unixtime( %ld ), %s%ld.%02ld, %d ),",
        id, frame->frame_id,
        frame_type_names[frame->type],
        frame->timestamp.tv_sec,
        frame->delta.positive?"":"-",
        frame->delta.sec,
        frame->delta.fsec,
        frame->score);
    delete frame;
  }
  *(frame_insert_values_ptr-1) = '\0'; // The -1 is for the extra , added for values above
  db_mutex.lock();
  int rc = mysql_query(&dbconn, frame_insert_sql);
  db_mutex.unlock();

  if ( rc ) {
    Error("Can't insert frames: %s, sql was %s", mysql_error(&dbconn), frame_insert_sql);
    return;
  } else {
    Debug(1, "INSERT FRAMES: sql was %s", frame_insert_sql);
  }
} // end void Event::WriteDbFrames()

// Subtract an offset time from frames deltas to match with video start time
void Event::UpdateFramesDelta(double offset) {
  char sql[ZM_SQL_MED_BUFSIZ];

  if ( offset == 0.0 ) return;
  // the table is set to auto update timestamp so we force it to keep current value
  snprintf(sql, sizeof(sql),
    "UPDATE Frames SET timestamp = timestamp, Delta = Delta - (%.4f) WHERE EventId = %" PRIu64,
    offset, id);

  db_mutex.lock();
  if ( mysql_query(&dbconn, sql) ) {
    db_mutex.unlock();
    Error("Can't update frames: %s, sql was %s", mysql_error(&dbconn), sql);
    return;
  }
  db_mutex.unlock();
  Info("Updating frames delta by %0.2f sec to match video file", offset);
}

void Event::AddFrame(Image *image, struct timeval timestamp, int score, Image *alarm_image) {
  if ( !timestamp.tv_sec ) {
    Debug(1, "Not adding new frame, zero timestamp");
    return;
  }

  frames++;

  bool write_to_db = false;
  FrameType frame_type = score>0?ALARM:(score<0?BULK:NORMAL);
  // < 0 means no motion detection is being done.
  if ( score < 0 )
    score = 0;
  tot_score += score;
  if ( score > (int)max_score )
    max_score = score;

  if ( image ) {
    if ( save_jpegs & 1 ) {
      std::string event_file = stringtf(staticConfig.capture_file_format, path.c_str(), frames);
      Debug(1, "Writing capture frame %d to %s", frames, event_file.c_str());
      if ( !WriteFrameImage(image, timestamp, event_file.c_str()) ) {
        Error("Failed to write frame image");
      }
    } // end if save_jpegs

    // If this is the first frame, we should add a thumbnail to the event directory
    if ( (frames == 1) || (score > (int)max_score) ) {
      write_to_db = true; // web ui might show this as thumbnail, so db needs to know about it.
      WriteFrameImage(image, timestamp, snapshot_file.c_str());
    }

    // We are writing an Alarm frame
    if ( frame_type == ALARM ) {
      // The first frame with a score will be the frame that alarmed the event
      if ( !alarm_frame_written ) {
        write_to_db = true; // OD processing will need it, so the db needs to know about it
        alarm_frame_written = true;
        WriteFrameImage(image, timestamp, alarm_file.c_str());
      }
      alarm_frames++;

      if ( alarm_image and ( save_jpegs & 2 ) ) {
        std::string event_file = stringtf(staticConfig.analyse_file_format, path.c_str(), frames);
        Debug(1, "Writing analysis frame %d", frames);
        if ( ! WriteFrameImage(alarm_image, timestamp, event_file.c_str(), true) ) {
          Error("Failed to write analysis frame image");
        }
      }
    }  // end if is an alarm frame
  }  // end if has image

  bool db_frame = ( frame_type != BULK ) || (frames==1) || ((frames%config.bulk_frame_interval)==0) ;
  if ( db_frame ) {

    struct DeltaTimeval delta_time;
    DELTA_TIMEVAL(delta_time, timestamp, start_time, DT_PREC_2);
    Debug(1, "Frame delta is %d.%d - %d.%d = %d.%d", 
        start_time.tv_sec, start_time.tv_usec, timestamp.tv_sec, timestamp.tv_usec, delta_time.sec, delta_time.fsec);

    // The idea is to write out 1/sec
    frame_data.push(new Frame(id, frames, frame_type, timestamp, delta_time, score));
    double fps = monitor->get_capture_fps();
		if ( write_to_db
				or
				(frame_data.size() >= MAX_DB_FRAMES)
				or
				(frame_type == BULK)
				or
				( fps and (frame_data.size() > fps) )
			 ) {
      Debug(1, "Adding %d frames to DB because write_to_db:%d or frames > analysis fps %f or BULK(%d)",
					frame_data.size(), write_to_db, fps, (frame_type==BULK));
      WriteDbFrames();
      last_db_frame = frames;

      static char sql[ZM_SQL_MED_BUFSIZ];
      snprintf(sql, sizeof(sql), 
          "UPDATE Events SET Length = %s%ld.%02ld, Frames = %d, AlarmFrames = %d, TotScore = %d, AvgScore = %d, MaxScore = %d WHERE Id = %" PRIu64, 
          ( delta_time.positive?"":"-" ),
          delta_time.sec, delta_time.fsec,
          frames, 
          alarm_frames,
          tot_score,
          (int)(alarm_frames?(tot_score/alarm_frames):0),
          max_score,
          id
          );
      db_mutex.lock();
      while ( mysql_query(&dbconn, sql) && !zm_terminate ) {
        Error("Can't update event: %s", mysql_error(&dbconn));
        db_mutex.unlock();
        sleep(1);
        db_mutex.lock();
      }
      db_mutex.unlock();
		} else {
      Debug(1, "Not Adding %d frames to DB because write_to_db:%d or frames > analysis fps %f or BULK",
					frame_data.size(), write_to_db, fps);
    } // end if frame_type == BULK
  } // end if db_frame

  end_time = timestamp;
}  // end void Event::AddFrame(Image *image, struct timeval timestamp, int score, Image *alarm_image)

bool Event::SetPath(Storage *storage) {
  scheme = storage->Scheme();

  path = stringtf("%s/%d", storage->Path(), monitor->Id());
  // Try to make the Monitor Dir.  Normally this would exist, but in odd cases might not.
  if ( mkdir(path.c_str(), 0755) and ( errno != EEXIST ) ) {
    Error("Can't mkdir %s: %s", path.c_str(), strerror(errno));
    return false;
  }

  struct tm *stime = localtime(&start_time.tv_sec);
  if ( scheme == Storage::DEEP ) {

    int dt_parts[6];
    dt_parts[0] = stime->tm_year-100;
    dt_parts[1] = stime->tm_mon+1;
    dt_parts[2] = stime->tm_mday;
    dt_parts[3] = stime->tm_hour;
    dt_parts[4] = stime->tm_min;
    dt_parts[5] = stime->tm_sec;

    std::string date_path;
    std::string time_path;

    for ( unsigned int i = 0; i < sizeof(dt_parts)/sizeof(*dt_parts); i++ ) {
      path += stringtf("/%02d", dt_parts[i]);

      if ( mkdir(path.c_str(), 0755) and ( errno != EEXIST ) ) {
        Error("Can't mkdir %s: %s", path.c_str(), strerror(errno));
        return false;
      }
      if ( i == 2 )
				date_path = path;
    }
		time_path = stringtf("%02d/%02d/%02d", stime->tm_hour, stime->tm_min, stime->tm_sec);

    // Create event id symlink
    std::string id_file = stringtf("%s/.%" PRIu64, date_path.c_str(), id);
    if ( symlink(time_path.c_str(), id_file.c_str()) < 0 ) {
      Error("Can't symlink %s -> %s: %s", id_file.c_str(), time_path.c_str(), strerror(errno));
      return false;
    }
  } else if ( scheme == Storage::MEDIUM ) {
    path += stringtf("/%04d-%02d-%02d",
        stime->tm_year+1900, stime->tm_mon+1, stime->tm_mday
        );
    if ( mkdir(path.c_str(), 0755) and ( errno != EEXIST ) ) {
      Error("Can't mkdir %s: %s", path.c_str(), strerror(errno));
      return false;
    }
    path += stringtf("/%" PRIu64, id);
    if ( mkdir(path.c_str(), 0755) and ( errno != EEXIST ) ) {
      Error("Can't mkdir %s: %s", path.c_str(), strerror(errno));
      return false;
    }
  } else {
    path += stringtf("/%" PRIu64, id);
    if ( mkdir(path.c_str(), 0755) and ( errno != EEXIST ) ) {
      Error("Can't mkdir %s: %s", path.c_str(), strerror(errno));
      return false;
    }

    // Create empty id tag file
    std::string id_file = stringtf("%s/.%" PRIu64, path.c_str(), id);
    if ( FILE *id_fp = fopen(id_file.c_str(), "w") ) {
      fclose(id_fp);
    } else {
      Error("Can't fopen %s: %s", id_file.c_str(), strerror(errno));
      return false;
		}
  } // deep storage or not
  return true;
}  // end bool Event::SetPath
