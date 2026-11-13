
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card border-0 shadow-sm mx-auto overflow-hidden"
             style="max-width: 700px;">

            <!-- Header -->
            <div class="card-header bg-primary text-white p-4 border-0">
                <h4 class="mb-1">Detail Pegawai</h4>
                <p class="mb-0 opacity-75">
                    Informasi lengkap data pegawai
                </p>
            </div>

            <div class="card-body p-4">

                <!-- Foto Profil -->
                <div class="text-center mb-4">

                    @if($employee->foto)
                        <img
                            src="{{ asset('storage/' . $employee->foto) }}"
                            alt="Foto {{ $employee->nama }}"
                            class="rounded-circle border border-3 border-primary-subtle shadow-sm mb-3 object-fit-cover"
                            style="width: 110px; height: 110px;"
                        >
                    @else
                        <div class="rounded-circle bg-primary-subtle text-primary
                                    d-inline-flex align-items-center justify-content-center
                                    fw-bold fs-2 mb-3"
                             style="width: 110px; height: 110px;">

                            {{ strtoupper(mb_substr($employee->nama, 0, 1)) }}

                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">
                        {{ $employee->nama }}
                    </h5>

                    <span class="badge text-bg-primary">
                        {{ $employee->jabatan }}
                    </span>

                </div>

                <hr class="text-secondary opacity-25">

                <!-- Informasi Pegawai -->
                <h6 class="fw-bold text-secondary mb-3">
                    Informasi Pegawai
                </h6>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <tbody>

                            <tr class="border-bottom">
                                <th class="text-secondary py-3" width="30%">NIP</th>
                                <td class="py-3">{{ $employee->nip }}</td>
                            </tr>

                            <tr class="border-bottom">
                                <th class="text-secondary py-3">Nama</th>
                                <td class="py-3">{{ $employee->nama }}</td>
                            </tr>

                            <tr class="border-bottom">
                                <th class="text-secondary py-3">Email</th>
                                <td class="py-3">{{ $employee->email }}</td>
                            </tr>

                            <tr class="border-bottom">
                                <th class="text-secondary py-3">Jabatan</th>
                                <td class="py-3">{{ $employee->jabatan }}</td>
                            </tr>

                            <tr>
                                <th class="text-secondary py-3">Alamat</th>
                                <td class="py-3">
                                    {{ $employee->alamat ?: 'Belum diisi' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('employees.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Kembali
                    </a>

                    <a href="{{ route('employees.edit', $employee->id) }}"
                       class="btn btn-primary px-4">
                        Edit Pegawai
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
