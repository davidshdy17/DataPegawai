document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchPegawai');
    if (!input) return;

    const table = document.getElementById('employeeTableBody');
    const status = document.getElementById('employeeSearchStatus');
    const pagination = document.getElementById('employeePagination');
    const actions = document.getElementById('employeeActions');
    const originalRows = Array.from(table.childNodes);
    let timer;
    let request;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        request?.abort();

        const keyword = input.value.trim();
        pagination.hidden = Boolean(keyword);

        if (!keyword) {
            table.replaceChildren(...originalRows);
            status.textContent = '';
            return;
        }

        table.replaceChildren();
        status.textContent = 'Mencari pegawai…';
        request = new AbortController();
        const { signal } = request;

        timer = setTimeout(async function () {
            try {
                const url = new URL(input.dataset.searchUrl, window.location.href);
                url.searchParams.set('q', keyword);

                let employees;
                if (window.axios) {
                    const response = await window.axios.get(url.href, { signal });
                    employees = response.data;
                } else {
                    const response = await fetch(url, {
                        signal,
                        headers: { Accept: 'application/json' }
                    });
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    employees = await response.json();
                }

                if (signal.aborted) return;
                if (!Array.isArray(employees)) throw new Error('Respons pencarian tidak valid');

                const rows = employees.map(function (employee) {
                    const row = document.createElement('tr');

                    for (const field of ['nip', 'nama', 'email', 'jabatan', 'alamat']) {
                        row.insertCell().textContent = employee[field] ?? '';
                    }

                    const controls = actions.content.cloneNode(true);
                    const id = encodeURIComponent(employee.id);
                    for (const link of controls.querySelectorAll('a')) {
                        link.href = link.href.replace('__EMPLOYEE_ID__', id);
                    }
                    const form = controls.querySelector('form');
                    form.action = form.action.replace('__EMPLOYEE_ID__', id);
                    row.insertCell().append(controls);
                    return row;
                });

                table.replaceChildren(...rows);
                status.textContent = rows.length === 0
                    ? 'Tidak ada pegawai yang cocok.'
                    : rows.length === 20
                        ? 'Menampilkan hingga 20 hasil. Persempit pencarian bila perlu.'
                        : rows.length + ' pegawai ditemukan.';
            } catch (error) {
                if (signal.aborted) return;
                status.textContent = 'Pencarian gagal. Ubah kata kunci untuk mencoba lagi.';
                console.error('Gagal mencari pegawai:', error);
            }
        }, 300);
    });
});