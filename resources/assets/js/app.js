
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('chat-personal-component', require('./components/chat/ChatPersonalComponent.vue'));
Vue.component('chat-component', require('./components/chat/ChatComponent.vue'));
Vue.component('chat-conversation-component', require('./components/chat/ChatConversationComponent.vue'));
Vue.component('chat-room-component', require('./components/chat/ChatRoomComponent.vue'));
Vue.component('chat-room-list-component', require('./components/chat/ChatRoomListComponent.vue'));
Vue.component('chat-room-search-component', require('./components/chat/ChatRoomSearchComponent.vue'));
Vue.component('chat-room-action-component', require('./components/chat/ChatRoomActionComponent.vue'));
Vue.component('chat-room-invitation-component', require('./components/chat/ChatRoomInvitationComponent.vue'));
Vue.component('chat-room-group-invitation-component', require('./components/chat/ChatRoomInvitationComponent.vue'));
Vue.component('message-composer-component', require('./components/chat/MessageComposerComponent.vue'));

Vue.component('notification-component', require('./components/notification/NotificationComponent.vue'));
Vue.component('notification-toogle-component', require('./components/notification/NotificationToogleComponent.vue'));

const app = new Vue({
    el: '#app',
});


const notif = new Vue({
    el: '#notif',
});

const notifToogle = new Vue({
    el: '#notifToogle',
});