import Login from '@/js/pages/login/index.vue';
import Notes from '@/js/pages/notes/index.vue';
import NoteView from '@/js/pages/notes/view.vue';
import NoteForm from '@/js/pages/notes/form.vue';
import NoteDelete from '@/js/pages/notes/delete.vue';
import NoteUsers from '@/js/pages/notes/users.vue';
import Users from '@/js/pages/users/index.vue';
import UserView from '@/js/pages/users/view.vue';
import ComingSoon from '@/js/pages/comingsoon.vue';

const noteActions = [
  { icon: 'mdi-magnify', to: '/notes/search' },
  { icon: 'mdi-plus', to: '/notes/create' },
];

const routes = [
  {
    path: '/login',
    component: Login,
    meta: {
      requireAuth: false,
      title: 'Login',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/',
    component: Notes,
    meta: {
      requireAuth: true,
      title: 'Home',
      header: 'menu',
      actions: noteActions,
    },
  },
  {
    path: '/mypage',
    component: UserView,
    name: 'mypage',
    meta: {
      requireAuth: true,
      title: 'Mypage',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/notes',
    component: Notes,
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'menu',
      actions: noteActions,
    },
  },
  {
    path: '/notes/create',
    component: NoteForm,
    name: 'NoteCreate',
    meta: {
      requireAuth: true,
      title: 'Note',
      header: 'back',
      actions: [],
    },
  },
  {
    path: '/notes/:id(\\d+)',
    component: NoteView,
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'back',
      actions: noteActions,
    },
  },
  {
    path: '/notes/:id(\\d+)/edit',
    component: NoteForm,
    name: 'NoteEdit',
    meta: {
      requireAuth: true,
      title: 'Note',
      header: 'back',
      actions: [],
    },
  },
  {
    path: '/notes/:id(\\d+)/delete',
    component: NoteDelete,
    meta: {
      requireAuth: true,
      title: 'Note',
      header: 'back',
      actions: [],
    },
  },
  {
    path: '/notes/:id(\\d+)/users',
    component: NoteUsers,
    meta: {
      requireAuth: true,
      title: 'Liked Users',
      header: 'back',
      actions: noteActions,
    },
  },
  {
    path: '/users',
    component: Users,
    meta: {
      requireAuth: true,
      title: 'Users',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/users/:id(\\d+)',
    component: UserView,
    name: 'userview',
    meta: {
      requireAuth: true,
      title: 'Users',
      header: 'back',
      actions: [],
    },
  },
  {
    path: '/attendance',
    component: ComingSoon,
    name: 'attendance',
    meta: {
      requireAuth: true,
      title: 'Attendance',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/countries',
    component: ComingSoon,
    name: 'countries',
    meta: {
      requireAuth: true,
      title: 'Attendance',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/notes/search',
    component: ComingSoon,
    name: 'searchnotes',
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'back',
      actions: [],
    },
  },
];

export default routes;
