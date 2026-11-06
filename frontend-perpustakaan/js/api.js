const api = {
    async get(endpoint) {
        const res = await fetch(`${BASE_URL}${endpoint}`);
        return res.json();
    },
    async post(endpoint, data) {
        const res = await fetch(`${BASE_URL}${endpoint}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return res.json();
    },
    async put(endpoint, data) {
        const res = await fetch(`${BASE_URL}${endpoint}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return res.json();
    },
    async delete(endpoint) {
        const res = await fetch(`${BASE_URL}${endpoint}`, { method: 'DELETE' });
        return res.json();
    }
};