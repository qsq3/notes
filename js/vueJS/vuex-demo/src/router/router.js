import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '../app'
import Index from '../page/index'
import Home from '../page/home'
import Mine from "../page/mine"
import Detail from "../page/detail"
import Orders from "../page/orders"
import Balance from "../page/balance"
import Growup from "../page/grow_up"
import OrderDetail from "../page/orderDetail"
import Pay from "../page/pay"
import mineDetail from "../page/mineDetail"
import RechargeCenter from "../page/rechargeCenter"

Vue.use(VueRouter)

const routes = [{
    path: '/',
    component: App,
    children: [
        { path: '/index', name: 'index', component: Index },
        { path: '/home', name: 'home', component: Home },
        { path: '/mine', name: 'mine', component: Mine },
        { path: '/detail', name: 'detail', component: Detail },
        { path: '/orders', name: 'orders', component: Orders },
        { path: '/balance', name: 'balbace', component: Balance },
        { path: '/grow_up', name: 'grow_up', component: Growup },
        { path: '/orderDetail', name: 'orderDetail', component: OrderDetail },
        { path: '/pay', name: 'pay', component: Pay },
        { path: '/mineDetail', name: 'mineDetail', component: mineDetail },
        { path: '/rechargeCenter', name: 'rechargeCenter', component: RechargeCenter }

        // { path: '/article/:id', name: 'article', component: Article },

    ]
}]
const router = new VueRouter({
        routes: routes, // short for routes: routes
        linkActiveClass: 'active', // router-link的选中状态的class，也有一个默认的值
        history: true
    })
    // router.beforeEach(function(to, from, next) {
    //     var userMsg = localStorage.getItem('userMsg')
    //     if (to.path === '/home') {
    //         if (!userMsg) {
    //             next({ path: '/login' })
    //         }
    //     }
    //     next()
    // })
export default router