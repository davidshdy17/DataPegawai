
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai | Employee Management</title>
    <link rel="icon" type="image/png" href="{{ asset('pegawai.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-white border-bottom">
        <div class="container">

            <a class="navbar-brand fw-semibold fs-6"
               href="{{ route('dashboard') }}">
                Employee Management
            </a>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}"
                   class="text-decoration-none text-secondary small">
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf

                    <button type="submit"
                            class="btn btn-outline-secondary btn-sm">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4">

        <!-- Heading -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <h3 class="page-title mb-1">Data Pegawai</h3>
                <p class="text-secondary mb-0">
                    Kelola informasi dan data pegawai perusahaan.
                </p>
            </div>

            <a href="{{ route('employees.create') }}"
               class="btn btn-primary">
                + Tambah Pegawai
            </a>

        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Tutup">
                </button>
            </div>
        @endif

        <!-- Employee Card -->
        <div class="card employee-card shadow-sm">

            <!-- Search Header -->
            <div class="card-header bg-white border-bottom p-3">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div class="search-box flex-grow-1">
                        <label for="searchPegawai"
                               class="form-label fw-medium small">
                            Cari Pegawai
                        </label>

                        <input
                            type="search"
                            id="searchPegawai"
                            class="form-control"
                            maxlength="100"
                            placeholder="Cari nama, NIP, atau jabatan..."
                            data-search-url="{{ route('employees.search') }}"
                            aria-describedby="employeeSearchStatus"
                        >

                        <div id="employeeSearchStatus"
                             class="form-text"
                             role="status"
                             aria-live="polite">
                        </div>
                    </div>

                    <div class="text-secondary small">
                        Total: {{ $employees->total() }} Pegawai
                    </div>

                </div>

            </div>

            <!-- Table -->
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="employeeTableBody">
                            @forelse($employees as $employee)
                                <tr>
                                    <td>{{ $employee->nip }}</td>

                                    <td class="fw-medium">
                                        {{ $employee->nama }}
                                    </td>

                                    <td>{{ $employee->email }}</td>

                                    <td>{{ $employee->jabatan }}</td>

                                    <td class="address-cell"
                                        title="{{ $employee->alamat }}">
                                        {{ $employee->alamat ?: '-' }}
                                    </td>

                                    <td class="action-buttons">
                                        <div class="d-flex gap-2 flex-nowrap">

                                            <a href="{{ route('employees.show', $employee->id) }}"
                                               class="btn btn-outline-secondary btn-sm">
                                                Detail
                                            </a>

                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('employees.destroy', $employee->id) }}"
                                                  method="POST"
                                                  class="m-0"
                                                  data-confirm-delete>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="text-center text-secondary py-5">
                                        Belum ada data pegawai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Template untuk AJAX Live Search -->
                <template id="employeeActions">
                    <div class="d-flex gap-2 flex-nowrap">

                        <a data-action="show"
                           href="{{ route('employees.show', '__EMPLOYEE_ID__') }}"
                           class="btn btn-outline-secondary btn-sm">
                            Detail
                        </a>

                        <a data-action="edit"
                           href="{{ route('employees.edit', '__EMPLOYEE_ID__') }}"
                           class="btn btn-outline-primary btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('employees.destroy', '__EMPLOYEE_ID__') }}"
                              method="POST"
                              class="m-0"
                              data-confirm-delete>

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm">
                                Hapus
                            </button>
                        </form>

                    </div>
                </template>

            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-top p-3"
                 id="employeePagination">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <small class="text-secondary">
                        Menampilkan
                        {{ $employees->firstItem() ?? 0 }}–{{ $employees->lastItem() ?? 0 }}
                        dari {{ $employees->total() }} pegawai
                    </small>

                    <div>
                        {{ $employees->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios@1/dist/axios.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/employee-search.js') }}"></script>
    <script src="{{ asset('js/employee-index.js') }}"></script>

</body>
</html>
