
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen input dan preview
    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');

    // Pastikan elemen tersedia
    if (!inputFoto || !previewFoto) {
        return;
    }

    // Simpan foto awal (khusus halaman Edit)
    const fotoAwal = previewFoto.getAttribute('src');
    const displayAwal = previewFoto.style.display;

    // Menyimpan URL sementara
    let urlFoto = null;

    // Event ketika pengguna memilih foto
    inputFoto.addEventListener('change', function () {
        const file = inputFoto.files[0];

        // Hapus URL sementara sebelumnya
        if (urlFoto) {
            URL.revokeObjectURL(urlFoto);
            urlFoto = null;
        }

        // Jika tidak ada file yang dipilih
        if (!file) {
            previewFoto.removeAttribute('src');

            if (fotoAwal) {
                previewFoto.src = fotoAwal;
                previewFoto.style.display = displayAwal || 'block';
            } else {
                previewFoto.style.display = 'none';
            }

            return;
        }

        // Validasi tipe file
        const tipeDiizinkan = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!tipeDiizinkan.includes(file.type)) {
            alert('Format foto harus JPG, PNG, atau WEBP.');
            inputFoto.value = '';
            previewFoto.src = fotoAwal || '';
            previewFoto.style.display = fotoAwal ? 'block' : 'none';
            return;
        }

        // Validasi ukuran maksimal 2 MB
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            inputFoto.value = '';
            previewFoto.src = fotoAwal || '';
            previewFoto.style.display = fotoAwal ? 'block' : 'none';
            return;
        }

        // Buat URL sementara untuk preview
        urlFoto = URL.createObjectURL(file);

        // Tampilkan foto
        previewFoto.src = urlFoto;
        previewFoto.style.display = 'block';
    });

    // Bersihkan URL saat gambar selesai dimuat atau halaman ditutup
    window.addEventListener('pagehide', function () {
        if (urlFoto) {
            URL.revokeObjectURL(urlFoto);
        }
    });
});
