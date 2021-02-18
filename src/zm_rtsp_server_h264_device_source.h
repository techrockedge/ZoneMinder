/* ---------------------------------------------------------------------------
** This software is in the public domain, furnished "as is", without technical
** support, and with no warranty, express or implied, as to its usefulness for
** any purpose.
**
** H264_ZoneMinderDeviceSource.h
**
** H264 ZoneMinder live555 source
**
** -------------------------------------------------------------------------*/

#ifndef ZM_RTSP_H264_DEVICE_SOURCE_H
#define ZM_RTSP_H264_DEVICE_SOURCE_H

#include "zm_config.h"
#include "zm_rtsp_server_device_source.h"

// ---------------------------------
// H264 ZoneMinder FramedSource
// ---------------------------------
#if HAVE_RTSP_SERVER
class H26X_ZoneMinderDeviceSource : public ZoneMinderDeviceSource {
	protected:
		H26X_ZoneMinderDeviceSource(
        UsageEnvironment& env,
        std::shared_ptr<Monitor> monitor,
        AVStream *stream,
        unsigned int queueSize,
        bool repeatConfig,
        bool keepMarker)
			:
        ZoneMinderDeviceSource(env, std::move(monitor), stream, queueSize),
        m_repeatConfig(repeatConfig),
        m_keepMarker(keepMarker),
        m_frameType(0) { }

		virtual ~H26X_ZoneMinderDeviceSource() {}

		virtual unsigned char* extractFrame(unsigned char* frame, size_t& size, size_t& outsize);
    virtual unsigned char* findMarker(unsigned char *frame, size_t size, size_t &length);

	protected:
		std::string m_sps;
		std::string m_pps;
		bool        m_repeatConfig;
		bool        m_keepMarker;
		int         m_frameType;
};

class H264_ZoneMinderDeviceSource : public H26X_ZoneMinderDeviceSource {
	public:
		static H264_ZoneMinderDeviceSource* createNew(
				UsageEnvironment& env,
				std::shared_ptr<Monitor> monitor,
				AVStream *stream,
				unsigned int queueSize,
				bool repeatConfig,
				bool keepMarker) {
			return new H264_ZoneMinderDeviceSource(env, std::move(monitor), stream, queueSize, repeatConfig, keepMarker);
		}

	protected:
		H264_ZoneMinderDeviceSource(
        UsageEnvironment& env,
        std::shared_ptr<Monitor> monitor,
        AVStream *stream,
        unsigned int queueSize,
        bool repeatConfig,
        bool keepMarker);

		// overide ZoneMinderDeviceSource
		virtual std::list< std::pair<unsigned char*,size_t> > splitFrames(unsigned char* frame, unsigned frameSize);
};

class H265_ZoneMinderDeviceSource : public H26X_ZoneMinderDeviceSource {
	public:
		static H265_ZoneMinderDeviceSource* createNew(
        UsageEnvironment& env,
        std::shared_ptr<Monitor> monitor,
        AVStream *stream,
        unsigned int queueSize,
        bool repeatConfig,
        bool keepMarker) {
			return new H265_ZoneMinderDeviceSource(env, std::move(monitor), stream, queueSize, repeatConfig, keepMarker);
		}

	protected:
		H265_ZoneMinderDeviceSource(
        UsageEnvironment& env,
        std::shared_ptr<Monitor> monitor,
        AVStream *stream,
        unsigned int queueSize,
        bool repeatConfig,
        bool keepMarker);

		// overide ZoneMinderDeviceSource
		virtual std::list< std::pair<unsigned char*,size_t> > splitFrames(unsigned char* frame, unsigned frameSize);

	protected:
		std::string m_vps;
};
#endif // HAVE_RTSP_SERVER

#endif // ZM_RTSP_H264_DEVICE_SOURCE_H
