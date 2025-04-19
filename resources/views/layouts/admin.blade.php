<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - @yield('title','Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin_layout.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-white text-dark d-flex flex-column min-vh-100">

  <div style="background-image: url('{{ asset('images/bg_01.png') }}'); background-size: cover; background-position: center;" class="flex-grow-1 d-flex flex-column">

    {{-- Header --}}
    <header class="bg-dark text-white py-4">
      <div class="container d-flex flex-wrap align-items-center justify-content-between">
        
        {{-- Navigation --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent p-0">
          <div class="container-fluid p-0">
            <button class="navbar-toggler border" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
              <i class="bi bi-justify text-white"></i> 
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
              <ul class="navbar-nav ms-auto gap-3 align-items-center">
                <li class="nav-item">
                  <a class="nav-link text-white fw-medium" href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                {{-- My Account Dropdown --}}
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    My Account
                  </a>
                  <ul class="dropdown-menu shadow rounded-3" aria-labelledby="accountDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <div class="d-flex justify-content-center mt-3">
                      <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">Logout</button>
                      </form>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        {{-- Logo --}}
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
          <img src="{{ asset('images/comLogo.png') }}" alt="Sport Indirect Logo" height="70" width="200">
        </a>
      </div>
    </header>

    {{-- Main Content --}}
    <main class="container mt-4 flex-grow-1">
      @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 w-100">
      <p class="mb-0">&copy; {{ date('Y') }} Sport Indirect. All rights reserved.</p>
      <div class="footer-region">🌐 Malaysia</div>
    </footer>

  </div>

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/toast.js') }}"></script>

</body>
</html>
