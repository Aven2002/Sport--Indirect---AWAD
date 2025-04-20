@extends('layouts.admin')

@section('title', 'Order Management - Sport Indirect')

@section('content')

@include('components.toast')

<div class="container mt-2">
    <h1 class="text-center">Order Management</h1>

    <!-- Order List Table -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Address ID</th>
                <th>T.Amount</th>
                <th>P.Method</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="orderTableBody">
            <!-- Order data will be inserted here -->
        </tbody>
    </table>

    <!-- Bootstrap Pagination -->
    <nav>
        <ul class="pagination justify-content-center" id="pagination">
            <!-- Pagination buttons will be generated dynamically -->
        </ul>
    </nav>

</div>

<!-- Order Details  Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Order Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5 class="mb-4">Order ID: <span id="orderId"></span></h5>
        <div class="row mb-3">
            <div class="col-6">
            <strong>Recipient Name:</strong> <span id="recipientName"></span>
            </div>
            <div class="col-6">
            <strong>Contact Number:</strong> <span id="contactNumber"></span>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="col-6 mb-5">
            <strong>Shipping Address:</strong> <span id="address"></span>
        </div>

        <h6>Products:</h6>
        <ul id="productList" class="list-group">
          <!-- Product list will be populated here -->
        </ul>

        <h5 class="mt-3">Total Price: $<span id="totalPrice"></span></h5>
      </div>
    </div>
  </div>
</div>


<!-- Update Order Modal -->
<div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateOrderForm">
                    <input type="hidden" id="updateOrderId">
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select id="updateOrderStatus" class="form-select" required>
                            <option value="Processing">Processing</option>
                            <option value="Shipping">Shipping</option>
                            <option value="Completed">Completed</option>
                            <option value="Return">Return & Refund</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageOrders.js') }}"></script>
@endsection


