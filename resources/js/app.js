require('./bootstrap');

import Vue from 'vue'


Vue.component(
    'games-list', require('./vue/Games.vue'),
);

const app = new Vue({
    el: "#app",
    components:[
        "games-list",
    ]
})