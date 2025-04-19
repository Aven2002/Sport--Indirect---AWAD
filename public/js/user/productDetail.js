const productId = window.location.pathname.split('/').pop();
const checkoutBtn = document.querySelector('.btn-dark.w-100'); // Checkout button
let cartId = null;

  // Get user cart ID
  axios.get(`/api/cart/${userId}/user`)
    .then(res => {
      cartId = res.data.cartId;
    })
    .catch(err => {
      console.error('Cart not found:', err);
      showToast("Cart not found", "failure");
    });

// Get product info
axios.get(`/api/product/${productId}`)
  .then(res => {
    const product = res.data.product;
    const detail = product.product_detail;

    // Set basic product info
    document.getElementById('productName').innerText = product.productName;
    document.getElementById('productPrice').innerText = `RM ${parseFloat(detail.price).toFixed(2)}`;
    document.getElementById('productBrand').innerText = product.productBrand;
    document.getElementById('description').innerText = detail.description;
    document.getElementById('mainImage').src = `/images/${detail.imgPath}`;

    const quantityInput = document.getElementById('quantity');

    if (!product.has_sizes) {
      document.getElementById('stockLabel').classList.remove('d-none');
      document.getElementById('stock').classList.remove('d-none');
      const stock = detail.stock ?? 'N/A';
      document.getElementById('stock').innerText = stock;

      if (stock !== 'N/A') {
        quantityInput.max = stock;

        quantityInput.addEventListener('input', function () {
          if (parseInt(this.value) > stock) {
            this.value = stock;
          }
        });
      }
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

        // 👇 Put quantity check logic INSIDE this click handler
        sizeBtn.addEventListener('click', function () {
          document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
          sizeBtn.classList.add('active');

          const sizeStock = stockItem.stock;
          quantityInput.max = sizeStock;
          quantityInput.value = 1;

          quantityInput.addEventListener('input', function () {
            if (parseInt(this.value) > sizeStock) {
              this.value = sizeStock;
            }
          });
        });

        sizeContainer.appendChild(sizeBtn);
      });
    }
  })
  .catch(err => {
    console.error('Error fetching product:', err);
  });

// Add to Cart
document.querySelector('.btn-outline-dark').addEventListener('click', function () {
  const selectedSizeBtn = document.querySelector('.size-btn.active');
  const size = selectedSizeBtn ? selectedSizeBtn.innerText.split(' (')[0] : null;
  const quantity = parseInt(document.getElementById('quantity').value); 

  if (!size && document.getElementById('stockLabel').classList.contains('d-none')) {
    showToast("Please select a size", "failure");
    return;
  }

  if (!cartId) {
    showToast("Cart ID not loaded yet ", "failure");
    return;
  }

  const productToAdd = [{
    cart_id: cartId,
    product_id: productId,
    size: size || null,
    quantity: quantity
  }];

  axios.post('/api/cartDetail', { items: productToAdd }) 
    .then(res => {
      showToast("Item added to cart successfully", "success");
    })
    .catch(err => {
      console.error("Error adding to cart:", err);
      showToast("Failed to add item to cart", "failure");
    });
});
  
// Checkout
document.querySelector('.checkout-btn').addEventListener('click', function () {
  const selectedSizeBtn = document.querySelector('.size-btn.active');
  const size = selectedSizeBtn ? selectedSizeBtn.innerText.split(' (')[0] : null;
  const quantity = parseInt(document.getElementById('quantity').value); 

    if (!size && document.getElementById('stockLabel').classList.contains('d-none')) {
        showToast("Please select a size or check stock availability", "failure");
        return;
    }

    if (!cartId) {
        showToast("Cart ID not loaded yet", "failure");
        return;
    }
    const checkoutItem = [{
        product_id: productId,
        name: document.getElementById('productName').innerText,
        quantity: quantity,
        size: size || null,
        price: parseFloat(document.getElementById('productPrice').innerText.replace('RM ', '')),
    }];
    localStorage.setItem('checkoutItems', JSON.stringify(checkoutItem));
    window.location.href = "/user/checkout";
});
