async function renderDashboard() {
    const app = document.getElementById('app');
    app.innerHTML = `<p class="text-center text-gray-500">Memuat data dashboard...</p>`;
    
    try {
        const booksRes = await api.get('/books');
        const categoriesRes = await api.get('/categories');
        
        const totalBooks = booksRes.data ? booksRes.data.length : 0;
        const totalCategories = categoriesRes.data ? categoriesRes.data.length : 0;
        
        app.innerHTML = `
            <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-500 text-white p-4 rounded shadow">
                    <p class="text-sm">Total Buku</p>
                    <p class="text-3xl font-bold">${totalBooks}</p>
                </div>
                <div class="bg-orange-500 text-white p-4 rounded shadow">
                    <p class="text-sm">Kategori</p>
                    <p class="text-3xl font-bold">${totalCategories}</p>
                </div>
            </div>
        `;
    } catch (error) {
        app.innerHTML = `<p class="text-red-500">Gagal memuat dashboard.</p>`;
    }
}