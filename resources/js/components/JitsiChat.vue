<template>
  <div class="container">
    <!-- <h1 class="text-center">Video Chat</h1> -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <!-- <div>Window: {{window}}</div> -->
            <div class="row justify-content-center">
              <div class="col-3">
              </div>
              <div class="col-6">
                  Haga click en <span style = "color: #ff0000; font-size: 18px;"> Iniciar en el navegador</span>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-3">
              </div>
              <div class="col-6">
                 y luego en <span style = "color: #ff0000; font-size: 18px;"> Entrar a la reunión</span>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="row justify-content-center">
                <div class="col-3">
                </div>
                <div class="col-6">
                  <div>Operador: {{window.host_name}}</div>
                  <div>Atendiendo a: {{window.client_name}}</div>
                </div>
                <div class="col-3">
                </div>
            </div>
          </div>
          <div class="card">
            <div>Call.id: {{ call.id }}</div>
          </div>
          <div class="card">
            <div class="video-container" id="meet"></div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div v-if="is_host && is_connected">
                <button @click="startVideoChat(other.id)" v-text="`Conectar con ${other.name}`" class="btn btn-large btn-success"/>
              </div>
              <div v-if="is_host">
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
          <div class="row">
            <h1>CONSULTAS DEL ESTUDIANTE</h1>
          </div>
          <div class="row">
            <div class="col-md-6">Agregar Consulta y Respuesta actual</div>
            <div class="col-md-6">
              <button @click="saveComments()" class="btn btn-large btn-success">Grabar textos</button>
            </div>
          </div>
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
        <div class="card-header">
          <div class="col-md-12"><h1>DOCUMENTOS DE REFERENCIA</h1></div>
        </div>
        <div class="card">
          <div class="container">
            <div v-for="doc in documents">
              <div class="col-md-6">
                <a @click="change_link(doc)" class="form-control">{{ doc['name'] }}</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body" v-if="link != null">
          <h1>{{link_name}}</h1>
          <iframe :src="link" type="application/pdf" style="width: 100%; height:50vw; position: relative; allowfullscreen;display:block; width:100%; border:none; "></iframe>
        </div>
      </div>
    </template>
  </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
export default {
  props: ['user', 'other', 'call', 'documents'],
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      start: false,
      is_host: this.user.is_host,
      is_connected: false,
      window: this.user.window,
      call_id: this.call.id,
      comments: null,
      client_comment: '',
      host_comment: '',
      options: {},
      domain: 'meet.jit.si',
      host_name: "",
      client_name: "",
      link: null,
      link_name: null,
    }
  },
  mounted() {
    this.getData();
    this.startVideoChat();
    this.getListeners();
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
    },
  },
  methods: {
    change_link(doc){
      this.link = doc['link'];
      this.link_name = doc['name'];
    },

    getData(){
      this.room = 'ucss_' + this.window.id + '_' + this.call_id;
      this.options = {
          roomName: this.room,
          width: 450 ,
          height: 450,
          parentNode: document.querySelector('#meet'),
          userInfo: {
              displayName: this.user.name
          },
          // 'interfaceConfigOverwrite': { 'TOOLBAR_BUTTONS': [] },
      };
    },
    getListeners(){
        window.Echo.channel("channel-ring-" + this.call.id).listen("Ring2Event", e => {
          // console.log('getListeners Pusher', e);
          // console.log('this.call', this.call);
          // console.log('e.message', e.message);
          if(e.message.substring(0,17) == 'Llamada terminada')
          {
            if(this.is_host){
              window.location.href = '/call/host';
            }else{
              window.location.href = '/call/client';
            }
          }
        });
    },
    async startVideoChat() {
      const api = new JitsiMeetExternalAPI(this.domain, this.options);
    },
    closeWindow(){
      // Redirige a ruta call
      if(this.is_host){
        // router.push('/call/host');
        window.location.href = '/call/host';
      }
      window.location.href = '/call/client';
      // router.push('/call/client');
    },
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
      var url = protocol+'//'+URLdomain+'/api/stop-window/' + this.user.id;
      console.log('url: ', url);
      axios.get(url)
        .then((response) => {
            console.log('Get Data received:', response.data);
            window.location.href = '/call/host';
          })
          .catch(function (error) {
              console.log('error stopWindow', error);
          });
    },


  }
};
</script>
<style>
.video-container {
  width: 450px;
  height: 450px;
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
