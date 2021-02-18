/*
 * ZoneMinder FFMPEG implementation, $Date$, $Revision$
 * Copyright (C) 2001-2008 Philip Coombes
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

#include "zm_swscale.h"

#include "zm_image.h"
#include "zm_logger.h"

#if HAVE_LIBSWSCALE && HAVE_LIBAVUTIL
SWScale::SWScale() : gotdefaults(false), swscale_ctx(nullptr), input_avframe(nullptr), output_avframe(nullptr) {
  Debug(4, "SWScale object created");
}

bool SWScale::init() {
  /* Allocate AVFrame for the input */
#if LIBAVCODEC_VERSION_CHECK(55, 28, 1, 45, 101)
  input_avframe = av_frame_alloc();
#else
  input_avframe = avcodec_alloc_frame();
#endif
  if ( input_avframe == nullptr ) {
    Error("Failed allocating AVFrame for the input");
    return false;
  }

  /* Allocate AVFrame for the output */
#if LIBAVCODEC_VERSION_CHECK(55, 28, 1, 45, 101)
  output_avframe = av_frame_alloc();
#else
  output_avframe = avcodec_alloc_frame();
#endif
  if ( output_avframe == nullptr ) {
    Error("Failed allocating AVFrame for the output");
    return false;
  }
  return true;
}

SWScale::~SWScale() {

  /* Free up everything */
  if ( input_avframe )
    av_frame_free(&input_avframe);

  if ( output_avframe )
    av_frame_free(&output_avframe);

  if ( swscale_ctx ) {
    sws_freeContext(swscale_ctx);
    swscale_ctx = nullptr;
  }

  Debug(4, "SWScale object destroyed");
}

int SWScale::SetDefaults(
    enum _AVPIXELFORMAT in_pf,
    enum _AVPIXELFORMAT out_pf,
    unsigned int width,
    unsigned int height) {

  /* Assign the defaults */
  default_input_pf = in_pf;
  default_output_pf = out_pf;
  default_width = width;
  default_height = height;

  gotdefaults = true;

  return 0;
}

int SWScale::Convert( 
  AVFrame *in_frame,
  AVFrame *out_frame
) {

  // THe J formats are deprecated, so we need to convert
  AVPixelFormat format;
  switch ( in_frame->format ) {
    case AV_PIX_FMT_YUVJ420P :
      format = AV_PIX_FMT_YUV420P;
      break;
    case AV_PIX_FMT_YUVJ422P  :
      format = AV_PIX_FMT_YUV422P;
      break;
    case AV_PIX_FMT_YUVJ444P   :
      format = AV_PIX_FMT_YUV444P;
      break;
    case AV_PIX_FMT_YUVJ440P :
      format = AV_PIX_FMT_YUV440P;
      break;
    default:
      format = (AVPixelFormat)in_frame->format;
      break;
  }
  /* Get the context */
  swscale_ctx = sws_getCachedContext(swscale_ctx,
      in_frame->width, in_frame->height, format,
      out_frame->width, out_frame->height, (AVPixelFormat)out_frame->format,
      SWS_FAST_BILINEAR, NULL, NULL, NULL);
  if ( swscale_ctx == NULL ) {
    Error("Failed getting swscale context");
    return -6;
  }
  /* Do the conversion */
  if ( !sws_scale(swscale_ctx, in_frame->data, in_frame->linesize, 0, in_frame->height, out_frame->data, out_frame->linesize ) ) {
    Error("swscale conversion failed");
    return -10;
  }

  return 0;
}

