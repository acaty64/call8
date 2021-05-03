<template>
  <div class="container">
    <h1 class="text-center">Video Chat</h1>

    <div class="video-container" ref="video-container">
      <video class="video-here" ref="video-here" autoplay></video>
      <video class="video-there" ref="video-there" autoplay></video>
      <div v-if="is_host">
        <button @click="startVideoChat(other.id)" v-text="`Conectar con ${other.name}`"/>
      </div>
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
      is_host: this.user.is_host,
    }
  },
  async mounted() {
    await this.getPermissions();
    await this.setupVideoChat();
    // await this.getListeners();
    // console.log('user.is_host', this.user.is_host);
  },
  watch: {
    channel: {
      deep: true,
      handler(){
        if(this.channel != null){
          console.log('watch channel this.channel not null');
          console.log('watch channel members count', this.channel.members.count);
          console.log('watch channel member [user]', this.channel.members.get(this.user.id));
          console.log('watch channel members [other]', this.channel.members.get(this.other.id));
        }else{
          console.log('watch channel this.channel not exist');
        }
      }
      // console.log('watch channel members', this.channel['members'].members);
    }
  },
  methods: {
    getListeners(){
      window.Echo.private("presence-video-chat").listen("video-chat", e => {
        console.log('getListeners Pusher', e);
        console.log('getListeners members.members', this.members.members);
        // this.start = true;
      });
    },
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
      this.channel = pusher.subscribe('presence-video-chat');
      this.channel.bind(`client-signal-${this.user.id}`, (signal) =>
      {
        const peer = this.getPeer(signal.userId, false);
        peer.signal(signal.data);
      });
console.log('setupVideoChat this.channel.members: ', this.channel.members);
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
