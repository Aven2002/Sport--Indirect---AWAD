let orders = []; 

document.addEventListener("DOMContentLoaded", function () {
    loadOrders();
});

function loadOrders() {
  axios.get("/api/order")
      .then(response => {
          // If response has 'orders', assign it; otherwise assign an empty array
          orders = response.data.orders ?? [];
          displayTable();
      })
      .catch(error => {
          console.error("Error loading orders:", error);
          document.querySelector("#orderTableBody").innerHTML = 
              `<tr><td colspan="9" class="text-center text-danger">Failed to load order records.</td></tr>`;
      });
}


function displayTable() {

    const tableBody = document.querySelector("#orderTableBody");
    tableBody.innerHTML = "";

    if (orders.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="12" class="text-center text-muted">No orders available.</td></tr>`;
      return;
  }
    orders.forEach(order => {
        let row = `
            <tr>
                <td>${order.id}</td>
                <td>${order.user_id}</td>
                <td>${order.address_id}</td>
                <td>${order.totalPrice}</td>
                <td>${order.paymentMethod}</td>
                <td>${order.status}</td>
                <td>${new Date(order.created_at).toLocaleString()}</td>
                <td>${new Date(order.updated_at).toLocaleString()}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button class="btn btn-info btn-sm" onclick="showOrderReceipt(${order.id})">More</button>
                        <button class="btn btn-warning btn-sm" onclick="UpdateOrderStatus(${order.id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteOrder(${order.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;

        tableBody.innerHTML += row;
    });
  }

async function showOrderReceipt(orderId) {
  try {

    const orderResponse = await axios.get(`/api/order/${orderId}`);
    const order = orderResponse.data.order;
    console.log(order);
   
    if (!order.order_detail || order.order_detail.length === 0) {
      throw new Error("No products found in order.");
    }

    const addressResponse = await axios.get(`/api/address/${order.address_id}`);
    const address = addressResponse.data.address;
   
    const productPromises = order.order_detail.map(orderDetail =>
      axios.get(`/api/product/${orderDetail.product_id}`)
    );
    const productResponses = await Promise.all(productPromises);

    const productList = productResponses.map((productResponse, index) => {
      const product = productResponse.data.product; 
      const orderProduct = order.order_detail[index];
      return `
        <tr>
          <td>${index + 1}</td>
          <td>${product.productName}</td>
          <td>${orderProduct.quantity}</td>
          <td>$${parseFloat(orderProduct.subPrice).toFixed(2)}</td>
        </tr>
      `;
    }).join('');

    document.getElementById("orderId").innerText = order.id;
    document.getElementById("recipientName").innerText = address.name;
    document.getElementById("contactNumber").innerText = address.phoneNo;
    document.getElementById("address").innerText = `${address.addressLine}, ${address.city}, ${address.state}, ${address.postcode}`;
    
    document.getElementById("productList").innerHTML = `
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subprice</th>
          </tr>
        </thead>
        <tbody>
          ${productList}
        </tbody>
      </table>
    `;
    
    document.getElementById("totalPrice").innerText = parseFloat(order.totalPrice).toFixed(2);

    let receiptModal = new bootstrap.Modal(document.getElementById("receiptModal"));
    receiptModal.show();
  } catch (error) {
    console.error("Error fetching order details:", error.response ? error.response.data : error.message);
    alert("Failed to load order details. Please try again.");
  }
}

window.deleteOrder = function (id) {
  if (confirm("Are you sure you want to cancel this order?")) {
      axios.delete(`/api/order/${id}`)
          .then(() => {
              showToast("Order cancelled successfully.", "success");
              loadOrders();
          })
          .catch(() => showToast("Error cancelling the order.", "error"));
  }
};

  function UpdateOrderStatus(id) {
    axios.get(`/api/order/${id}`)
        .then(response => {
            const order = response.data.order;

            if (!order) {
                alert("Order not found");
                return;
            }

            // Populate form fields with current order data
            document.getElementById("updateOrderId").value = order.id;
            document.getElementById("updateOrderStatus").value = order.status;

            // Show Bootstrap modal
            let updateModal = new bootstrap.Modal(document.getElementById("updateOrderModal"));
            updateModal.show();
        })
        .catch(error => {
            console.error("Error fetching order record:", error.response?.data || error.message);
            alert("Failed to fetch order details.");
        });
}


// Handle form submission --Update
document.getElementById("updateOrderForm").addEventListener("submit", function (event) {
  event.preventDefault();

  const orderId = document.getElementById("updateOrderId").value;
  
  const updatedOrder = {
      status: document.getElementById("updateOrderStatus").value.trim(),
  };
  console.log("Order ID being updated:", orderId);

  axios.put(`/api/order/${orderId}`, updatedOrder, {
      headers: {
          "Content-Type": "application/json"
      }
  })
  .then(response => {
      showToast("Order's status updated successfully.","success");
      loadOrders();
      let updateModal = bootstrap.Modal.getInstance(document.getElementById("updateOrderModal"));
      updateModal.hide();
  })
  .catch(error => {
      console.error("Error updating order's status:", error.response?.data || error.message);
      alert("Failed to update order. Check required fields.");
  });
});
  