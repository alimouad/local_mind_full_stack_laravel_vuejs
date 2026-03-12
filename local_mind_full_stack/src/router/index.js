import { createRouter, createWebHistory } from 'vue-router';
import axiosClient from '@/axios.js';
// import HomeView from '@/views/HomeView.vue';
// import JobsView from '@/views/JobsView.vue';
import NotFoundView from '@/views/NotFound.vue';
import Login from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';
import Home from '@/views/user/Home.vue';
import AdminHome from '@/views/admin/Home.vue';
import AdminQuestions from '@/views/admin/Questions.vue';
import AdminAnswers from '@/views/admin/Answers.vue';
import AdminUsers from '@/views/admin/Users.vue';
import AddQuestion from '@/views/user/AddQuestion.vue';
import ViewQuestion from '@/views/user/ViewQuestion.vue';
import Favourites from '@/views/user/Favourites.vue';

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
      path: '/favorites',
      name: 'favorites',
      component: Favourites,
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
      path: '/admin/home',
      name: 'admin-home',
      component: AdminHome,
    },
    {
      path: '/admin/questions',
      name: 'admin-questions',
      component: AdminQuestions,
    },
    {
      path: '/admin/answers',
      name: 'admin-answers',
      component: AdminAnswers,
    },
    {
      path: '/admin/users',
      name: 'admin-users',
      component: AdminUsers,
    },
    {
      path: '/:catchAll(.*)',
      name: 'not-found',
      component: NotFoundView,
    },
  ],
});

router.beforeEach(async (to) => {
  const isAdminRoute = to.path.startsWith('/admin');

  if (!isAdminRoute) {
    return true;
  }

  try {
    const response = await axiosClient.get('/user');
    const role = response.data?.role ?? 'USER';

    if (role !== 'ADMIN') {
      return { name: 'home' };
    }
    return true;
  } catch {
    return { name: 'login' };
  }
});

export default router;