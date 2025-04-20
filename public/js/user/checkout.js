document.addEventListener("DOMContentLoaded", async () => {
    // Select the Place Order button
    const placeOrderButton = document.getElementById('placeOrder-btn');
    const items = JSON.parse(localStorage.getItem('checkoutItems') || "[]"); // Data from local storage from other view
    const cartDetailId = items.length > 0 ? items.map(item => item.id) : null;

    placeOrderButton.addEventListener('click', async (e) => {
        e.preventDefault();  // Prevent default form submission
    
        // Get the necessary data from the form or localStorage
        let selectedAddressId = document.getElementById("selectedAddressId").value;
        let totalPrice = parseFloat(document.getElementById("totalPrice").value).toFixed(2);
        totalPrice = parseFloat(totalPrice); 
        const paymentMethod = document.getElementById("paymentMethod").value;  
    
        // Validate that we have the necessary data
        if (!selectedAddressId || !totalPrice || !paymentMethod || !items.length) {
            showToast("Please make sure all the fields are filled correctly", "failure");
            return;
        }

        items.forEach(item => {
            item.subPrice = item.price * item.quantity; 
        });

        // Create the order payload
        const orderData = {
            user_id: userId,
            address_id: selectedAddressId,
            totalPrice: totalPrice,
            paymentMethod: paymentMethod,
            items: items.map(item => ({
                product_id: item.product_id,
                size: item.size,
                quantity: item.quantity,
                subPrice: item.subPrice
            }))
        };
    
        try {
            // Send POST request to create the order
            const response = await axios.post('/api/order', orderData);
    
            // Handle successful order creation
            if (response.status === 201) {
                showToast("Order placed successfully", "success");
                localStorage.removeItem("checkoutItems");
                checkoutSummary.innerHTML = `<p>No items selected for checkout.</p>`;
                totalAmount.textContent = "0.00";
                totalPrice.value = "0.00";
                itemsField.value = "";
                placeOrderButton.disabled = true;

                // If have id mean checkout from cart since product will i didnt pass the cartDetail_id, so remove from cart
                if (cartDetailId.length > 0) {
                    cartDetailId.forEach(cartItemId => {
                        axios.delete(`/api/cartDetail/${cartItemId}`)
                            .then(response => {
                                console.log('Item removed from cart:', response);
                            })
                            .catch(error => {
                                console.error('Error removing item from cart:', error);
                            });
                    });
                }                

            } else {
                showToast("Failed to place the order. Please try again", "failure");
            }
        } catch (error) {
            console.error("Error placing order:", error);
            showToast("An error occurred while placing your order. Please try again later", "failure");
        }
    });
      
    

    // Your existing code logic goes here (e.g., loading addresses, cart, etc.)
    const defaultAddressPreview = document.getElementById("defaultAddressPreview");
    const defaultAddressText = document.getElementById("defaultAddressText");
    const selectedAddressId = document.getElementById("selectedAddressId");
    const addressBookContent = document.getElementById("addressBookContent");

    // Load default address
    try {
        const res = await axios.get(`/api/address/${userId}/user`);
        const addresses = res.data.addresses ?? [];

        if (addresses.length > 0) {
            const defaultAddr = addresses[0];
            const fullText = `${defaultAddr.name}, ${defaultAddr.phoneNo}, ${defaultAddr.addressLine}, ${defaultAddr.postcode}, ${defaultAddr.city}, ${defaultAddr.state}`;

            defaultAddressText.textContent = fullText;
            defaultAddressPreview.style.display = "block";
            selectedAddressId.value = defaultAddr.id;
        } else {
            defaultAddressPreview.innerHTML = `<div class="alert alert-warning">No address found. Please <a href='/user/address'>add one</a>.</div>`;
        }
    } catch (err) {
        console.error("Failed to load default address:", err);
    }

    // Load address book modal content
    document.getElementById('addressBookModal').addEventListener('show.bs.modal', async () => {
        try {
            const res = await axios.get(`/api/address/${userId}/user`);
            const addresses = res.data.addresses ?? [];

            if (addresses.length === 0) {
                addressBookContent.innerHTML = `<p>No saved addresses found.</p>`;
                return;
            }

            const cards = addresses.map(addr => `
                <div class="card mb-2 select-address" 
                    data-id="${addr.id}" 
                    data-address="${addr.name}, ${addr.phoneNo}, ${addr.addressLine}, ${addr.postcode}, ${addr.city}, ${addr.state}" 
                    style="cursor: pointer;">
                    <div class="card-body">
                        <p class="mb-1">${addr.name}, ${addr.phoneNo}<br>
                        ${addr.addressLine}, ${addr.postcode}, ${addr.city}, ${addr.state}
                        ${addr.is_default ? '<span class="badge bg-success ms-2">Default</span>' : ''}</p>
                    </div>
                </div>
            `).join("");

            addressBookContent.innerHTML = cards;
        } catch (err) {
            console.error("Error loading address book:", err);
            addressBookContent.innerHTML = `<div class="alert alert-danger">Failed to load address book.</div>`;
        }
    });

    // Delegate address selection inside modal
    addressBookContent.addEventListener("click", (e) => {
        const card = e.target.closest(".select-address");
        if (card) {
            const id = card.getAttribute("data-id");
            const address = card.getAttribute("data-address");

            selectedAddressId.value = id;
            defaultAddressText.textContent = address;
            defaultAddressPreview.style.display = "block";

            const modal = bootstrap.Modal.getInstance(document.getElementById('addressBookModal'));
            modal.hide();
        }
    });

    // Handle checkout items from localStorage
    const checkoutSummary = document.getElementById("checkoutSummary");
    const totalAmount = document.getElementById("totalAmount");
    const totalPrice = document.getElementById("totalPrice");
    const itemsField = document.getElementById("items");

    if (!items.length) {
        checkoutSummary.innerHTML = `<p>No items selected for checkout.</p>`;
        return;
    }

    let total = 0;
    let summaryHTML = `
        <div class="table-responsive rounded shadow-sm border">
            <table class="table table-hover table-striped mb-0">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 40%;">Product</th>
                        <th style="width: 15%;">Quantity</th>
                        <th style="width: 20%;">Price (RM)</th>
                        <th style="width: 20%;">Subtotal (RM)</th>
                    </tr>
                </thead>
                <tbody
    `;

    items.forEach((item, index) => {
        const subtotal = item.quantity * item.price;
        total += subtotal;
        summaryHTML += `
            <tr class="text-center align-middle">
                <td>${index + 1}</td>
                <td>${item.name} ${item.size ? `(${item.size})` : ''}</td>
                <td>${item.quantity}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${subtotal.toFixed(2)}</td>
            </tr>
        `;
    });

    summaryHTML += `
                </tbody>
            </table>
        </div>
    `;

    checkoutSummary.innerHTML = summaryHTML;
    totalAmount.textContent = total.toFixed(2);
    totalPrice.value = total.toFixed(2);
    itemsField.value = JSON.stringify(items);
});
