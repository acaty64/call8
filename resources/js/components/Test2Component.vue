<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tests Private-Channel</div>
                    <div class="card-body">
                        <button class="btn btn-success" @click.prevent="send">Prueba private-channel</button>
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
        name: "Test2Component",

        mounted() {
            console.log('Component mounted.');
            this.getTest();
            this.listener();
        },
        data() {
        	return {
        		'messages' : {},
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
                var request = {data:'Este es un mensaje de prueba private-channel'};
                var URLdomain = window.location.host;
                var protocol = window.location.protocol;
                var url = protocol+'//'+URLdomain+'/api/send2-test';
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
                console.log('methods Private-Channel listener() waiting');
                window.Echo.private('private-channel')
                    .listen('Test2Event',  (data)=>{
                    console.log('Channel private-channel Test2Event listener', data);
					this.messages.unshift(data.message);
                });
            }
        }
    }
</script>
