<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title','Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin_layout.css') }}">
</head>

<body class="bg-white text-dark">

{{-- Header --}}
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center flex-wrap px-4">
            
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-white text-decoration-none">
                <img src="{{ asset('images/comLogo.png') }}" alt="Sport Indirect Logo" height="100" width="300">
            </a>

            <!-- Profile Icons -->
            <div class="d-flex gap-4 align-items-center">
                <a href="{{ route('user.profile') }}" class="fs-5 text-white text-decoration-none d-flex align-items-center gap-1">
                    <i class="bi bi-person-lines-fill fs-4"></i>
                </a>
            </div>
        </div>
    </header>


    {{-- Main Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto w-100">
        <p class="mb-0">&copy; {{ date('Y') }} Sport Indirect. All rights reserved.</p>
        <div class="footer-region">🌐 Malaysia</div>
    </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/toast.js') }}"></script> 
</body>
</html>