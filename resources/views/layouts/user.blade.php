<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Page')</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/user_layout.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

{{-- Combined Header & Navbar --}}
<header class="bg-dark text-white py-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent p-0">
            <div class="container-fluid p-0">
                <button class="navbar-toggler border" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-justify text-white"></i> 
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto gap-3 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-white fw-medium" href="{{ route('landing') }}">Home</a>
                        </li>

                        {{-- Sports Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="sportsDropdown" role="button" data-bs-toggle="dropdown">
                                Sports
                            </a>
                            <ul class="dropdown-menu shadow rounded-3" aria-labelledby="sportsDropdown">
                                <li><a class="dropdown-item" href="{{ url('/user/product?') }}">All</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?sport=Badminton') }}">Badminton</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?sport=Pickleball') }}">Pickleball</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?sport=Tennis') }}">Tennis</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?sport=Basketball') }}">Basketball</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?sport=Golf') }}">Golf</a></li>
                            </ul>
                        </li>

                        {{-- Brands Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="brandsDropdown" role="button" data-bs-toggle="dropdown">
                                Brands
                            </a>
                            <ul class="dropdown-menu shadow rounded-3" aria-labelledby="brandsDropdown">
                                <li><a class="dropdown-item" href="{{ url('/user/product?') }}">All</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?brand=YONEX') }}">YONEX</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?brand=LI- NING') }}">LI-NING</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?brand=VICTOR') }}">VICTOR</a></li>
                                <li><a class="dropdown-item" href="{{ url('/user/product?brand=WILSON') }}">WILSON</a></li>
                            </ul>
                        </li>

                        {{-- My Account Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                                My Account
                            </a>
                            <ul class="dropdown-menu shadow rounded-3" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.cart') }}">Cart</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.order') }}">Track Order</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.address') }}">Address Book</a></li>
                                <div class="d-flex justify-content-center mt-3">
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Logout</button>
                                    </form>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('images/comLogo.png') }}" alt="Sport Indirect Logo" height="70" width="200">
        </a>
    </div>
</header>

{{-- Main Content --}}
<main class="flex-grow-1 container mt-4">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="footer bg-dark text-white border-top border-white py-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h4 class="text-white">Resources</h4>
                <a href="{{ route('user.store') }}" class="d-block text-white text-decoration-none">Find A Store</a>
                <a href="{{ route('register') }}" class="d-block text-white text-decoration-none">Become A Member</a>
            </div>
            <div class="col-md-4 mb-3">
                <h4 class="text-white">Help</h4>
                <a href="{{ route('user.order') }}" class="d-block text-white text-decoration-none">Order Status</a>
                <a href="{{ route('user.contactUs') }}" class="d-block text-white text-decoration-none">Contact Us</a>
            </div>
            <div class="col-md-4 mb-3">
                <h4 class="text-white">Company</h4>
                <a href="{{ route('user.aboutUs') }}" class="d-block text-white text-decoration-none">About Sport Indirect</a>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white">
            <p class="mb-0">© 2025 Sport Indirect, Inc. All rights reserved</p>
            <img src="/images/Default/_payment.png" alt="Payment Logo" style="width:300px;">
        </div>
    </div>
</footer>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/toast.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navbarCollapse = document.querySelector('.navbar-collapse');
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function () {
                if (!this.classList.contains('dropdown-toggle')) {
                    new bootstrap.Collapse(navbarCollapse).hide();
                }
            });
        });
        document.addEventListener('click', function (e) {
            if (!navbarCollapse.contains(e.target) && !e.target.matches('.navbar-toggler')) {
                new bootstrap.Collapse(navbarCollapse).hide();
            }
        });
    });
</script>

</body>
</html>
