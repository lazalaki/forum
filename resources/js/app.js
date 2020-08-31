/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

let authorizations = require('./authorizations');

window.Vue.prototype.authorize = function(...params) {
    if(!window.App.signedIn) return false;

    if(typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
    
    // const { user } = window.App;
    // return user ? handler(user) : false;
}

Vue.prototype.signedIn = window.App.signedIn

window.events = new Vue();

window.flash = function( message, level = 'success') {
    window.events.$emit('flash', {message, level});
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash-component', require('./components/FlashComponent.vue').default);
Vue.component('thread-component', require('./pages/ThreadComponent.vue').default);
Vue.component('paginator-component', require('./components/PaginatorComponent.vue').default);
Vue.component('user-notification-component', require('./components/UserNotificationComponent.vue').default);
Vue.component('avatar-form-component', require('./components/AvatarFormComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});



