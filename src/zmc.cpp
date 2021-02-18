//
// ZoneMinder Capture Daemon, $Date$, $Revision$
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

/*

=head1 NAME

zmc - The ZoneMinder Capture daemon

=head1 SYNOPSIS

 zmc -d <device_path>
 zmc --device <device_path>
 zmc -f <file_path>
 zmc --file <file_path>
 zmc -m <monitor_id>
 zmc --monitor <monitor_id>
 zmc -h
 zmc --help
 zmc -v
 zmc --version

=head1 DESCRIPTION

This binary's job is to sit on a video device and suck frames off it as fast as
possible, this should run at more or less constant speed.

=head1 OPTIONS

 -d, --device <device_path>         - For local cameras, device to access. e.g /dev/video0 etc
 -f, --file <file_path>           - For local images, jpg file to access.
 -m, --monitor_id             - ID of the monitor to analyse
 -h, --help                 - Display usage information
 -v, --version              - Print the installed version of ZoneMinder

=cut

*/

#include "zm.h"
#include "zm_analysis_thread.h"
#include "zm_camera.h"
#include "zm_db.h"
#include "zm_define.h"
#include "zm_monitor.h"
#include "zm_rtsp_server_thread.h"
#include "zm_signal.h"
#include "zm_time.h"
#include "zm_utils.h"
#include <getopt.h>
#include <iostream>

void Usage() {
  fprintf(stderr, "zmc -d <device_path> or -r <proto> -H <host> -P <port> -p <path> or -f <file_path> or -m <monitor_id>\n");

  fprintf(stderr, "Options:\n");
#if defined(BSD)
  fprintf(stderr, "  -d, --device <device_path>         : For local cameras, device to access. E.g /dev/bktr0 etc\n");
#else
  fprintf(stderr, "  -d, --device <device_path>         : For local cameras, device to access. E.g /dev/video0 etc\n");
#endif
  fprintf(stderr, "  -f, --file <file_path>           : For local images, jpg file to access.\n");
  fprintf(stderr, "  -m, --monitor <monitor_id>         : For sources associated with a single monitor\n");
  fprintf(stderr, "  -h, --help                 : This screen\n");
  fprintf(stderr, "  -v, --version              : Report the installed version of ZoneMinder\n");
  exit(0);
}

