import { createRouter, createWebHistory } from 'vue-router'
import Home from './components/Home'
import PostsShow from './components/PostsShow'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/posts/:slug', name: 'posts.show', component: PostsShow, props: true },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})
