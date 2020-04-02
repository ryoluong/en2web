import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import colors from 'vuetify/lib/util/colors';
import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);

const opts = {
  theme: {
    themes: {
      light: {
        error: colors.red.accent2,
      },
    },
  },
  icons: {
    iconfont: 'mdi',
  },
};

export default new Vuetify(opts);
