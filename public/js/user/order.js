let allOrders = []; 

axios.get(`/api/order/user/${userId}`)
    .then(response => {
        console.log("Received orders data:", response.data);
        allOrders = response.data.order;
        const ordersTable = document.getElementById('ordersTable');
        const noOrdersMessage = document.getElementById('noOrdersMessage');

        if (allOrders.length === 0) {
            noOrdersMessage.style.display = 'block';
            ordersTable.style.display = 'none';
        } else {
            noOrdersMessage.style.display = 'none';
            ordersTable.style.display = 'table';
            renderOrdersByStatus('Processing'); // Default to "To Ship"
        }
    })
    .catch(error => {
        console.error('Error fetching orders:', error);
    });
    
function renderOrdersByStatus(status) {
    const ordersBody = document.getElementById('ordersBody');
    ordersBody.innerHTML = ''; // Clear current rows

    const filteredOrders = allOrders.filter(o => o.status === status);

    if (filteredOrders.length === 0) {
        ordersBody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No orders found for this category.</td></tr>`;
        return;
    }

    filteredOrders.forEach(async order => {
        const addressId = order.address_id;

        try {
            const addressRes = await axios.get(`/api/address/${addressId}`);
            const address = addressRes.data.address;

            const fullAddress = `${address.addressLine}, ${address.state}`;
            const contactInfo = `${address.name} (${address.phoneNo})`;

            let imgHtml = '<span class="text-muted">No Product</span>';
            if (order.order_detail.length > 0) {
                const productId = order.order_detail[0].product_id;
                const productRes = await axios.get(`/api/product/${productId}`);
                const imgPath = productRes.data.product.product_detail.imgPath;
                imgHtml = `<img src="/images/${imgPath}" alt="Product" style="width: 60px; height: auto;">`;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${imgHtml}</td>
                <td>${contactInfo}<br><small>${fullAddress}</small></td>
                <td>${order.paymentMethod}</td>
                <td>$${parseFloat(order.totalPrice).toFixed(2)}</td>
                <td>${order.status}</td>
            `;
            ordersBody.appendChild(row);
        } catch (err) {
            console.error(`Error with order ${order.id}:`, err);
        }
    });
}

// Tab click handler
document.querySelectorAll('#orderTabs .nav-link').forEach(tab => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('#orderTabs .nav-link').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const status = this.getAttribute('data-status');
        renderOrdersByStatus(status);
    });
});