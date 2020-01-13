require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import storeData from './store';
import {routes} from './routes';
import vueApp from './components/App.vue'; 
import swal from 'sweetalert';
import Notification from "./components/Elements/Notifications/Index.vue";
import SearchForm from "./components/Search/TopBar/Form.vue";
Vue.use(VueRouter);
Vue.use(Vuex);
 
const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
  	if (to.matched.some(record => record.meta.requiresAuth)) {
    	if (!store.getters.loggedIn) {
      		next({
        		path: '/login'
      		})
    	} 
    	else {
      	     next()
    	}
  	}
  	else if (to.matched.some(record => record.meta.guests)) {
    	if (store.getters.loggedIn) {
      		next({
        		path: '/dashboard'
      		})
    	} 
    	else {
      		next()
    	}
  	} 
  	else {
    	next() // make sure to always call next()!
  	}
});
 
router.beforeEach((to, from, next) => {
     if (to.name=='UserEdit' ) {

        if (to.params.id==localStorage.getItem('username')) {
          next()
        }
        else{
          next({path:'/404'})
        }
     }
     else{
      next();
     }

          if ( to.name=='chatUser') {

        if (to.params.id==localStorage.getItem('username')) {
           next({path:'/404'})
        }
        else{
          next( )
        }
     }
     else{
      next();
     }
   
    
});
const store =new Vuex.Store(storeData);
export const eventBus = new Vue();
const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
    	'main-app':vueApp,
      'notification-list':Notification,
      'search-form':SearchForm
    },
    computed: {
      currentRouteName() {
          return this.$route.name;
      },
      username(){
        return this.$store.getters.authuser.username;
      },
      authuser(){
        if (this.$store.getters.authuser) {
          return this.$store.getters.authuser;
        }
        else{
          return '';
        }
      }
  
    },
    created(){
       
    }
  
});
 
