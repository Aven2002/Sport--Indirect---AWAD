@extends('layouts.user')

@section('content')

@include('components.toast')
<body>
  <div class="container mt-4">
    <div class="row">
      <!-- Image Section -->
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="mb-3 w-100">
          <img id="mainImage" src="" alt="Product Image" class="img-fluid rounded w-100" style="max-height: 500px; object-fit: contain;">
        </div>
      </div>

      <!-- Product Details Section -->
      <div class="col-md-6 d-flex flex-column">
        <!-- Top Part: Info -->
        <div class="mb-4">
          <h2 class="fw-bold" id="productName"></h2>
          <p class="fs-4 fw-bold text-primary" id="productPrice"></p>
          <p class="mb-1">Brand:</p>
          <p class="fs-5 fw-bold" id="productBrand"></p>

          <p class="mb-1 d-none" id="stockLabel">Stock Left:</p>
          <p class="fs-5 fw-bold d-none" id="stock"></p>

          <p class="mb-1">Description:</p>
          <p class="fs-6" id="description"></p>
        </div>

        <!-- Bottom Part: Sizes and Actions -->
        <div class="mb-5">
          <div id="sizeSelection" class="mb-3" style="display: none;">
            <label for="sizeOptions" class="form-label fw-bold">Select Size:</label>
            <div class="d-flex flex-wrap gap-2" id="sizeOptions"></div>
          </div>

          <!-- Quantity Selection -->
        <div class="mb-3" id="quantitySelection">
          <label for="quantity" class="form-label fw-bold">Quantity:</label>
          <div class="d-flex align-items-center">
            <input type="number" name="quantity" id="quantity" class="form-control mx-2" min="1" value="1" />
          </div>
        </div>



          <div class="row">
            <div class="col-6">
              <button class="btn btn-outline-dark w-100">Add to Cart</button>
            </div>
            <div class="col-6">
              <button class="btn btn-dark checkout-btn w-100">Checkout</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const userId = @json(auth()->id());
</script>
  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{ asset('js/user/productDetail.js') }}"></script>
</body>
@endsection
