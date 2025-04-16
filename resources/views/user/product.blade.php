@extends('layouts.user')

@section('content')

@php
    $selectedBrand = request()->query('brand'); // Get brand from URL
@endphp

<head>
    <title>Product - Sport Indirect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user/product.css') }}">
</head>

<body>

  <!-- Top Controls -->
  <div class="container d-flex justify-content-between align-items-center my-3">
    <div>
      <label for="sort" class="me-2">Sort By:</label>
      <select id="sort" class="form-select d-inline-block w-auto">
        <option value="newest">Newest</option>
        <option value="high-low">Price: High-Low</option>
        <option value="low-high">Price: Low-High</option>
      </select>
    </div>
  </div>

  <!-- Filters -->
  <div class="container mt-4">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3" id="sidebar">
        <div class="bg-light p-3 rounded">
          <div class="accordion" id="filterAccordion">
            <!-- Category Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingCategory">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory">
                  Category
                </button>
              </h2>
              <div id="collapseCategory" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                <div class="accordion-body p-0">
                  <ul class="list-group" id="category-list"></ul>
                </div>
              </div>
            </div>

            <!-- Brand Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingBrand">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand">
                  Brand
                </button>
              </h2>
              <div id="collapseBrand" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                <div class="accordion-body p-0">
                  <ul class="list-group" id="brand-list"></ul>
                </div>
              </div>
            </div>

            <!-- Sport Category Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSport">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSport">
                  Sport Category
                </button>
              </h2>
              <div id="collapseSport" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                <div class="accordion-body p-0">
                  <ul class="list-group" id="sport-category-list"></ul>
                </div>
              </div>
            </div>

            <!-- Price Range Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingPrice">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice">
                  Price Range
                </button>
              </h2>
              <div id="collapsePrice" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                <div class="accordion-body">
                  <div class="d-flex justify-content-between mb-2">
                    <span>RM 0</span>
                    <span id="price-value-label">RM 3000</span>
                  </div>
                  <input type="range" class="form-range" id="price-range" min="0" max="3000" step="50" value="3000">
                </div>
              </div>
            </div>
                <!-- Clear Button -->
                <div class="container my-3 ">
                    <button id="clear-filters" class="btn btn-info w-100">Clear</button>
                </div>
          </div>
        </div>
      </div>

      <!-- Product Grid -->
      <div class="col-md-9">
        <input type="text" id="search-input" class="form-control mb-4" placeholder="Search products..." onkeyup="searchProducts()">
        <div class="row" id="product-grid">
          <!-- Products will be dynamically injected here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Include JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{ asset('js/user/product.js') }}"></script>

</body>
@endsection
