import axios from 'axios';
const instance = axios.create({
  baseURL: '/api',
});
instance.interceptors.request.use(conf => {
  const token = localStorage.getItem('access_token');
  if (token) {
    conf.headers.Authorization = `Bearer ${token}`;
  }
  return conf;
});

export default instance;
