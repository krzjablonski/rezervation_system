
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

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
      check_in: '',
      check_out: '',
      rooms: {},
      search: true,
      selectedRoomId: '',
      selectedRoomName: ''
    },
    methods: {
      getAvRooms: function(){
        axios.post('/api/rooms', {
          check_in: this.check_in,
          check_out: this.check_out
        }).then((response)=>{
          this.rooms = response.data.data
          this.search = false
        });
      },
      selectRoom: function(id, name){
        this.selectedRoomId = id
        this.selectedRoomName = name
      },
      resetAll: function(){
        this.check_in = '',
        this.check_out = '',
        this.search = true,
        this.rooms = {},
        this.selectedRoomId = '',
        this.selectedRoomName = ''
      }
    }
});
