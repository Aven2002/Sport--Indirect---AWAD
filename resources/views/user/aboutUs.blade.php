<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About us - Sport Indirect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/user/aboutus.css') }}">
</head>

@extends('layouts.user')

@section('content')

<body>
    <div class="container about-page py-5">
        <h1 class="text-center">About Sport Indirect</h1>

        <!-- Company Background Section -->
        <div class="company-background text-center p-4 rounded shadow-sm">
        <img src="{{ asset('images/comLogo.png') }}" alt="Sport Indirect Logo" class="rotate-logo" height="85" width="100">
        <p class="company-description mt-3">
                Sport Indirect began with a passion for athletic excellence and a vision to offer premium sports products that empower athletes at every level. Our journey is driven by a commitment to innovation, quality, and a love for the game.
            </p>
        </div>

        <!-- Vision Section -->
        <section class="vision mt-5">
            <h2 class="text-center">Our Vision</h2>
            <p class="text-center">
                Our vision is to be the world’s leading provider of innovative sports solutions, inspiring healthier lifestyles and a more active community across the globe.
            </p>
        </section>

        <!-- Mission Section -->
        <section class="mission mt-5">
            <h2 class="text-center">Our Mission</h2>
            <p class="text-center">
                Our mission is to empower athletes of all levels by delivering top-quality sports equipment, apparel, and accessories. We are dedicated to continuous innovation, sustainability, and excellence in everything we do.
            </p>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
