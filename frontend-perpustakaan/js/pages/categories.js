async function renderCategories() {
    const app = document.getElementById('app');
    app.innerHTML = `<p class="text-center text-gray-500">Memuat data kategori...</p>`;
    
    try {
        const res = await api.get('/categories');
        const categories = res.data || [];
        
        let rows = '';
        categories.forEach(cat => {
            rows += `
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">${cat.id}</td>
                    <td class="p-2">${escapeHtml(cat.nama)}</td>
                    <td class="p-2">${escapeHtml(cat.deskripsi || '-')}</td>
                </tr>
            `;
        });
        
        app.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Daftar Kategori</h1>
            </div>
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Nama Kategori</th>
                            <th class="p-2">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>
            </div>
        `;
    } catch (error) {
        app.innerHTML = `<p class="text-red-500">Gagal memuat data kategori.</p>`;
    }
}