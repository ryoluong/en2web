/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import { VLazyImagePlugin } from "v-lazy-image";
Vue.use(VLazyImagePlugin);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("users-index", require("./components/UsersIndexComponent.vue"));
Vue.component(
  "user-container",
  require("./components/UserContainerComponent.vue")
);
Vue.component("user-item", require("./components/UserItemComponent.vue"));
Vue.component("show-note", require("./components/ShowNoteComponent.vue"));
Vue.component("fav-button", require("./components/FavNoteComponent.vue"));
Vue.component(
  "fav-button-show-note",
  require("./components/FavNoteComponentForShowNote.vue")
);
Vue.component(
  "register-department",
  require("./components/RegisterDepartmentComponent.vue")
);
Vue.component(
  "input-vue",
  require("./components/Inputs/InputVueComponent.vue")
);
Vue.component(
  "select-enroll-year",
  require("./components/Inputs/SelectEnrollYearComponent.vue")
);
Vue.component(
  "select-generation",
  require("./components/Inputs/SelectGenerationComponent.vue")
);
Vue.component(
  "attendance-form",
  require("./components/AttendanceFormComponent.vue")
);
Vue.prototype.$http = axios;
new Vue({
  el: "#app",
  data() {
    return {
      loading: true,
      showMenu: false,
      showUserMenu: false
    };
  },
  mounted() {
    this.loading = false;
  },
  methods: {
    toggleShowMenu: function() {
      this.showMenu = !this.showMenu;
      document.body.classList.toggle("scroll-lock");
    },
    toggleShowUserMenu: function() {
      this.showUserMenu = !this.showUserMenu;
    }
  }
});