int main(int argc, char *argv[]) {
  self = argv[0];

  srand(getpid() * time(nullptr));

  const char *device = "";
  const char *protocol = "";
  const char *host = "";
  const char *port = "";
  const char *path = "";
  const char *file = "";
  int monitor_id = -1;

  static struct option long_options[] = {
    {"device", 1, nullptr, 'd'},
    {"protocol", 1, nullptr, 'r'},
    {"host", 1, nullptr, 'H'},
    {"port", 1, nullptr, 'P'},
    {"path", 1, nullptr, 'p'},
    {"file", 1, nullptr, 'f'},
    {"monitor", 1, nullptr, 'm'},
    {"help", 0, nullptr, 'h'},
    {"version", 0, nullptr, 'v'},
    {nullptr, 0, nullptr, 0}
  };

  while (1) {
    int option_index = 0;

    int c = getopt_long(argc, argv, "d:H:P:p:f:m:h:v", long_options, &option_index);
    if ( c == -1 ) {
      break;
    }

    switch (c) {
      case 'd':
        device = optarg;
        break;
      case 'H':
        host = optarg;
        break;
      case 'P':
        port = optarg;
        break;
      case 'p':
        path = optarg;
        break;
      case 'f':
        file = optarg;
        break;
      case 'm':
        monitor_id = atoi(optarg);
        break;
      case 'h':
      case '?':
        Usage();
        break;
      case 'v':
        std::cout << ZM_VERSION << "\n";
        exit(0);
      default:
        // fprintf(stderr, "?? getopt returned character code 0%o ??\n", c);
        break;
    }
  }

  if ( optind < argc ) {
    fprintf(stderr, "Extraneous options, ");
    while ( optind < argc )
      printf("%s ", argv[optind++]);
    printf("\n");
    Usage();
  }

  int modes = ( (device[0]?1:0) + (host[0]?1:0) + (file[0]?1:0) + (monitor_id > 0 ? 1 : 0) );
  if ( modes > 1 ) {
    fprintf(stderr, "Only one of device, host/port/path, file or monitor id allowed\n");
    Usage();
    exit(0);
  }

  if ( modes < 1 ) {
    fprintf(stderr, "One of device, host/port/path, file or monitor id must be specified\n");
    Usage();
    exit(0);
  }

  char log_id_string[32] = "";
  if ( device[0] ) {
    const char *slash_ptr = strrchr(device, '/');
    snprintf(log_id_string, sizeof(log_id_string), "zmc_d%s", slash_ptr?slash_ptr+1:device);
  } else if ( host[0] ) {
    snprintf(log_id_string, sizeof(log_id_string), "zmc_h%s", host);
  } else if ( file[0] ) {
    const char *slash_ptr = strrchr(file, '/');
    snprintf(log_id_string, sizeof(log_id_string), "zmc_f%s", slash_ptr?slash_ptr+1:file);
  } else {
    snprintf(log_id_string, sizeof(log_id_string), "zmc_m%d", monitor_id);
  }

  logInit(log_id_string);
  zmLoadStaticConfig();
  zmDbConnect();
  zmLoadDBConfig();
  logInit(log_id_string);

  hwcaps_detect();

  std::vector<std::shared_ptr<Monitor>> monitors;
#if ZM_HAS_V4L
  if ( device[0] ) {
    monitors = Monitor::LoadLocalMonitors(device, Monitor::CAPTURE);
  } else
#endif  // ZM_HAS_V4L
  if ( host[0] ) {
    if ( !port )
      port = "80";
    monitors = Monitor::LoadRemoteMonitors(protocol, host, port, path, Monitor::CAPTURE);
  } else if ( file[0] ) {
    monitors = Monitor::LoadFileMonitors(file, Monitor::CAPTURE);
  } else {
    std::shared_ptr<Monitor> monitor = Monitor::Load(monitor_id, true, Monitor::CAPTURE);
    if ( monitor ) {
      monitors.push_back(monitor);
    }
  }

  if (monitors.empty()) {
    Error("No monitors found");
    exit(-1);
  } else {
	  Debug(2, "%d monitors loaded", monitors.size());

  }

  Info("Starting Capture version %s", ZM_VERSION);
  zmSetDefaultHupHandler();
  zmSetDefaultTermHandler();
  zmSetDefaultDieHandler();

  sigset_t block_set;
  sigemptyset(&block_set);

  sigaddset(&block_set, SIGHUP);
  sigaddset(&block_set, SIGUSR1);
  sigaddset(&block_set, SIGUSR2);

  int result = 0;

  int prime_capture_log_count = 0;

  while ( !zm_terminate ) {
    result = 0;
    static char sql[ZM_SQL_SML_BUFSIZ];
    for (const std::shared_ptr<Monitor> &monitor : monitors) {
      monitor->LoadCamera();

      if (!monitor->connect()) {
        Warning("Couldn't connect to monitor %d", monitor->Id());
      }
      time_t now = (time_t)time(nullptr);
      monitor->setStartupTime(now);

      snprintf(sql, sizeof(sql), 
          "INSERT INTO Monitor_Status (MonitorId,Status,CaptureFPS,AnalysisFPS) VALUES (%d, 'Running',0,0) ON DUPLICATE KEY UPDATE Status='Running',CaptureFPS=0,AnalysisFPS=0",
               monitor->Id());
      if (mysql_query(&dbconn, sql)) {
        Error("Can't run query: %s", mysql_error(&dbconn));
      }
    }  // end foreach monitor

    // Outer primary loop, handles connection to camera
    if (monitors[0]->PrimeCapture() <= 0) {
      if (prime_capture_log_count % 60) {
        Error("Failed to prime capture of initial monitor");
      } else {
        Debug(1, "Failed to prime capture of initial monitor");
      }
      prime_capture_log_count ++;
      monitors[0]->disconnect();
      if (!zm_terminate) {
        Debug(1, "Sleeping");
        sleep(5);
      }
      continue;
    }

    for (std::shared_ptr<Monitor> &monitor : monitors) {
      snprintf(sql, sizeof(sql),
          "INSERT INTO Monitor_Status (MonitorId,Status) VALUES (%d, 'Connected') ON DUPLICATE KEY UPDATE Status='Connected'",
               monitor->Id());
      if ( mysql_query(&dbconn, sql) ) {
        Error("Can't run query: %s", mysql_error(&dbconn));
      }
    }

#if HAVE_RTSP_SERVER
    RTSPServerThread ** rtsp_server_threads = nullptr;
    if (config.min_rtsp_port and monitors[0]->RTSPServer()) {
      rtsp_server_threads = new RTSPServerThread *[monitors.size()];
      Debug(1, "Starting RTSP server because min_rtsp_port is set");
    } else {
      Debug(1, "Not starting RTSP server because min_rtsp_port not set");
    }
#endif

    std::vector<std::unique_ptr<AnalysisThread>> analysis_threads = std::vector<std::unique_ptr<AnalysisThread>>();

    int *capture_delays = new int[monitors.size()];
    int *alarm_capture_delays = new int[monitors.size()];
    struct timeval * last_capture_times = new struct timeval[monitors.size()];

    for (size_t i = 0; i < monitors.size(); i++) {
      last_capture_times[i].tv_sec = last_capture_times[i].tv_usec = 0;
      capture_delays[i] = monitors[i]->GetCaptureDelay();
      alarm_capture_delays[i] = monitors[i]->GetAlarmCaptureDelay();
      Debug(2, "capture delay(%u mSecs 1000/capture_fps) alarm delay(%u)",
          capture_delays[i], alarm_capture_delays[i]);

      Monitor::Function function = monitors[0]->GetFunction();
      if ( function != Monitor::MONITOR ) {
        Debug(1, "Starting an analysis thread for monitor (%d)", monitors[i]->Id());
        analysis_threads.emplace_back(ZM::make_unique<AnalysisThread>(monitors[i]));
      }
#if HAVE_RTSP_SERVER
      if ( rtsp_server_threads ) {
        rtsp_server_threads[i] = new RTSPServerThread(monitors[i]);
        rtsp_server_threads[i]->addStream(monitors[i]->GetVideoStream(), monitors[i]->GetAudioStream());
        rtsp_server_threads[i]->start();
      }
#endif
    } // end foreach monitor

    struct timeval now;
    struct DeltaTimeval delta_time;

    while (!zm_terminate) {
      //sigprocmask(SIG_BLOCK, &block_set, 0);
      for (size_t i = 0; i < monitors.size(); i++) {
        monitors[i]->CheckAction();

        if (monitors[i]->PreCapture() < 0) {
          Error("Failed to pre-capture monitor %d %d (%d/" SZFMTD ")",
              monitors[i]->Id(), monitors[i]->Name(), i+1, monitors.size());
          result = -1;
          break;
        }
        if (monitors[i]->Capture() < 0) {
          Error("Failed to capture image from monitor %d %s (%d/" SZFMTD ")",
              monitors[i]->Id(), monitors[i]->Name(), i+1, monitors.size());
          result = -1;
          break;
        }
        if (monitors[i]->PostCapture() < 0) {
          Error("Failed to post-capture monitor %d %s (%d/" SZFMTD ")",
              monitors[i]->Id(), monitors[i]->Name(), i+1, monitors.size());
          result = -1;
          break;
        }

        gettimeofday(&now, nullptr);
        // capture_delay is the amount of time we should sleep to achieve the desired framerate.
        int delay = monitors[i]->GetState() == Monitor::ALARM ? alarm_capture_delays[i] : capture_delays[i];
        if (delay && last_capture_times[i].tv_sec) {
          int sleep_time;
          DELTA_TIMEVAL(delta_time, now, last_capture_times[i], DT_PREC_3);

          sleep_time = delay - delta_time.delta;
          Debug(3, "Sleep time is %d from now:%d.%d last:%d.%d delay: %d",
              sleep_time,
              now.tv_sec, now.tv_usec,
              last_capture_times[i].tv_sec, last_capture_times[i].tv_usec,
              delay
              );
          
          if (sleep_time < 0) {
            sleep_time = 0;
          } else if (sleep_time > 0) {
            Debug(2,"usleeping (%d)", sleep_time*(DT_MAXGRAN/DT_PREC_3) );
            usleep(sleep_time*(DT_MAXGRAN/DT_PREC_3));
          }
        } // end if has a last_capture time
        last_capture_times[i] = now;

      } // end foreach n_monitors

      if (result < 0) {
        // Failure, try reconnecting
        break;
      }

      if ( zm_reload ) {
        break;
      }
    }  // end while ! zm_terminate and connected

    for (std::unique_ptr<AnalysisThread> &analysis_thread: analysis_threads)
      analysis_thread->Stop();

    for (size_t i = 0; i < monitors.size(); i++) {
#if HAVE_RTSP_SERVER
      if (rtsp_server_threads) {
        rtsp_server_threads[i]->stop();
      }
#endif

      monitors[i]->Close();

#if HAVE_RTSP_SERVER
      if (rtsp_server_threads) {
        rtsp_server_threads[i]->join();
        delete rtsp_server_threads[i];
        rtsp_server_threads[i] = nullptr;
      }
#endif
    }

    // Killoff the analysis threads. Don't need them spinning while we try to reconnect
    analysis_threads.clear();

#if HAVE_RTSP_SERVER
    if (rtsp_server_threads) {
      delete[] rtsp_server_threads;
      rtsp_server_threads = nullptr;
    }
#endif
    delete [] alarm_capture_delays;
    delete [] capture_delays;
    delete [] last_capture_times;

    if (result < 0) {
      // Failure, try reconnecting
      Debug(1, "Sleeping for 5");
      sleep(5);
    }
    if (zm_reload) {
      for (std::shared_ptr<Monitor> &monitor : monitors) {
        monitor->Reload();
      }
      logTerm();
      logInit(log_id_string);
      zm_reload = false;
    }  // end if zm_reload
  }  // end while ! zm_terminate outer connection loop

  Debug(1,"Updating Monitor status");

  for (std::shared_ptr<Monitor> &monitor : monitors) {
    static char sql[ZM_SQL_SML_BUFSIZ];
    snprintf(sql, sizeof(sql),
        "INSERT INTO Monitor_Status (MonitorId,Status) VALUES (%d, 'Connected') ON DUPLICATE KEY UPDATE Status='NotRunning'", 
        monitor->Id());
    if (mysql_query(&dbconn, sql)) {
      Error("Can't run query: %s", mysql_error(&dbconn));
    }
  }

  Image::Deinitialise();
  Debug(1, "terminating");
  logTerm();
  zmDbClose();

	return zm_terminate ? 0 : result;
}
