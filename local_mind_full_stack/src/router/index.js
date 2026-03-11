import { createRouter, createWebHistory } from 'vue-router';
// import HomeView from '@/views/HomeView.vue';
// import JobsView from '@/views/JobsView.vue';
import NotFoundView from '@/views/NotFound.vue';
import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';
import Home from '@/views/user/Home.vue';
import AddQuestion from '@/views/user/AddQuestion.vue';
import ViewQuestion from '@/views/user/ViewQuestion.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: Home,
    },
    {
      path: '/question/new',
      name: 'add-question',
      component: AddQuestion,
    },
    {
      path: '/question/:id',
      name: 'view-question',
      component: ViewQuestion,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
        path:'/register',
        name:'register',
        component: Register,
    },
    {
      path: '/:catchAll(.*)',
      name: 'not-found',
      component: NotFoundView,
    },
  ],
});

export default router;