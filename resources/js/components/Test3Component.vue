<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tests Presence-Channel</div>
                    <span v-show="userTyping">{{userTyping}} is typing ..</span>
                    <textarea class="form-control" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" @keydown="typingComment"></textarea>
                    <div class="card-body">
                        <button class="btn btn-success" @click.prevent="send">Prueba presence-channel</button>
                    </div>
                    <div class="card-body" v-for="message in messages">
                    	{{message}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Test3Component",

        mounted() {
            console.log('Component Presence mounted.');
            this.getTest();
            this.listener();
        },
        props: ['user'],
        data() {
        	return {
        		'messages' : {},
                'commentBox': '',
                'userTyping': false
        	}
        },
        methods: {
            getTest(){
                var URLdomain = window.location.host;
                var protocol = window.location.protocol;
                var url = protocol+'//'+URLdomain+'/api/get-test';
                console.log('url: ', url);
                axios.get(url)
                    .then((response) => {
                        console.log('Get Data received:', response.data);
						this.messages = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            send(){
                var request = {data:this.commentBox};
                var URLdomain = window.location.host;
                var protocol = window.location.protocol;
                var url = protocol+'//'+URLdomain+'/api/send3-test';
                console.log('send url: ', url);
                console.log('send request: ', request);
                axios.post(url, request)
                    .then((response) => {
                        console.log('Send response:', response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listener(){
                Echo.join('presence-channel')
                    .here((users) => {
                        // Se ejecuta cuando el canal esta unido => obtenemos un array con los usuarios conectados
                        console.log('Here');
                        console.log(users);
                    })
                    .joining((user) => {
                        // Se ejecuta cuando un nuevo usuario se conecta
                        console.log('Joining');
                        console.log(user);
                    })
                    .leaving ((user) => {
                        // Se ejecuta cuando un usuario se desconecta
                        console.log('Leaving');
                        console.log(user);
                    })
                    .listen('Test3Event', (data) => {
                        console.log('Listen Echo: ');
                        console.log(data);
                        this.messages.unshift(data.message);
                    })
                    .listenForWhisper('typing', (user) => {
                        console.log('Listen typingComment', user);
                        console.log('Listen typingComment user.name', user.name);
                        this.userTyping = user.name;
                        setTimeout(() => this.userTyping = false, 2000)
                    })
            },
            typingComment() {
                console.log('typingComment', this.user);
                Echo.join('presence-channel').whisper('typing', this.user)
            },
        }
    }
</script>
