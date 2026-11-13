
document.addEventListener('submit', function (event) {
    const form = event.target;

    if (!form.matches('form[data-confirm-delete]')) {
        return;
    }

    const yakin = confirm(
        'Apakah Anda yakin ingin menghapus data pegawai ini?'
    );

    if (!yakin) {
        event.preventDefault();
    }
});
