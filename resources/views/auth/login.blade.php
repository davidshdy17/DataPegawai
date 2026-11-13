
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Employee Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-wrapper">

        <div class="card login-card shadow-sm">

            <!-- Header -->
            <div class="login-header">
                <h3>Employee Management</h3>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            <!-- Form -->
            <div class="card-body p-4 p-md-5">

                <h5 class="fw-bold mb-1">Selamat Datang!</h5>
                <p class="text-muted small mb-4">
                    Masukkan email dan password akun Anda.
                </p>

                <!-- Error Login -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Login gagal!</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm"
                      action="{{ route('login.submit') }}"
                      method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="nama@example.com"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            maxlength="255"
                            required
                            autofocus
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            Password
                        </label>

                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword"
                                aria-label="Tampilkan password"
                                aria-pressed="false">
                                Lihat
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Login -->
                    <button
                        type="submit"
                        class="btn btn-primary btn-login w-100"
                        id="btnLogin">

                        <span id="loginText">Masuk</span>

                        <span
                            id="loginSpinner"
                            class="spinner-border spinner-border-sm d-none ms-2"
                            aria-hidden="true">
                        </span>

                    </button>

                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Employee Management System
                    </small>
                </div>

            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        // Menampilkan atau menyembunyikan password
        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            togglePassword.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
            togglePassword.setAttribute('aria-pressed', String(isHidden));
            togglePassword.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });

        // Loading saat submit
        document.getElementById('loginForm')
            .addEventListener('submit', function () {
                const btnLogin = document.getElementById('btnLogin');
                const spinner = document.getElementById('loginSpinner');

                btnLogin.disabled = true;
                spinner.classList.remove('d-none');
                document.getElementById('loginText').textContent = 'Memproses...';
            });
    </script>

</body>
</html>
