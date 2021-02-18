#include "zm_libvnc_camera.h"

#include "zm_packet.h"
#include <dlfcn.h>

#if HAVE_LIBVNC

static int TAG_0;
static int TAG_1;
static int TAG_2;
static void *libvnc_lib = nullptr;
static void *(*rfbClientGetClientData_f)(rfbClient*, void*) = nullptr;
static rfbClient *(*rfbGetClient_f)(int, int, int) = nullptr;
static void (*rfbClientSetClientData_f)(rfbClient*, void*, void*) = nullptr;
static rfbBool (*rfbInitClient_f)(rfbClient*, int*, char**) = nullptr;
static void (*rfbClientCleanup_f)(rfbClient*) = nullptr;
static int (*WaitForMessage_f)(rfbClient*, unsigned int) = nullptr;
static rfbBool (*HandleRFBServerMessage_f)(rfbClient*) = nullptr;

void bind_libvnc_symbols() {
  if ( libvnc_lib != nullptr ) // Safe-check
    return;
  
  libvnc_lib = dlopen("libvncclient.so", RTLD_LAZY | RTLD_GLOBAL);
  if ( !libvnc_lib ) {
    Error("Error loading libvncclient: %s", dlerror());
    return;
  }

  *(void**) (&rfbClientGetClientData_f) = dlsym(libvnc_lib, "rfbClientGetClientData");
  *(void**) (&rfbGetClient_f) = dlsym(libvnc_lib, "rfbGetClient");
  *(void**) (&rfbClientSetClientData_f) = dlsym(libvnc_lib, "rfbClientSetClientData");
  *(void**) (&rfbInitClient_f) = dlsym(libvnc_lib, "rfbInitClient");
  *(void**) (&rfbClientCleanup_f) = dlsym(libvnc_lib, "rfbClientCleanup");
  *(void**) (&WaitForMessage_f) = dlsym(libvnc_lib, "WaitForMessage");
  *(void**) (&HandleRFBServerMessage_f) = dlsym(libvnc_lib, "HandleRFBServerMessage");
}

static void GotFrameBufferUpdateCallback(rfbClient *rfb, int x, int y, int w, int h) {
  VncPrivateData *data = (VncPrivateData *)(*rfbClientGetClientData_f)(rfb, &TAG_0);
  data->buffer = rfb->frameBuffer;
  Debug(1, "GotFrameBufferUpdateallback x:%d y:%d w%d h:%d width: %d, height: %d, buffer %p",
      x,y,w,h, rfb->width, rfb->height, rfb->frameBuffer);
}

static char* GetPasswordCallback(rfbClient* cl){
  Debug(1, "Getcredentials: %s", (*rfbClientGetClientData_f)(cl, &TAG_1));
  return strdup((const char *)(*rfbClientGetClientData_f)(cl, &TAG_1));
}

static rfbCredential* GetCredentialsCallback(rfbClient* cl, int credentialType){
  rfbCredential *c = (rfbCredential *)malloc(sizeof(rfbCredential));
  if ( credentialType != rfbCredentialTypeUser ) {
    free(c);
    return nullptr;
  }

  Debug(1, "Getcredentials: %s:%s", (*rfbClientGetClientData_f)(cl, &TAG_1), (*rfbClientGetClientData_f)(cl, &TAG_2));
  c->userCredential.password = strdup((const char *)(*rfbClientGetClientData_f)(cl, &TAG_1));
  c->userCredential.username = strdup((const char *)(*rfbClientGetClientData_f)(cl, &TAG_2));
  return c;
}

VncCamera::VncCamera(
    const Monitor *monitor,
    const std::string &host,
    const std::string &port,
    const std::string &user,
    const std::string &pass,
    int p_width,
    int p_height,
    int p_colours,
    int p_brightness,
    int p_contrast,
    int p_hue,
    int p_colour,
    bool p_capture,
    bool p_record_audio ) :
    Camera(
      monitor,
      VNC_SRC,
      p_width,
      p_height,
      p_colours,
      ZM_SUBPIX_ORDER_DEFAULT_FOR_COLOUR(p_colours),
      p_brightness,
      p_contrast,
      p_hue,
      p_colour,
      p_capture,
      p_record_audio
    ),
    mRfb(nullptr),
  mHost(host),
  mPort(port),
  mUser(user),
  mPass(pass)
{
  Debug(2, "Host:%s Port: %s User: %s Pass:%s", mHost.c_str(), mPort.c_str(), mUser.c_str(), mPass.c_str());
  
  if ( colours == ZM_COLOUR_RGB32 ) {
    subpixelorder = ZM_SUBPIX_ORDER_RGBA;
    mImgPixFmt = AV_PIX_FMT_RGBA;
  } else if ( colours == ZM_COLOUR_RGB24 ) {
    subpixelorder = ZM_SUBPIX_ORDER_RGB;
    mImgPixFmt = AV_PIX_FMT_RGB24;
  } else if ( colours == ZM_COLOUR_GRAY8 ) {
    subpixelorder = ZM_SUBPIX_ORDER_NONE;
    mImgPixFmt = AV_PIX_FMT_GRAY8;
  } else {
    Panic("Unexpected colours: %d", colours);
  }

  if ( capture ) {
    Debug(3, "Initializing Client");
    bind_libvnc_symbols();
    scale.init();
  }
}

