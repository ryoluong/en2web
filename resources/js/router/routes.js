import Login from '@/js/pages/login/index.vue';
import Notes from '@/js/pages/notes/index.vue';
import NoteView from '@/js/pages/notes/view.vue';
import NoteUsers from '@/js/pages/notes/users.vue';
import Users from '@/js/pages/users/index.vue';
import UserView from '@/js/pages/users/view.vue';

const routes = [
  {
    path: '/login',
    component: Login,
    meta: {
      requireAuth: false,
      title: 'Login',
      header: 'menu',
    },
  },
  {
    path: '/',
    component: Notes,
    meta: {
      requireAuth: true,
      title: 'Home',
      header: 'menu',
    },
  },
  {
    path: '/notes',
    component: Notes,
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'menu',
    },
  },
  {
    path: '/notes/:id(\\d+)',
    component: NoteView,
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'back',
    },
  },
  {
    path: '/notes/:id(\\d+)/users',
    component: NoteUsers,
    meta: {
      requireAuth: true,
      title: 'Liked Users',
      header: 'back',
    },
  },
  {
    path: '/users',
    component: Users,
    meta: {
      requireAuth: true,
      title: 'Users',
      header: 'menu',
    },
  },
  {
    path: '/users/:id(\\d+)',
    component: UserView,
    meta: {
      requireAuth: true,
      title: 'Users',
      header: 'back',
    },
  },
];

export default routes;
