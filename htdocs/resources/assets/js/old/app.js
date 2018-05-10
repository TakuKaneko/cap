
/**
 * jsの基本ページ
 *  - 必ずどの画面でも呼び出される基本のjsファイル
 *  - 初期設定やコンポーネントの準備を行う
 */
import Vue from 'vue'
import router from './router'
import http from './services/http'

require('./bootstrap');

/**
 * コンポーネント一覧
 */
Vue.component('navbar', require('./components/Layouts/Navbar.vue'))
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('hello', require('./components/Hello.vue'));

/**
 * Vueインスタンスの生成
 */
const app = new Vue({
    router,
    el: '#app',
    created () {
        http.init();
    }
}).$mount('#app');
