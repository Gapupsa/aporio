
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//iCheck for checkbox and radio inputs
$(function () {
    // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    //     checkboxClass: 'icheckbox_minimal-blue',
    //     radioClass   : 'iradio_minimal-blue'
    // })

    // $('resepDokter[type=checkbox].iCheck').on('ifChecked', function(event){
    //     window.isResepDokter =  true;
    // });
    // $('resepDokter[type=checkbox].iCheck').on('ifUnchecked', function(event){
    //     window.isResepDokter =  false;
    // });
    // $('narkotika[type=checkbox].iCheck').on('ifChecked', function(event){
    //     window.isNarkotika =  true;
    // });
    // $('narkotika[type=checkbox].iCheck').on('ifUnchecked', function(event){
    //     window.isNarkotika =  false;
    // });
})

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//vue filter currency
import VueCurrencyFilter from 'vue-currency-filter';
Vue.use(VueCurrencyFilter,
{
    symbol : 'Rp',
    thousandsSeparator: '.',
    fractionCount: 2,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
});

import VueNumeric from 'vue-numeric'
Vue.use(VueNumeric)

//sweetalert
import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
    toast:true,
    position:'top-end',
    showConfirmButton:false,
    timer:3000
});
window.toast = toast;

import VueRouter from 'vue-router'
Vue.use(VueRouter)

//progressbar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar,{
    color: 'rgb(143,255,199)',
    failedColor: 'red',
    height:'2px'
});

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/products', component: require('./components/products/List.vue') }
]

const router = new VueRouter({
    mode: 'history',
    routes, // short for `routes: routes`,
    linkActiveClass: "active", // active class for non-exact links.
    linkExactActiveClass: "active" // active class for *exact* links.
})

//filter
Vue.filter('aporioDate',function(date){
    return moment(date).format('MMMM Do YYYY');
});

window.Fire = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
