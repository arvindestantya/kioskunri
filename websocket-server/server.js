// websocket-server/server.js

const { WebSocketServer } = require('ws');
const axios = require('axios');

// Buat server WebSocket di port 8081 (atau port lain yang Anda inginkan)
const wss = new WebSocketServer({ port: 8081 });
console.log('WebSocket server started on port 8081');

// Simpan semua koneksi klien dalam sebuah Map berdasarkan ID fakultas
const facultyClients = new Map();

wss.on('connection', (ws, req) => {
    // Ambil URL dari koneksi, contoh: /?facultyId=1
    const urlParams = new URLSearchParams(req.url.slice(1));
    const facultyId = urlParams.get('facultyId');

    if (!facultyId) {
        console.log('Client connected without facultyId. Closing connection.');
        ws.close();
        return;
    }

    console.log(`Client connected for faculty: ${facultyId}`);

    // Tambahkan koneksi baru ke daftar klien untuk fakultas ini
    if (!facultyClients.has(facultyId)) {
        facultyClients.set(facultyId, new Set());
    }
    facultyClients.get(facultyId).add(ws);

    ws.on('close', () => {
        console.log(`Client disconnected for faculty: ${facultyId}`);
        // Hapus koneksi dari daftar saat klien terputus
        if (facultyClients.has(facultyId)) {
            facultyClients.get(facultyId).delete(ws);
        }
    });

    ws.on('error', console.error);
});

// Fungsi ini akan dipanggil oleh Laravel untuk menyiarkan pembaruan
async function broadcastUpdate(facultyId) {
    if (!facultyClients.has(String(facultyId))) {
        console.log(`No clients connected for faculty ${facultyId}. No broadcast needed.`);
        return;
    }

    try {
        // Panggil API Laravel untuk mendapatkan daftar flyer terbaru
        // Pastikan URL ini benar sesuai dengan setup Laragon/Valet Anda
        const response = await axios.get(`http://127.0.0.1:8000/api/faculties/${facultyId}/flyers`);
        
        const flyers = response.data.flyers;
        const payload = JSON.stringify({
            type: 'flyer-update',
            flyers: flyers
        });

        console.log(`Broadcasting update to ${facultyClients.get(String(facultyId)).size} clients for faculty ${facultyId}`);

        // Kirim data terbaru ke semua klien yang terhubung untuk fakultas tersebut
        facultyClients.get(String(facultyId)).forEach(client => {
            if (client.readyState === 1) { // 1 === WebSocket.OPEN
                client.send(payload);
            }
        });
    } catch (error) {
        console.error(`Failed to fetch flyers for faculty ${facultyId}:`, error.message);
    }
}

// =======================================================================
// INI ADALAH BAGIAN PENTING: Membuat server HTTP kecil untuk menerima notifikasi dari Laravel
// =======================================================================
const http = require('http');
const server = http.createServer((req, res) => {
    if (req.method === 'POST' && req.url === '/broadcast') {
        let body = '';
        req.on('data', chunk => {
            body += chunk.toString();
        });
        req.on('end', () => {
            try {
                const data = JSON.parse(body);
                if (data.faculty_id) {
                    console.log(`Received broadcast request for faculty: ${data.faculty_id}`);
                    broadcastUpdate(data.faculty_id);
                    res.writeHead(200, { 'Content-Type': 'application/json' });
                    res.end(JSON.stringify({ message: 'Broadcast initiated' }));
                } else {
                    throw new Error('faculty_id is missing');
                }
            } catch (e) {
                res.writeHead(400, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ error: 'Invalid JSON or missing faculty_id' }));
            }
        });
    } else {
        res.writeHead(404);
        res.end();
    }
});

// Jalankan server HTTP di port 8082
server.listen(8082, () => {
    console.log('HTTP server for Laravel notifications listening on port 8082');
});