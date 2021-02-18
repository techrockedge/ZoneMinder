//ZoneMinder Packet Wrapper Class
//Copyright 2017 ZoneMinder LLC
//
//This file is part of ZoneMinder.
//
//ZoneMinder is free software: you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
//(at your option) any later version.
//
//ZoneMinder is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with ZoneMinder.  If not, see <http://www.gnu.org/licenses/>.


#ifndef ZM_PACKET_H
#define ZM_PACKET_H

#include "zm_logger.h"
#include <mutex>

extern "C" {
#include <libavformat/avformat.h>
}

#ifdef __FreeBSD__
#include <sys/time.h>
#endif // __FreeBSD__

class Image;

class ZMPacket {
  public:
  
    std::recursive_mutex mutex;
    int keyframe;
    AVPacket  packet;             // Input packet, undecoded
    AVFrame   *in_frame;          // Input image, decoded Theoretically only filled if needed.
    AVFrame   *out_frame;         // output image, Only filled if needed.
    struct timeval *timestamp;
    uint8_t   *buffer;            // buffer used in image
    Image     *image;
    Image     *analysis_image;
    int       score;
    AVMediaType codec_type;
    int image_index;
    int codec_imgsize;

  public:
    AVPacket *av_packet() { return &packet; }
    AVPacket *set_packet(AVPacket *p) ;
    AVFrame *av_frame() { return out_frame; }
    Image *get_image(Image *i=nullptr);
    Image *set_image(Image *);

    int is_keyframe() { return keyframe; };
    int decode( AVCodecContext *ctx );
    void reset();
    explicit ZMPacket(Image *image);
    explicit ZMPacket(ZMPacket &packet);
    ZMPacket();
    ~ZMPacket();
    void lock() {
      Debug(4,"Locking packet %d", this->image_index);
      mutex.lock();
      Debug(4,"packet %d locked", this->image_index);
    };
    bool trylock() {
      Debug(4,"TryLocking packet %d", this->image_index);
      return mutex.try_lock();
    };
    void unlock() {
      Debug(4,"packet %d unlocked", this->image_index);
      mutex.unlock();
    };
    AVFrame *get_out_frame( const AVCodecContext *ctx );
    int get_codec_imgsize() { return codec_imgsize; };
};

#endif /* ZM_PACKET_H */
