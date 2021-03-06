/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('test1-component', require('./components/Test1Component.vue').default);
Vue.component('test2-component', require('./components/Test2Component.vue').default);
Vue.component('test3-component', require('./components/Test3Component.vue').default);
Vue.component('video-chat', require('./components/VideoChat.vue').default);
Vue.component('web-rtc', require('./components/WebRTCComponent.vue').default);
Vue.component('web-rtc_1', require('./components/WebRTCComponent_1.vue').default);
Vue.component('jitsi-chat', require('./components/JitsiChat.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
