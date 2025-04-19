@extends('layouts.user')

@section('content')

@include('components.toast')
<div class="container mt-4">
    <form id="checkoutForm">
        <div class="row">
            <!-- Left Section: Order Details -->
            <div class="col-md-8">
                <h4 class="mb-3">Order Details</h4>
                <div id="checkoutSummary" class="mb-4"></div>
                <div class="mb-3">
                    <p><strong>Total Amount: RM <span id="totalAmount">0.00</span></strong></p>
                </div>
            </div>

            <!-- Right Section: Payment and Address Selection -->
            <div class="col-md-4">
                <!-- Default Address Preview -->
                <div class="mb-3" id="defaultAddressPreview" style="display: none;">
                    <label class="form-label">Shipping To:</label>
                    <div class="border p-3 rounded bg-light">
                        <p id="defaultAddressText" class="mb-0"></p>
                    </div>
                </div>

                <!-- Open Address Book -->
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addressBookModal">
                        📒 Open Address Book
                    </button>
                </div>

                <!-- Add New Address -->
                <div class="mb-3 text-center">
                    <a href="{{ route('user.address') }}" class="btn btn-sm btn-success">+ Add New Address</a>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="paymentMethod" class="form-label">Payment Method</label>
                    <select class="form-select" name="paymentMethod" id="paymentMethod" required>
                        <option value="Online Banking">Online Banking</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="E- Wallet">E- Wallet</option>
                        <option value="COD">Cash on Delivery</option>
                    </select>
                </div>

                <button type="submit" id="placeOrder-btn" class="btn btn-success mb-5 mt-5 w-100">Place Order</button>
            </div>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="totalPrice" id="totalPrice">
        <input type="hidden" name="items" id="items">
        <input type="hidden" name="address_id" id="selectedAddressId">
    </form>

    <!-- Address Book Modal -->
    <div class="modal fade" id="addressBookModal" tabindex="-1" aria-labelledby="addressBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📍 Address Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="addressBookContent">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const userId = @json(auth()->id());
</script>
<script src="{{ asset('js/user/checkout.js') }}"></script>
@endsection


