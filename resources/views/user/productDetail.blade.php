@extends('layouts.user')

@section('content')
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

          <div class="row">
            <div class="col-6">
              <button class="btn btn-outline-dark w-100">Add to Cart</button>
            </div>
            <div class="col-6">
              <button class="btn btn-dark w-100">Checkout</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    const productId = window.location.pathname.split('/').pop();

    axios.get(`http://127.0.0.1:8000/api/product/${productId}`)
      .then(res => {
        const product = res.data.product;
        const detail = product.product_detail;

        // Set basic product info
        document.getElementById('productName').innerText = product.productName;
        document.getElementById('productPrice').innerText = `RM ${parseFloat(detail.price).toFixed(2)}`;
        document.getElementById('productBrand').innerText = product.productBrand;
        document.getElementById('description').innerText = detail.description;
        document.getElementById('mainImage').src = `/images/${detail.imgPath}`;

        if (!product.has_sizes) {
          document.getElementById('stockLabel').classList.remove('d-none');
          document.getElementById('stock').classList.remove('d-none');
          document.getElementById('stock').innerText = detail.stock ?? 'N/A';
        }

        // Render size selection if available
        if (product.has_sizes && product.product_stocks.length > 0) {
          const sizeContainer = document.getElementById('sizeOptions');
          document.getElementById('sizeSelection').style.display = 'block';

          product.product_stocks.forEach(stockItem => {
            const sizeBtn = document.createElement('button');
            sizeBtn.type = 'button';
            sizeBtn.className = `btn btn-sm btn-outline-primary rounded size-btn`;
            sizeBtn.innerText = `${stockItem.size} (${stockItem.stock})`;

            if (stockItem.stock === 0) {
              sizeBtn.classList.add('disabled', 'btn-outline-secondary');
              sizeBtn.classList.remove('btn-outline-primary');
            }

            sizeBtn.addEventListener('click', function () {
              document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
              sizeBtn.classList.add('active');
            });

            sizeContainer.appendChild(sizeBtn);
          });
        }
      })
      .catch(err => {
        console.error('Error fetching product:', err);
      });
  </script>
</body>
@endsection
