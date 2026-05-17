<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Staff Baru</title>
</head>
<body>
    <h2>Pendaftaran Staff / Karyawan Baru</h2>
    <p>Oleh: {{ Auth::user()->name }} (Manajer)</p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <label>Nama Staff:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br><br>

        <label>Email Login:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Nomor HP Karyawan:</label><br>
        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required><br><br>

        <label>Jabatan (Role):</label><br>
        <select name="role" required>
            <option value="karyawan">Karyawan (Kasir)</option>
            <option value="manajer">Manajer (Owner)</option>
        </select><br><br>

        <label>Password Akun:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Daftarkan Karyawan</button>
    </form>

    <br>
    <a href="{{ route('kasir.index') }}">← Kembali ke Aplikasi Kasir</a>
</body>
</html>