VncCamera::~VncCamera() {
  if ( capture ) {
    if ( mRfb->frameBuffer )
      free(mRfb->frameBuffer);
    (*rfbClientCleanup_f)(mRfb);
  }
}

int VncCamera::PrimeCapture() {
  Debug(1, "Priming capture from %s", mHost.c_str());

  if (!mRfb) {
    mVncData.buffer = nullptr;
    mVncData.width = 0;
    mVncData.height = 0;

    mBufferSize = SWScale::GetBufferSize(AV_PIX_FMT_RGBA, width, height);

    mRfb = (*rfbGetClient_f)(8 /* bits per sample */, 3 /* samples per pixel */, 4 /* bytes Per Pixel */);
    mRfb->frameBuffer = nullptr;
    //(uint8_t *)av_malloc(mBufferSize); 
    mRfb->canHandleNewFBSize = false;

    (*rfbClientSetClientData_f)(mRfb, &TAG_0, &mVncData);
    (*rfbClientSetClientData_f)(mRfb, &TAG_1, (void *)mPass.c_str());
    (*rfbClientSetClientData_f)(mRfb, &TAG_2, (void *)mUser.c_str());

    mRfb->GotFrameBufferUpdate = GotFrameBufferUpdateCallback;
    mRfb->GetPassword = GetPasswordCallback;
    mRfb->GetCredential = GetCredentialsCallback;

    mRfb->programName = "Zoneminder VNC Monitor";
    mRfb->serverHost = strdup(mHost.c_str());
    mRfb->serverPort = atoi(mPort.c_str());
  }
  if ( ! (*rfbInitClient_f)(mRfb, 0, nullptr) ) {
    /* IF rfbInitClient fails, it calls rdbClientCleanup which will free mRfb */
    Warning("Failed to Prime capture from %s", mHost.c_str());
    mRfb = nullptr;
    return -1; 
  }
  if ( ((unsigned int)mRfb->width != width) or ((unsigned int)mRfb->height != height) ) {
    Warning("Specified dimensions do not match screen size monitor: (%dx%d) != vnc: (%dx%d)",
        width, height, mRfb->width, mRfb->height);
  }
  get_VideoStream();

  return 1;
}

int VncCamera::PreCapture() {
  int rc = (*WaitForMessage_f)(mRfb, 500);
  if ( rc < 0 ) {
    return -1;
  } else if ( !rc ) {
    return rc;
  }
  rfbBool res = (*HandleRFBServerMessage_f)(mRfb);
  Debug(3, "PreCapture rc from HandleMessage %d", res == TRUE ? 1 : -1);
  return res == TRUE ? 1 : -1;
}

int VncCamera::Capture(ZMPacket &zm_packet) {
  if ( !mVncData.buffer ) {
    Debug(1, "No buffer");
    return 0;
  }
  if ( !zm_packet.image ) {
    Debug(1, "Allocating image %dx%d %dcolours = %d", width, height, colours, pixels);
    zm_packet.image = new Image(width, height, colours, subpixelorder);
  }
  zm_packet.keyframe = 1;
  zm_packet.codec_type = AVMEDIA_TYPE_VIDEO;
  zm_packet.packet.stream_index = mVideoStreamId;

  uint8_t *directbuffer = zm_packet.image->WriteBuffer(width, height, colours, subpixelorder);
  int rc = scale.Convert(
      mVncData.buffer,
      mRfb->si.framebufferHeight * mRfb->si.framebufferWidth * 4,
      directbuffer,
      width * height * colours,
      AV_PIX_FMT_RGBA,
      mImgPixFmt,
      mRfb->si.framebufferWidth,
      mRfb->si.framebufferHeight,
      width,
      height);
  return rc == 0 ? 1 : rc;
}

int VncCamera::PostCapture() {
  return 1;
}

int VncCamera::Close() {
  return 1;
}
#endif
