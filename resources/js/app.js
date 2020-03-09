require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App';
import MessagesList from './views/MessagesList';
import MessagesView from './views/MessagesView';
import MessagesAdd from './views/MessagesAdd';
import MessagesEdit from './views/MessagesEdit';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'messages.list',
            component: MessagesList
        },
        {
            path: '/viewMessage',
            name: 'messages.view',
            component: MessagesView,
        },
        {
            path: '/addMessage',
            name: 'messages.add',
            component: MessagesAdd,
        },
        {
            path: '/editMessage',
            name: 'messages.edit',
            component: MessagesEdit,
        },
        { path: '*', redirect: '/' }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    render: h => h(App),
});