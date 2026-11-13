
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Employee Management</title>
    <link rel="icon" type="image/png" href="{{ asset('pegawai.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Employee Management
            </a>

            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small d-none d-sm-inline">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4">

        <!-- Heading -->
        <div class="mb-4">
            <h3 class="fw-semibold mb-1">Dashboard</h3>
            <p class="text-secondary mb-0">
                Ringkasan data dan aktivitas pegawai.
            </p>
        </div>

        <!-- Statistik -->
        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body p-4">
                        <p class="text-secondary mb-2">Total Pegawai</p>

                        <div class="stat-number">
                            {{ $totalEmployees }}
                        </div>

                        <small class="text-muted">
                            Pegawai terdaftar
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body p-4">
                        <p class="text-secondary mb-2">Total Jabatan</p>

                        <div class="stat-number">
                            {{ $totalJabatan }}
                        </div>

                        <small class="text-muted">
                            Jenis jabatan terdaftar
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <!-- Data Terbaru -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <h5 class="section-title mb-0">
                        Pegawai Terbaru
                    </h5>

                    <a href="{{ route('employees.index') }}"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($latestEmployees as $employee)
                                <tr>
                                    <td class="ps-3 fw-medium">
                                        {{ $employee->nama }}
                                    </td>

                                    <td>
                                        {{ $employee->nip }}
                                    </td>

                                    <td>
                                        {{ $employee->jabatan }}
                                    </td>

                                    <td class="text-end pe-3">
                                        <a href="{{ route('employees.show', $employee->id) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="text-center text-secondary py-4">
                                        Belum ada data pegawai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Shortcut -->
        <div class="mt-4">
            <a href="{{ route('employees.create') }}"
               class="btn btn-primary">
                + Tambah Pegawai
            </a>
        </div>

    </main>

</body>
</html>
