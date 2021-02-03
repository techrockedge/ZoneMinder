/* ---------------------------------------------------------------------------
**
** ADTS_DeviceSource.cpp
**
** ADTS Live555 source
**
** -------------------------------------------------------------------------*/

#include "zm.h"

#if HAVE_RTSP_SERVER
#include <sstream>
#include <iomanip>

// live555
#include <Base64.hh>

#include "zm_rtsp_server_adts_source.h"

static unsigned const samplingFrequencyTable[16] = {
  96000, 88200, 64000, 48000,
  44100, 32000, 24000, 22050,
  16000, 12000, 11025, 8000,
  7350, 0, 0, 0
};
// ---------------------------------
// ADTS ZoneMinder FramedSource
// ---------------------------------
//
ADTS_ZoneMinderDeviceSource::ADTS_ZoneMinderDeviceSource(
    UsageEnvironment& env,
    Monitor *monitor,
    AVStream *stream,
    unsigned int queueSize
    )
  :
    ZoneMinderDeviceSource(env, monitor, stream, queueSize),
    samplingFrequencyIndex(0),
    channels(stream->codecpar->channels)
{
  std::ostringstream os;
  os <<
    "profile-level-id=1;"
    "mode=AAC-hbr;sizelength=13;indexlength=3;"
    "indexdeltalength=3"
    //<< extradata2psets(nullptr, m_stream)
    << "\r\n";
  m_auxLine.assign(os.str());    
}
#endif
