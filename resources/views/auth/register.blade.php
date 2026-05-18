<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SwiftBill POS</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <div class="register-container">

        <div class="left-panel">
            <div class="hero-card" style="background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.4)), url('{{ asset('images/mockup-register.png') }}');">
                <h1 class="hero-title">Kelola Bisnis Lebih Efisien</h1>
                <p class="hero-desc">Bergabunglah dengan ribuan pengusaha yang telah beralih ke SwiftBill POS untuk transaksi yang lebih cepat dan aman.</p>
            </div>

            <div class="features-grid">
                <div class="feature-box">
                    <i class="fa-regular fa-clock"></i>
                    <h4>Cepat</h4>
                    <p>Transaksi kilat dalam hitungan detik.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-regular fa-shield"></i>
                    <h4>Aman</h4>
                    <p>Keamanan data terjamin 24/7.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-regular fa-chart-bar"></i>
                    <h4>Detail</h4>
                    <p>Laporan penjualan yang sangat rinci.</p>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Daftar Akun</h2>
                    <p>Mulai langkah sukses bisnis Anda hari ini.</p>
                </div>

                @if ($errors->any())
                    <div class="error-box">
                        <ul style="padding-left: 16px; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <input type="hidden" name="role" value="manajer">

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user input-icon"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope input-icon"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nama Bisnis</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-building input-icon"></i>
                            <input type="text" name="business_name" value="{{ old('business_name') }}" placeholder="Contoh: Cafe Simpang MI" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required>
                            <i class="fa-regular fa-eye-slash toggle-password" id="btnTogglePassword" style="cursor: pointer;"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <div class="terms-wrapper">
                        <input type="checkbox" id="agree" required>
                        <label for="agree">Saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi yang berlaku.</label>
                    </div>

                    <button type="submit" class="btn-submit">Daftar Sekarang</button>

                    <div class="divider">
                        <span>Atau daftar dengan:</span>
                    </div>

                    <button type="button" class="btn-google">
                        <img src="{{ asset('images/google-logo.jpg') }}" alt="Google Logo">
                        Google
                    </button>
                </form>

                <div class="login-redirect">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('btnTogglePassword');

        togglePasswordBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>
</body>
</html>
