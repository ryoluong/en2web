import Login from '@/js/pages/login/index.vue';
import Notes from '@/js/pages/notes/index.vue';
import NoteView from '@/js/pages/notes/view.vue';
import NoteForm from '@/js/pages/notes/form.vue';
import NoteDelete from '@/js/pages/notes/delete.vue';
import NoteUsers from '@/js/pages/notes/users.vue';
import Users from '@/js/pages/users/index.vue';
import UserView from '@/js/pages/users/view.vue';
import UserEdit from '@/js/pages/users/edit.vue';
import ComingSoon from '@/js/pages/comingsoon.vue';
import RegisterVefiry from '@/js/pages/register/verify.vue';

const noteActions = [
  { icon: 'mdi-magnify', to: '/notes/search' },
  { icon: 'mdi-plus', to: '/notes/create' },
];

const routes = [
  {
    path: '/register/verify/:token',
    component: RegisterVefiry,
    name: 'register.verify',
    meta: {
      requireAuth: false,
      title: 'En2::Web',
      header: 'menu',
      actions: [],
    },
  },
  {
    path: '/login',
    component: Login,
    name: 'login',
    meta: {
      requireAuth: false,
      title: 'Login',
      header: 'menu',
      actions: [],
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
      actions: [{ icon: 'mdi-pencil', to: '/mypage/edit' }],
    },
  },
  {
    path: '/mypage/edit',
    component: UserEdit,
    name: 'mypage.edit',
    meta: {
      requireAuth: true,
      title: 'Mypage',
      header: 'back',
      actions: [],
    },
  },
  {
    path: '/notes',
    component: Notes,
    name: 'note.index',
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
    name: 'note.create',
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
    name: 'note.view',
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
    name: 'note.edit',
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
    name: 'note.delete',
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
    name: 'note.user',
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
    name: 'user.index',
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
    name: 'user.view',
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
    name: 'note.search',
    meta: {
      requireAuth: true,
      title: 'Notes',
      header: 'back',
      actions: [],
    },
  },
];

export default routes;
