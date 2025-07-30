// resources/js/userService.js
import api from './api.js';

export const searchUsers = (query = '', page = 1, limit = 10) => {
  return api.get('users/search', {
    params: { search: query, page, limit }
  });
};
