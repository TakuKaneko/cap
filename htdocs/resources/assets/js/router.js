
/**
 * SAPのルーター(Vue-router)
 *  - httpリクエストはすべてここで受けてルーティングする
 *  - アクセスURLにあわせて必要なコンポーネントを呼び出す
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: require('./components/About.vue') },
        { path: '/about', component: require('./components/About.vue') },
        { path: '/login', component: require('./components/Login.vue') },
    ],
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
          return savedPosition
        } else {
          return { x: 0, y: 0 }
        }
    },
});