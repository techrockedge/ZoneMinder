#include "zm_analysis_thread.h"

#include "zm_signal.h"
#include "zm_utils.h"

AnalysisThread::AnalysisThread(std::shared_ptr<Monitor> monitor) :
    monitor_(std::move(monitor)), terminate_(false) {
  thread_ = std::thread(&AnalysisThread::Run, this);
}

AnalysisThread::~AnalysisThread() {
  Stop();
  if (thread_.joinable())
    thread_.join();
}

void AnalysisThread::Run() {
  Debug(2, "AnalysisThread::Run()");

  Microseconds analysis_rate = Microseconds(monitor_->GetAnalysisRate());
  Seconds analysis_update_delay = Seconds(monitor_->GetAnalysisUpdateDelay());

  monitor_->UpdateAdaptiveSkip();

  TimePoint last_analysis_update_time = std::chrono::steady_clock::now();
  TimePoint cur_time;

  while (!(terminate_ or zm_terminate)) {
    // Some periodic updates are required for variable capturing framerate
    if (analysis_update_delay != Seconds::zero()) {
      cur_time = std::chrono::steady_clock::now();
      if ((cur_time - last_analysis_update_time) > analysis_update_delay) {
        analysis_rate = Microseconds(monitor_->GetAnalysisRate());
        monitor_->UpdateAdaptiveSkip();
        last_analysis_update_time = cur_time;
      }
    }

    Debug(2, "Analyzing");
    if (!monitor_->Analyse()) {
      if ( !(terminate_ or zm_terminate) ) {
        Microseconds sleep_for = monitor_->Active() ? Microseconds(ZM_SAMPLE_RATE) : Microseconds(ZM_SUSPENDED_RATE);
        Debug(2, "Sleeping for %" PRId64 "us", int64(sleep_for.count()));
        std::this_thread::sleep_for(sleep_for);
      }
    } else if (analysis_rate != Microseconds::zero()) {
      Debug(2, "Sleeping for %" PRId64 " us", int64(analysis_rate.count()));
      std::this_thread::sleep_for(analysis_rate);
    } else {
      Debug(2, "Not sleeping");
    }
  }
}
