import Login from '@/pages/login/index.vue';
import Notes from '@/pages/notes/index.vue';

const routes = [
  {
    path: '/login',
    component: Login,
    meta: {
      requireAuth: false,
      title: 'Login',
    },
  },
  {
    path: '/notes',
    component: Notes,
    meta: {
      requireAuth: true,
      title: 'Notes',
    },
  },
];

export default routes;
