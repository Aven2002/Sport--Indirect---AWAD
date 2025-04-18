document.addEventListener("DOMContentLoaded", async () => {
    // Select the Place Order button
    const placeOrderButton = document.querySelector('button[type="submit"]');
    const selectedItems = JSON.parse(localStorage.getItem("selectedCartItems") || "[]");
    
    placeOrderButton.addEventListener('click', async (e) => {
        e.preventDefault();  // Prevent default form submission
    
        // Get the necessary data from the form or localStorage
        let selectedAddressId = document.getElementById("selectedAddressId").value;
        let totalPrice = parseFloat(document.getElementById("totalPrice").value).toFixed(2);
        totalPrice = parseFloat(totalPrice); 
        const paymentMethod = document.getElementById("paymentMethod").value;  
    
        // Validate that we have the necessary data
        if (!selectedAddressId || !totalPrice || !paymentMethod || !selectedItems.length) {
            alert("Please make sure all the fields are filled correctly.");
            return;
        }

        selectedItems.forEach(item => {
            item.subPrice = item.price * item.quantity;  // Calculate subPrice for each item
            console.log("Selected item:", item);
            console.log("Product ID:", item.product_id);
            console.log("Price:", item.price);
            console.log("Size:", item.size);
            console.log("Quantity:", item.quantity);
            console.log("SubPrice:", item.subPrice);
        });
        
        // Now you can save the updated selectedItems with subPrice back to localStorage
        localStorage.setItem("selectedCartItems", JSON.stringify(selectedItems));
        
        // Verify if the updated selectedItems are correctly stored
        console.log("Updated selectedItems in localStorage:", selectedItems);

        // Create the order payload
        const orderData = {
            user_id: userId,
            address_id: selectedAddressId,
            totalPrice: totalPrice,
            paymentMethod: paymentMethod,
            items: selectedItems.map(item => ({
                product_id: item.productId,
                size: item.size,
                quantity: item.quantity,
                subPrice: item.subtotal
            }))
        };
    
        // Log the orderData to see what is going to be submitted
        console.log("Items to submit:", orderData);
    
        try {
            // Send POST request to create the order
            const response = await axios.post('http://127.0.0.1:8000/api/order', orderData);
    
            // Handle successful order creation
            if (response.status === 201) {
                alert("Order placed successfully!");
                // Optionally, redirect to a success page or clear the cart
                localStorage.removeItem("selectedCartItems");
                window.location.href = '/order/success';  // Replace with your actual success page URL
            } else {
                alert("Failed to place the order. Please try again.");
            }
        } catch (error) {
            console.error("Error placing order:", error);
            alert("An error occurred while placing your order. Please try again later.");
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

    if (!selectedItems.length) {
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

    selectedItems.forEach((item, index) => {
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
    itemsField.value = JSON.stringify(selectedItems);
});
