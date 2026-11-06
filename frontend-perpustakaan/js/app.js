function router() {
    const hash = window.location.hash || '#dashboard';
    
    if (hash === '#dashboard') renderDashboard();
    else if (hash === '#books') renderBooks();
    else if (hash === '#categories') renderCategories(); // <-- Baris ini yang diaktifin
    else document.getElementById('app').innerHTML = '<p>Halaman tidak ditemukan.</p>';
}

window.addEventListener('hashchange', router);
window.addEventListener('DOMContentLoaded', router);