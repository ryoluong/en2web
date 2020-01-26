import Login from '@/pages/login/index.vue';
import Notes from '@/pages/notes/index.vue';
import NoteView from '@/pages/notes/view.vue';
import NoteUsers from '@/pages/notes/users.vue';
import users from '@/pages/users/index.vue';

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
    component: users,
    meta: {
      requireAuth: true,
      title: 'Users',
      header: 'menu',
    },
  },
];

export default routes;
