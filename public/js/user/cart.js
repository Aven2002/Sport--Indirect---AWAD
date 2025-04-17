document.addEventListener("DOMContentLoaded", function () {
    const mainContainer = document.getElementById("mainContainer");
    const checkoutBtn = document.querySelector(".checkout-btn");
    let cartItems = [];

    if (!userId) {
        console.error("User is not authenticated");
        return;
    }

    async function fetchCartId() {
        try {
            const cartResponse = await axios.get(`/api/cart/${userId}/user`);
            const cartId = cartResponse.data.cartId;

            if (cartId) {
                fetchCartDetails(cartId);
            } else {
                mainContainer.innerHTML = `
                    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                        <img src="/images/Default/_cart.png" alt="Cart Not Found" class="img-fluid" style="max-width: 400px;">
                        <p class="mt-3 mb-5 text-center">Your cart is empty. Start shopping now!</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error("Error loading cart ID:", error);
        }
    }

    async function fetchCartDetails(cartId) {
        try {
            const response = await axios.get(`/api/cartDetail/${cartId}`);
            if (response.data.message === "Cart Detail not found") {
                mainContainer.innerHTML = `
                    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                        <img src="/images/Default/_cart.png" alt="Cart Not Found" class="img-fluid" style="max-width: 400px;">
                        <p class="mt-3 mb-5 text-center">Your cart is empty. Start shopping now!</p>
                    </div>
                `;
            } else {
                const cartDetails = response.data.cartDetail;

                const productPromises = cartDetails.map(async (item) => {
                    const productRes = await axios.get(`/api/product/${item.product_id}`);
                    return {
                        id: item.id,
                        product_id: item.product_id,
                        cart_id: item.cart_id,
                        size: item.size,
                        quantity: item.quantity,
                        price: parseFloat(productRes.data.product.product_detail.price),
                        name: productRes.data.product.productName,
                        category: productRes.data.product.productCategory,
                        image: getSafeImagePath(productRes.data.product.product_detail.imgPath),
                        selected: false // default not selected
                    };
                });

                cartItems = await Promise.all(productPromises);
                renderCart();
                updateSummary();
                setupCheckoutButton(); // Setup event listener after cart is loaded
            }
        } catch (error) {
            console.error("Error loading cart:", error);
        }
    }

    function renderCart() {
        const cartContainer = document.getElementById("cartContainer");
        cartContainer.innerHTML = "";

        cartItems.forEach((item, index) => {
            const card = document.createElement("div");
            card.className = "card mb-3 p-3 shadow-sm cart-item";
            card.setAttribute("data-index", index);
            card.setAttribute("data-base-price", item.price);

            card.innerHTML = `
                <div class="row g-3 align-items-center">
                    <div class="col-md-1 text-center">
                        <input type="checkbox" class="form-check-input item-checkbox" data-index="${index}">
                    </div>
                    <div class="col-md-2">
                        <img src="${item.image}" alt="Product Image" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">${item.name}</h5>
                        <p class="text-muted">${item.category}</p>
                        <p class="text-muted">Size: <strong>${item.size || '-'}</strong></p>
                    </div>
                    <div class="col-md-3 text-end">
                        <p class="fw-bold fs-5">RM ${item.price.toFixed(2)}</p>
                        <div class="d-flex align-items-center justify-content-end">
                            <button class="btn btn-outline-dark btn-sm minus-btn">-</button>
                            <span class="mx-2 quantity-value">${item.quantity}</span>
                            <button class="btn btn-dark btn-sm plus-btn">+</button>
                            <button class="btn btn-danger btn-sm ms-2 delete-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            `;
            cartContainer.appendChild(card);

            const deleteBtn = card.querySelector(".delete-btn");
            deleteBtn.addEventListener("click", async () => {
                const confirmDelete = confirm("Are you sure you want to remove this item?");
                if (!confirmDelete) return;

                const itemId = cartItems[index].id;

                try {
                    await axios.delete(`/api/cartDetail/${itemId}`);
                    fetchCartDetails(cartItems[index].cart_id);
                } catch (error) {
                    console.error("Error deleting item:", error);
                    alert("Failed to delete item. Please try again.");
                }
            });

            // Handle selection
            const checkbox = card.querySelector(".item-checkbox");
            checkbox.addEventListener("change", () => {
                cartItems[index].selected = checkbox.checked;
                updateSummary();
            
                const anySelected = cartItems.some(item => item.selected);
                checkoutBtn.disabled = !anySelected;
            });
            
        });

        addQuantityListeners();
    }

    function updateSummary() {
        let total = 0;
        const summaryContainer = document.getElementById("itemSummaries");
        summaryContainer.innerHTML = "";

        cartItems.forEach((item) => {
            if (item.selected) {
                const subTotal = item.price * item.quantity;
                total += subTotal;

                const row = document.createElement("div");
                row.classList.add("d-flex", "justify-content-between");
                row.innerHTML = `<span>${item.name}:</span><span>RM ${subTotal.toFixed(2)}</span>`;
                summaryContainer.appendChild(row);
            }
        });

        document.getElementById("finalTotal").textContent = `RM ${total.toFixed(2)}`;
    }

    function addQuantityListeners() {
        document.querySelectorAll(".cart-item").forEach(item => {
            const index = item.getAttribute("data-index");
            const minusBtn = item.querySelector(".minus-btn");
            const plusBtn = item.querySelector(".plus-btn");

            minusBtn.addEventListener("click", () => {
                if (cartItems[index].quantity > 1) {
                    cartItems[index].quantity--;
                } else {
                    cartItems.splice(index, 1);
                    item.remove();
                }
                renderCart();
                updateSummary();
            });

            plusBtn.addEventListener("click", () => {
                cartItems[index].quantity++;
                renderCart();
                updateSummary();
            });
        });
    }

    function setupCheckoutButton() {
        checkoutBtn.addEventListener("click", () => {
            const selected = cartItems.filter(item => item.selected);
            localStorage.setItem("selectedCartItems", JSON.stringify(selected));

            console.log("Selected Cart Items:", selected);

            if (selected.length === 0) {
                checkoutBtn.disabled = true;
                return;
            }

            checkoutBtn.disabled = false;
            window.location.href = "/user/checkout";
        });

        // Initially disable until something is selected
        checkoutBtn.disabled = true;
    }

    function getSafeImagePath(imgPath) {
        if (!imgPath) return "/images/Default/_cart.png";
        const parts = imgPath.split('/');
        const fileName = encodeURIComponent(parts.pop());
        return `/images/${parts.join('/')}/${fileName}`;
    }

    fetchCartId();
});
