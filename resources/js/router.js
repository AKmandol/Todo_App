import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/todo.vue'
import Add from './components/addTodo.vue'



const routes = [

    {
        path: '/',
        component: Home
    },

    {
        path: '/add',
        component: Add
    },
    


]

const router = createRouter({
    history:createWebHistory(process.env.BASE_URL),
    routes,
})

export default router