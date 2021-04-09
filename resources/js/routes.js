import Vue from 'vue';
import Router from 'vue-router';
import VuePageTransition from 'vue-page-transition';
Vue.use(VuePageTransition)
Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            component: require('./components/Home.vue').default,
            props: true
        },

    

        {
            path: '/problem-1'
            , component: require('./components/PaddleLeague.vue').default,
            
        },
        
        {
            path: '/problem-2'
            , component: require('./components/QueenAttack.vue').default,
            
        }
        ,
        
        {
            path: '/problem-3'
            , component: require('./components/StringValue.vue').default,
            
        }
      
    ],
    linkExactActiveClass: 'active',
    mode: 'history',
    scrollBehavior(){
        return {x:0, y:0}
    }
});