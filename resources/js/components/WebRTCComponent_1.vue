<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">WebRTC.vue</div>

                    <div class="card-body">
                        <div class="video-container" ref="video-container">
                            <video class="video-here" ref="video-here" autoplay playsinline></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.init();
        },
        data() {
            return {
                // On this codelab, you will be streaming only video (video: true).
                'mediaStreamConstraints': {
                    video: true,
                    audio: false
                },
                // Video element where stream will be placed.
                //document.querySelector('video'),
                // Local stream that will be reproduced on the video.
                'localStream': {},

                'localVideo': "",
            }
        },
        methods: {
            // Handles success by adding the MediaStream to the video element.
            gotLocalMediaStream(mediaStream) {
              // this.localStream = mediaStream;
              this.localVideo.srcObject = mediaStream;
            },
            // Handles error by logging a message to the console with the error message.
            handleLocalMediaStreamError(error) {
              console.log('navigator.getUserMedia error: ', error);
            },
            async init() {

                // return new Promise((res, rej) => {
                //     navigator.mediaDevices.getUserMedia(this.mediaStreamConstraints)
                //     .then((stream) => {
                //         res(stream);
                //     })
                //     .catch(err => {
                //     throw new Error('Unable to fetch stream ${err}');
                //     })
                // });

                // Initializes media stream.
                await navigator.mediaDevices.getUserMedia(this.mediaStreamConstraints)
                    .then( (mediaStream) => {
                        this.localVideo = this.$refs['video-here'];
                        this.gotLocalMediaStream(mediaStream);
                    }).catch( (error) => {
                        this.handleLocalMediaStreamError(error);
                    });


                // navigator.mediaDevices.getUserMedia(this.mediaStreamConstraints)
                //   .then(this.gotLocalMediaStream()).catch(this.handleLocalMediaStreamError);
            },
        },


    }
</script>

<style type="text/css">
body {
  font-family: sans-serif;
}

.video-container {
  width: 500px;
  height: 380px;
  margin: 8px auto;
  border: 3px solid #000;
  position: relative;
  box-shadow: 1px 1px 1px #9e9e9e;
}

.video-here {
  width: 130px;
  position: absolute;
  left: 10px;
  bottom: 16px;
  border: 1px solid #000;
  border-radius: 2px;
  z-index: 2;
}
</style>
