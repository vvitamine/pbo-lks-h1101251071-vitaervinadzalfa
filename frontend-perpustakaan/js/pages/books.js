async function renderBooks() {
    const app = document.getElementById('app');
    app.innerHTML = `<p class="text-center text-gray-500">Memuat data buku...</p>`;
    
    try {
        const res = await api.get('/books');
        const books = res.data || [];
        
        let rows = '';
        books.forEach(book => {
            rows += `
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">${book.id}</td>
                    <td class="p-2">${escapeHtml(book.judul)}</td>
                    <td class="p-2">${escapeHtml(book.penulis)}</td>
                    <td class="p-2">${book.tahun}</td>
                    <td class="p-2">${book.stok}</td>
                </tr>
            `;
        });
        
        app.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Daftar Buku</h1>
            </div>
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Judul</th>
                            <th class="p-2">Penulis</th>
                            <th class="p-2">Tahun</th>
                            <th class="p-2">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>
            </div>
        `;
    } catch (error) {
        app.innerHTML = `<p class="text-red-500">Gagal memuat data buku.</p>`;
    }
}