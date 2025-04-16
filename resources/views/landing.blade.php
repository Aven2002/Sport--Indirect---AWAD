<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Sport Indirect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

@extends('layouts.user')

@section('content')

<body>
    <!-- Slideshow Section -->
    <div class="container-fluid p-0 position-relative">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100 img-fluid" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100 img-fluid" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/banner3.jpg') }}" class="d-block w-100 img-fluid" alt="Banner 3">
                </div>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2"></button>
            </div>
        </div>
    </div>

    <!-- Popular Sports Brands -->
    <div class="container my-5">
    <h3 class="text-center mb-4">Popular Sports Brands</h3>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
        <a href="{{ url('/products?brand=YONEX') }}">
        <img src="{{ asset('images/Brand_Logo/YONEX.png') }}" class="brand-logo">
        </a>
        <a href="{{ url('/products?brand=LI- NING') }}">
            <img src="{{ asset('images/Brand_Logo/LI- NING.png') }}" class="brand-logo">
        </a>
        <a href="{{ url('/products?brand=VICTOR') }}">
            <img src="{{ asset('images/Brand_Logo/VICTOR.png') }}" class="brand-logo">
        </a>
        <a href="{{ url('/products?brand=WILSON') }}">
            <img src="{{ asset('images/Brand_Logo/WILSON.png') }}" class="brand-logo">
        </a>
    </div>

    <!-- Shop by Sports -->
    <div class="container my-5">
    <h3 class="text-center mb-4">Shop by Sports</h3>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
        <a href="{{ url('/products?brand=YONEX') }}">
        <img src="{{ asset('images/Sports/Badminton.png') }}" class="sport-logo">
        </a>
        <a href="{{ url('/products?brand=LI- NING') }}">
            <img src="{{ asset('images/Sports/Basketball.png') }}" class="sport-logo">
        </a>
        <a href="{{ url('/products?brand=VICTOR') }}">
            <img src="{{ asset('images/Sports/Golf.png') }}" class="sport-logo">
        </a>
        <a href="{{ url('/products?brand=WILSON') }}">
            <img src="{{ asset('images/Sports/Tennis.png') }}" class="sport-logo">
        </a>
        <a href="{{ url('/products?brand=WILSON') }}">
            <img src="{{ asset('images/Sports/Pickleball.png') }}" class="sport-logo">
        </a>
    </div>

    <!-- Trending Now -->
    <div class="container my-5">
        <h3 class="text-left mb-4">Trending Now</h3>

        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" id="carousel-items">
                <!-- Products will be dynamically added here -->
            </div>
            
            <!-- Left and Right Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <!-- New Arrivals -->
    <div class="container my-5">
    <h3 class="text-center mb-4">New Arrivals</h3>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
      
    </div>
</div>

    <!-- Animated Product Introduction -->
    <section class="container text-center my-5">
        <h2 class="text-white">Our Latest Collection</h2>
        <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('images/animation.gif') }}" class="img-fluid w-75">
            <p>Experience the latest innovation in sports gear with our new collection. Designed for performance and comfort.</p>
        </div>
    </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/landing.js') }}"></script>

</body>
</html>
@endsection
