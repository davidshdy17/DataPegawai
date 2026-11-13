
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 650px;">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0">Tambah Pegawai</h4>
                <small class="text-muted">Masukkan informasi pegawai baru</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="formPegawai" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pegawai</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" maxlength="100" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip"
                            class="form-control @error('nip') is-invalid @enderror"
                            value="{{ old('nip') }}" maxlength="20" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" maxlength="100" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            class="form-control @error('jabatan') is-invalid @enderror"
                            value="{{ old('jabatan') }}" maxlength="100" required>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat <span class="text-muted">(Opsional)</span></label>
                        <textarea name="alamat" id="alamat" rows="3" maxlength="255"
                            class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Masukkan alamat pegawai">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Profil (Opsional)</label>

                        <input type="file"
                            name="foto"
                            id="foto"
                            class="form-control @error('foto') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">

                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback js-feedback"></div>

                        <div class="mt-3 text-center">
                            <img id="previewFoto"
                                class="rounded-circle object-fit-cover border shadow-sm"
                                style="width: 120px; height: 120px; display: none;"
                                alt="Preview foto profil">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Tambah Pegawai
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="{{ asset('js/employee-preview.js') }}"></script>
<script src="{{ asset('js/employee-validation.js') }}"></script>
</body>
</html>
