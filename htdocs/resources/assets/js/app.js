
/**
 * jsの基本ページ
 *  - 必ずどの画面でも呼び出される基本のjsファイル
 *  - 初期設定やコンポーネントの準備を行う
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap')

Vue.use(VueRouter)

// コンポーネント一覧
Vue.component('navbar', require('./components/Layouts/Navbar.vue'))
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('hello', require('./components/Hello.vue'));

// ルーティング
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: require('./components/Dashboard/Index.vue') },
        { path: '/about', component: require('./components/About.vue') },
    ]
})

/**
 * Vueインスタンスの生成
 */
const app = new Vue({
    router,
    el: '#app'
})
// const app = new Vue({
//     router,
//     el: '#app',
//     created () {
//         http.init();
//     }
// }).$mount('#app');
