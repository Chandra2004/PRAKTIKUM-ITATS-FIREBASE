// resources/js/main.js
import { searchUsers } from './userService.js';

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const tbody = document.getElementById('userTableBody');

  function render(users) {
    tbody.innerHTML = '';
    users.forEach(user => {
      tbody.innerHTML += `
        <tr>
          <td>${user.full_name}</td>
          <td>${user.email}</td>
          <td>${user.role_name}</td>
        </tr>
      `;
    });
  }

  function doSearch() {
    const keyword = searchInput.value;
    searchUsers(keyword, 1).then(response => {
      render(response.data.users);
    }).catch(err => {
      console.error('Gagal mengambil data:', err);
    });
  }

  // Trigger pencarian saat halaman pertama kali load
  doSearch();

  // Trigger pencarian setiap kali user mengetik
  searchInput?.addEventListener('input', () => {
    doSearch();
  });
});
