/* eslint-disable no-undef */
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
module.exports = {
  plugins: [new VuetifyLoaderPlugin()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources'),
    },
  },
};
