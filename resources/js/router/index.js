import Vue from 'vue';
import store from '@/store';

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

const router = new VueRouter({
  mode: 'history',
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      if (to.path === '/notes') {
        return new Promise(resolve => {
          setTimeout(() => {
            resolve(savedPosition);
          }, 500);
        });
      } else {
        return savedPosition;
      }
    } else {
      return { x: 0, y: 0 };
    }
  },
});

router.beforeEach(async (to, from, next) => {
  // localStorageを元に再ログイン処理
  if (!store.state.auth.isAuth) {
    const token = localStorage.getItem('access_token');
    if (token) {
      await store.dispatch('auth/refresh');
    }
  }
  // Auth middleware
  if (to.meta.requireAuth && !store.state.auth.isAuth) {
    next('/login');
  }
  // Guest middleware
  if (!to.meta.requireAuth && store.state.auth.isAuth) {
    next('/notes');
  }
  next();
});

router.afterEach(to => {
  store.dispatch('meta/setTitle', to.meta.title);
});

export default router;
