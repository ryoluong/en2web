import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import colors from 'vuetify/lib/util/colors';
import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);

const opts = {
  theme: {
    themes: {
      light: {
        error: colors.pink.accent1,
        background: colors.shades.white,
      },
    },
  },
  icons: {
    iconfont: 'mdi',
  },
};

export default new Vuetify(opts);
