<template>
  <div class="container">
    <h1 class="text-center">Video Chat</h1>

    <div class="video-container" ref="video-container">
      <video class="video-here" ref="video-here" autoplay></video>
      <video class="video-there" ref="video-there" autoplay></video>

      <button @click="startVideoChat(other.id)" v-text="`Conectar con ${other.name}`"/>
    </div>
  </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
export default {
  props: ['user', 'other','pusherKey', 'pusherCluster'],
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      start: false,
    }
  },
  async mounted() {
    await this.getPermissions();
    await this.setupVideoChat();
  },
  methods: {
    getPermissions() {
// console.log('getPermissions');
      return new Promise((res, rej) => {
        navigator.mediaDevices.getUserMedia({video: true, audio: true})
        .then((stream) => {
          res(stream);
        })
        .catch(err => {
          throw new Error('Unable to fetch stream ${err}');
        })
      });
    },
    connect(userId) {
// console.log('startVideoChat', userId);
      this.getPeer(userId, true);
console.log('Conectado: ', userId);
    },
    startVideoChat(userId) {
// console.log('startVideoChat', userId);
      this.getPeer(userId, true);
    },
    getPeer(userId, initiator) {
// console.log('getPeer 1', [userId, initiator]);
      if(this.peers[userId] === undefined) {
        let peer = new Peer({
          initiator,
          stream: this.stream,
          trickle: false
        });
// console.log('getPeer 1', peer);
        peer.on('signal', (data) => {
          this.channel.trigger(`client-signal-${userId}`, {
            userId: this.user.id,
            data: data
          });
        })
        .on('stream', (stream) => {
          const videoThere = this.$refs['video-there'];
          videoThere.srcObject = stream;
        })
        .on('close', () => {
          const peer = this.peers[userId];
          if(peer !== undefined) {
            peer.destroy();
          }
          delete this.peers[userId];
        });
        this.peers[userId] = peer;
      }
      return this.peers[userId];
    },
    async setupVideoChat() {
      // To show pusher errors
      Pusher.logToConsole = true;
      const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
      const videoHere = this.$refs['video-here'];
      videoHere.srcObject = stream;
      this.stream = stream;
      const pusher = this.getPusherInstance();
// console.log('setupVideoChat: ', pusher);
      this.channel = pusher.subscribe('presence-video-chat');
      this.channel.bind(`client-signal-${this.user.id}`, (signal) =>
      {
        const peer = this.getPeer(signal.userId, false);
        peer.signal(signal.data);
      });
      this.start = true;
    },
    getPusherInstance() {
      return new Pusher(this.pusherKey, {
        authEndpoint: '/auth/video_chat',
        cluster: this.pusherCluster,
        auth: {
          headers: {
            'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
          }
        }
      });
    }
  }
};
</script>
<style>
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
.video-there {
  width: 100%;
  height: 100%;
  z-index: 1;
}
.text-right {
  text-align: right;
}
</style>
