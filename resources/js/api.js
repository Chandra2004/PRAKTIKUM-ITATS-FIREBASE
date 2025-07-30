// resources/js/api.js
import axios from 'https://cdn.skypack.dev/axios';

const api = axios.create({
  baseURL: '/api/',
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
});

export default api;
