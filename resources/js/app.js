/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Highcharts = require('highcharts');
require('highcharts/modules/venn')(Highcharts)


window.Vue = require('vue');
require('./Element.js');

import JsonExcel from 'vue-json-excel'

Vue.component('downloadExcel', JsonExcel);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('App', require('./components/App.vue').default);

Vue.component('downloadExcel', JsonExcel)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

$(document).ready(function () {
    var citizens = [];
    var sets = [{sets: ['A'], size: 12},
        {sets: ['B'], size: 12},
        {sets: ['A', 'B'], size: 2}];

    // var chart = venn.VennDiagram()
    // d3.select("#venn").datum(citizens).call(chart);
})
