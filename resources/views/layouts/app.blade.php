<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

    <link rel="stylesheet" href="{{ asset('css/sideBar.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { margin: 0; background-color: #F3F4F6; }
        .app-container { display: flex; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; overflow-y: auto; padding: 20px; }
    </style>
</head>
<body>

    <div class="app-container">

        @include('layouts.sidebar')

        <main class="main-content">
            @yield('content')
        </main>

    </div>

</body>
</html>
