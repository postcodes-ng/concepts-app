
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app'
});

// Sets active link in Bootstrap menu
jQuery(document).ready(function() {
	jQuery('a[href="' + this.location.href + '"]').addClass('npc-active-menu-item');
});

