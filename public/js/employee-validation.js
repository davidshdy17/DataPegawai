
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formPegawai');

    if (!form) return;

    const fields = {
        nama: form.querySelector('[name="nama"]'),
        nip: form.querySelector('[name="nip"]'),
        email: form.querySelector('[name="email"]'),
        jabatan: form.querySelector('[name="jabatan"]'),
        alamat: form.querySelector('[name="alamat"]'),
        foto: form.querySelector('[name="foto"]')
    };

    // Menampilkan atau menghapus pesan error
    function setError(input, message) {
        if (!input) return;

        const feedback = input.parentElement.querySelector('.js-feedback');

        input.classList.toggle('is-invalid', Boolean(message));

        if (feedback) {
            feedback.textContent = message;
        }
    }

    // Memeriksa satu input
    function validateField(name) {
        const input = fields[name];

        if (!input) return true;

        const value = input.type === 'file' ? '' : input.value.trim();
        let error = '';

        if (name === 'nama' || name === 'jabatan') {
            if (!value) {
                error = `${name === 'nama' ? 'Nama' : 'Jabatan'} wajib diisi.`;
            } else if (value.length > 100) {
                error = 'Maksimal 100 karakter.';
            }
        }

        if (name === 'nip') {
            if (!value) {
                error = 'NIP wajib diisi.';
            } else if (!/^[0-9]+$/.test(value)) {
                error = 'NIP hanya boleh berisi angka.';
            } else if (value.length > 20) {
                error = 'NIP maksimal 20 digit.';
            }
        }

        if (name === 'email') {
            if (!value) {
                error = 'Email wajib diisi.';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                error = 'Format email tidak valid.';
            } else if (value.length > 100) {
                error = 'Email maksimal 100 karakter.';
            }
        }

        if (name === 'alamat' && value.length > 255) {
            error = 'Alamat maksimal 255 karakter.';
        }

        if (name === 'foto') {
            const file = input.files[0];

            if (file) {
                const allowed = ['image/jpeg', 'image/png', 'image/webp'];

                if (!allowed.includes(file.type)) {
                    error = 'Foto harus JPG, PNG, atau WEBP.';
                } else if (file.size > 2 * 1024 * 1024) {
                    error = 'Ukuran foto maksimal 2 MB.';
                }
            }
        }

        setError(input, error);
        return error === '';
    }

    // Validasi saat pengguna mengisi atau mengubah input
    Object.entries(fields).forEach(([name, input]) => {
        if (!input) return;

        const eventName = input.type === 'file' ? 'change' : 'input';

        input.addEventListener(eventName, function () {
            validateField(name);
        });
    });

    // Validasi seluruh form sebelum submit
    form.addEventListener('submit', function (event) {
        let valid = true;

        Object.keys(fields).forEach(name => {
            if (!validateField(name)) {
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();

            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) firstInvalid.focus();
        }
    });
});