int SWScale::Convert(
    const uint8_t* in_buffer,
    const size_t in_buffer_size,
    uint8_t* out_buffer,
    const size_t out_buffer_size,
    enum _AVPIXELFORMAT in_pf,
    enum _AVPIXELFORMAT out_pf,
    unsigned int width,
    unsigned int height,
    unsigned int new_width,
    unsigned int new_height
    ) {
  Debug(1, "Convert: in_buffer %p in_buffer_size %d out_buffer %p size %d width %d height %d width %d height %d", 
      in_buffer, in_buffer_size, out_buffer, out_buffer_size, width, height, new_width, new_height);
  /* Parameter checking */
  if ( in_buffer == nullptr ) {
    Error("NULL Input buffer");
    return -1;
  }
  if ( out_buffer == nullptr ) {
    Error("NULL output buffer");
    return -1;
  }
  //  if(in_pf == 0 || out_pf == 0) {
  //    Error("Invalid input or output pixel formats");
  //    return -2;
  //  }
  if ( !width || !height || !new_height || !new_width ) {
    Error("Invalid width or height");
    return -3;
  }

  // THe J formats are deprecated, so we need to convert
  switch ( in_pf ) {
    case AV_PIX_FMT_YUVJ420P :
      in_pf = AV_PIX_FMT_YUV420P;
      break;
    case AV_PIX_FMT_YUVJ422P  :
      in_pf = AV_PIX_FMT_YUV422P;
      break;
    case AV_PIX_FMT_YUVJ444P   :
      in_pf = AV_PIX_FMT_YUV444P;
      break;
    case AV_PIX_FMT_YUVJ440P :
      in_pf = AV_PIX_FMT_YUV440P;
      break;
    default:
      break;
  }

#if LIBSWSCALE_VERSION_CHECK(0, 8, 0, 8, 0)
  /* Warn if the input or output pixelformat is not supported */
  if ( !sws_isSupportedInput(in_pf) ) {
    Warning("swscale does not support the input format: %c%c%c%c",
        (in_pf)&0xff,((in_pf)&0xff),((in_pf>>16)&0xff),((in_pf>>24)&0xff));
  }
  if ( !sws_isSupportedOutput(out_pf) ) {
    Warning("swscale does not support the output format: %c%c%c%c",
        (out_pf)&0xff,((out_pf>>8)&0xff),((out_pf>>16)&0xff),((out_pf>>24)&0xff));
  }
#endif

  /* Check the buffer sizes */
  size_t insize = GetBufferSize(in_pf, width, height);
  if ( insize != in_buffer_size ) {
    Debug(1, "The input buffer size does not match the expected size for the input format. Required: %d Available: %d", insize, in_buffer_size);
  }
  size_t outsize = GetBufferSize(out_pf, new_width, new_height);
  if ( outsize < out_buffer_size ) {
    Error("The output buffer is undersized for the output format. Required: %d Available: %d", outsize, out_buffer_size);
    return -5;
  }

  /* Get the context */
  swscale_ctx = sws_getCachedContext(
      swscale_ctx, width, height, in_pf, new_width, new_height,
      out_pf, SWS_FAST_BILINEAR, nullptr, nullptr, nullptr);
  if ( swscale_ctx == nullptr ) {
    Error("Failed getting swscale context");
    return -6;
  }

  /* Fill in the buffers */
#if LIBAVUTIL_VERSION_CHECK(54, 6, 0, 6, 0)
  if ( av_image_fill_arrays(input_avframe->data, input_avframe->linesize,
                           (uint8_t*) in_buffer, in_pf, width, height, 1) <= 0) {
#else
  if (avpicture_fill((AVPicture*) input_avframe, (uint8_t*) in_buffer,
                     in_pf, width, height) <= 0) {
#endif
    Error("Failed filling input frame with input buffer");
    return -7;
  }
#if LIBAVUTIL_VERSION_CHECK(54, 6, 0, 6, 0)
  if ( av_image_fill_arrays(output_avframe->data, output_avframe->linesize,
                           out_buffer, out_pf, new_width, new_height, 1) <= 0) {
#else
  if ( avpicture_fill((AVPicture*) output_avframe, out_buffer, out_pf, new_width,
                     new_height) <= 0) {
#endif
    Error("Failed filling output frame with output buffer");
    return -8;
  }

  /* Do the conversion */
  if ( !sws_scale(swscale_ctx,
        input_avframe->data, input_avframe->linesize,
        0, height, output_avframe->data, output_avframe->linesize ) ) {
    Error("swscale conversion failed");
    return -10;
  }

  return 0;
}

int SWScale::Convert(
    const uint8_t* in_buffer,
    const size_t in_buffer_size,
    uint8_t* out_buffer,
    const size_t out_buffer_size,
    enum _AVPIXELFORMAT in_pf,
    enum _AVPIXELFORMAT out_pf,
    unsigned int width,
    unsigned int height) {
  return Convert(in_buffer, in_buffer_size, out_buffer, out_buffer_size, in_pf, out_pf, width, height, width, height);
}

int SWScale::Convert(
    const Image* img,
    uint8_t* out_buffer,
    const size_t out_buffer_size,
    enum _AVPIXELFORMAT in_pf,
    enum _AVPIXELFORMAT out_pf,
    unsigned int width,
    unsigned int height) {
  if ( img->Width() != width ) {
    Error("Source image width differs. Source: %d Output: %d", img->Width(), width);
    return -12;
  }

  if ( img->Height() != height ) {
    Error("Source image height differs. Source: %d Output: %d", img->Height(), height);
    return -13;
  }

  return Convert(img->Buffer(), img->Size(), out_buffer, out_buffer_size, in_pf, out_pf, width, height);
}

int SWScale::ConvertDefaults(const Image* img, uint8_t* out_buffer, const size_t out_buffer_size) {

  if ( !gotdefaults ) {
    Error("Defaults are not set");
    return -24;
  }

  return Convert(img,out_buffer,out_buffer_size,default_input_pf,default_output_pf,default_width,default_height);
}

int SWScale::ConvertDefaults(const uint8_t* in_buffer, const size_t in_buffer_size, uint8_t* out_buffer, const size_t out_buffer_size) {

  if ( !gotdefaults ) {
    Error("Defaults are not set");
    return -24;
  }

  return Convert(in_buffer,in_buffer_size,out_buffer,out_buffer_size,default_input_pf,default_output_pf,default_width,default_height);
}

size_t SWScale::GetBufferSize(enum _AVPIXELFORMAT pf, unsigned int width, unsigned int height) {
#if LIBAVUTIL_VERSION_CHECK(54, 6, 0, 6, 0)
  return av_image_get_buffer_size(pf, width, height, 32);
#else
  return outsize = avpicture_get_size(pf, width,height);
#endif
}
#endif // HAVE_LIBSWSCALE && HAVE_LIBAVUTIL
