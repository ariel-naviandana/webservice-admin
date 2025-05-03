// users.js

// Simulasi data user (nanti fetch dari REST API)
const users = [
    { id: 1, nama: 'Budi', email: 'budi@example.com', role: 'Admin' },
    { id: 2, nama: 'Siti', email: 'siti@example.com', role: 'User' },
    { id: 3, nama: 'Agus', email: 'agus@example.com', role: 'User' }
];

function loadUsers() {
    const tbody = document.getElementById('user-table-body');
    tbody.innerHTML = '';

    users.forEach(user => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${user.id}</td>
            <td>${user.nama}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Hapus</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function deleteUser(userId) {
    if (confirm('Yakin ingin menghapus user ini?')) {
        const index = users.findIndex(user => user.id === userId);
        if (index !== -1) {
            users.splice(index, 1);
            loadUsers();
        }
    }
}

// Load users saat halaman dibuka
window.addEventListener('DOMContentLoaded', loadUsers);
