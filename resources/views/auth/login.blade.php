<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang Kembali - SwifttBill</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-container">

        <div class="left-panel">
            <div class="brand-name">SwifttBill</div>

            <div class="hero-text">
                <h1>Solusi Manajemen Kasir<br>Modern</h1>
                <p>Efisien, handal, dan profesional untuk mempercepat pertumbuhan bisnis Anda di setiap transaksi.</p>
            </div>

            <ul class="features-list">
                <li><i class="fa-solid fa-circle-check"></i> Manajemen Inventori Real-time</li>
                <li><i class="fa-solid fa-circle-check"></i> Laporan Penjualan Otomatis</li>
                <li><i class="fa-solid fa-circle-check"></i> Multi-outlet &amp; Sinkronisasi Cloud</li>
            </ul>
        </div>

        <div class="right-panel">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Silakan masuk ke akun SwifttBill Anda untuk melanjutkan.</p>
                </div>

                @if ($errors->any() || session('status'))
                    <div class="error-box">
                        <ul style="padding-left: 16px; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            @if(session('status'))
                                <li>{{ session('status') }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope input-icon"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@bisnis.com" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label>Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                            @endif
                        </div>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" placeholder="••••••••" required>
                            <i class="fa-regular fa-eye-slash toggle-password" id="eyeIcon"></i>
                        </div>
                    </div>

                    <div class="options-row">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <div class="divider">
                        <span>Atau masuk dengan:</span>
                    </div>

                    <div class="social-login-grid">
                        <button type="button" class="btn-social">
                            <img src="{{ asset('images/google-logo.jpg') }}" alt="Google">
                            Google
                        </button>
                        <button type="button" class="btn-social">
                            <i class="fa-brands fa-facebook"></i>
                            Facebook
                        </button>
                    </div>
                </form>

                <div class="register-redirect">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar gratis di sini</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        eyeIcon.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>
</body>
</html>
