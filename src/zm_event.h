//
// ZoneMinder Core Interfaces, $Date$, $Revision$
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

#ifndef ZM_EVENT_H
#define ZM_EVENT_H

#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <errno.h>
#include <limits.h>
#include <time.h>
#include <sys/time.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <mysql/mysql.h>

#include <set>
#include <map>
#include <queue>
#include <string>

#include "zm.h"
#include "zm_image.h"
#include "zm_stream.h"
#include "zm_packet.h"
#include "zm_storage.h"

class VideoStore;
class Zone;
class Monitor;
class EventStream;

// Maximum number of prealarm frames that can be stored
#define MAX_PRE_ALARM_FRAMES  16
typedef uint64_t event_id_t;
typedef enum { NORMAL=0, BULK, ALARM } FrameType;

#include "zm_frame.h"

//
// Class describing events, i.e. captured periods of activity.
//
class Event {
  friend class EventStream;

 public:
    typedef std::set<std::string> StringSet;
    typedef std::map<std::string,StringSet> StringSetMap;

 protected:
    static const char * frame_type_names[3];

    struct PreAlarmData {
      Image *image;
      struct timeval timestamp;
      unsigned int score;
      Image *alarm_frame;
    };
    std::queue<Frame*> frame_data;

    static int pre_alarm_count;
    static PreAlarmData pre_alarm_data[MAX_PRE_ALARM_FRAMES];

    uint64_t  id;
    Monitor      *monitor;
    struct timeval  start_time;
    struct timeval  end_time;
    std::string     cause;
    StringSetMap    noteSetMap;
    int        frames;
    int        alarm_frames;
    bool alarm_frame_written;
    unsigned int  tot_score;
    unsigned int  max_score;
    std::string path;
    std::string snapshot_file;
    std::string alarm_file;
    VideoStore *videoStore;

    std::string video_name;
    std::string video_file;
    int        last_db_frame;
    bool have_video_keyframe; // a flag to tell us if we have had a video keyframe when writing an mp4.  The first frame SHOULD be a video keyframe.
    Storage::Schemes  scheme;
    int save_jpegs;

    void createNotes(std::string &notes);

 public:
    static bool OpenFrameSocket(int);
    static bool ValidateFrameSocket(int);

    Event(
        Monitor *p_monitor,
        struct timeval p_start_time,
        const std::string &p_cause,
        const StringSetMap &p_noteSetMap
        );
    ~Event();

    uint64_t Id() const { return id; }
    const std::string &Cause() const { return cause; }
    int Frames() const { return frames; }
    int AlarmFrames() const { return alarm_frames; }

    const struct timeval &StartTime() const { return start_time; }
    const struct timeval &EndTime() const { return end_time; }

    void AddPacket(ZMPacket *p);
    bool WritePacket(ZMPacket &p);
    bool SendFrameImage(const Image *image, bool alarm_frame=false);
    bool WriteFrameImage(
        Image *image,
        struct timeval timestamp,
        const char *event_file,
        bool alarm_frame=false
       ) const;

    void updateNotes(const StringSetMap &stringSetMap);

    void AddFrames(int n_frames, Image **images, struct timeval **timestamps);
    void AddFrame(
        Image *image,
        struct timeval timestamp,
        int score=0,
        Image *alarm_image=nullptr);

 private:
    void AddFramesInternal(
        int n_frames,
        int start_frame,
        Image **images,
        struct timeval **timestamps);
    void WriteDbFrames();
    void UpdateFramesDelta(double offset);
    bool SetPath(Storage *storage);

 public:
    static const char *getSubPath(struct tm *time) {
      static char subpath[PATH_MAX] = "";
      snprintf(subpath, sizeof(subpath), "%02d/%02d/%02d/%02d/%02d/%02d",
          time->tm_year-100, time->tm_mon+1, time->tm_mday,
          time->tm_hour, time->tm_min, time->tm_sec);
      return subpath;
    }
    static const char *getSubPath(time_t *time) {
      return Event::getSubPath(localtime(time));
    }

    const char* getEventFile(void) const {
      return video_file.c_str();
    }

    static int PreAlarmCount() {
      return pre_alarm_count;
    }
    static void EmptyPreAlarmFrames() {
#if 0
      while ( pre_alarm_count > 0 ) {
				int i = pre_alarm_count - 1;
				delete pre_alarm_data[i].image;
				pre_alarm_data[i].image = nullptr;
				if ( pre_alarm_data[i].alarm_frame ) {
					delete pre_alarm_data[i].alarm_frame;
					pre_alarm_data[i].alarm_frame = nullptr;
				}
				pre_alarm_count--;
			}
#endif
      pre_alarm_count = 0;
    }
    static void AddPreAlarmFrame(
        Image *image,
        struct timeval timestamp,
        int score=0,
        Image *alarm_frame=nullptr
        ) {
#if 0
      pre_alarm_data[pre_alarm_count].image = new Image(*image);
      pre_alarm_data[pre_alarm_count].timestamp = timestamp;
      pre_alarm_data[pre_alarm_count].score = score;
      if ( alarm_frame ) {
        pre_alarm_data[pre_alarm_count].alarm_frame = new Image(*alarm_frame);
      }
#endif
      pre_alarm_count++;
    }
    void SavePreAlarmFrames() {
#if 0
      for ( int i = 0; i < pre_alarm_count; i++ ) {
        AddFrame(
						pre_alarm_data[i].image,
						pre_alarm_data[i].timestamp,
						pre_alarm_data[i].score,
						pre_alarm_data[i].alarm_frame);
			}
#endif
      EmptyPreAlarmFrames();
    }
};

#endif // ZM_EVENT_H
