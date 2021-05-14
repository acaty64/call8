<template>
  <div class="container">
    <h1 class="text-center">VideoChat.vue</h1>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div>Window: {{window}}</div>
            <div>is_host: {{is_host}}</div>
            <div>is_connected: {{is_connected}}</div>
          </div>

          <div class="card-body">
            <div class="video-container" ref="video-container">
              <video class="video-here" ref="video-here" autoplay></video>
              <video class="video-there" ref="video-there" autoplay></video>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div v-if="is_host && is_connected">
                <button @click="startVideoChat(other.id)" v-text="`Conectar con ${other.name}`" class="btn btn-large btn-success"/>
                <button @click="stopWindow()" class="btn btn-large btn-danger">Colgar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <template v-if="is_host">
      <div class="container">
        <div class="card-header">
          <div class="col-md-12">Agregar Consulta y Respuesta actual</div>
          <button @click="saveComments()" class="btn btn-large btn-success">Grabar</button>
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <div class="col-sm-12">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Consulta del estudiante</span>
                <textarea  v-model="client_comment" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="col-sm-12">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Respuesta del operador</span>
                <textarea  v-model="host_comment" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="card-header">
          <div class="col-md-12">Consultas y Respuestas anteriores (últimas 5)</div>
        </div>
        <div v-for="comment in comments">
          <div class="card">
            <div class="row">
              <div class="card col-md-12">
                  <h3>{{ comment.date }}</h3>
              </div>
              <div class="card col-md-6">
                 <b>{{ comment.client }}</b>
                {{ comment.client_comment }}
              </div>
              <div class="card col-md-6">
                <b>{{ comment.host }}</b>
                {{ comment.host_comment }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
export default {
  props: ['user', 'other', 'call', 'pusherKey', 'pusherCluster'],
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      start: false,
      is_host: this.user.is_host,
      is_connected: false,
      window: this.user.window,
      call_id: null,
      comments: null,
      client_comment: '',
      host_comment: '',
    }
  },
  mounted() {
    this.getPermissions();
    this.setupVideoChat();
    this.getListeners();
    this.call_id = this.call.id;
    this.getComments();
  },
  watch: {
    channel: {
      deep: true,
      handler(){
        if(this.channel.members.get(this.other.id) != null){
          this.is_connected = true;
        }else{
          console.log('watch channel this.channel not exist');
        }
      }
    }
  },
  methods: {
    saveComments(){
      var URLdomain = window.location.host;
      var protocol = window.location.protocol;
      var url = protocol+'//'+URLdomain+'/api/save-comments';
      console.log('saveComments url: ', url);
      var request = {
        host_id: this.user.id,
        client_id: this.other.id,
        call_id: this.call.id,
        client_comment: this.client_comment,
        host_comment: this.host_comment,
      };
      console.log('Data post for save', request);
      axios.post(url, request)
        .then(response => {
            console.log('Get Comments received:', response.data);
            this.comments = response.data.comments;
            this.client_comment = '';
            this.host_comment = '';
          })
          .catch(function (error) {
              console.log('error getComments', error);
          });
    },
    getComments(){
      var URLdomain = window.location.host;
      var protocol = window.location.protocol;
      var url = protocol+'//'+URLdomain+'/api/get-comments/' + this.call_id;
      console.log('getComments url: ', url);
      axios.get(url)
        .then((response) => {
            console.log('Get Comments received:', response.data);
            this.comments = response.data;
          })
          .catch(function (error) {
              console.log('error getComments', error);
          });
    },
    stopWindow(){
      var URLdomain = window.location.host;
      var protocol = window.location.protocol;
      var url = protocol+'//'+URLdomain+'/api/stop-window/' + this.client.id;
      console.log('url: ', url);
      axios.get(url)
        .then((response) => {
            var url2 = protocol+'//'+URLdomain+'/api/send-stop';
            console.log('url2: ???? Hace lo mismo ????', url2);
            axios.get(url2)
              .then((resp) => {
                console.log('stopWindow send-stop');

              })
              .catch(function (err) {
                console.log('err stopWindow 2', err)
              });
            console.log('Get Data received:', response.data);
            window.location.href = '/call/host';
          })
          .catch(function (error) {
              console.log('error stopWindow', error);
          });
    },
    getListeners(){
      if(!this.is_host){
        window.Echo.private("channel-ring").listen("Ring2Event", e => {
          console.log('getListeners Pusher', e);
            if(!e.call){
              window.location.href = '/call/client';
            }
          // this.start = true;
        });
      }
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
