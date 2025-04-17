@extends('layouts.user')

@section('content')
<div class="container mt-4" id="mainContainer">
    <h2 class="text-center fw-bold mb-2">Shopping Bag</h2>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-7 mb-3" id="cartContainer">
            <!-- Dynamic content goes here -->
        </div>

        <!-- Summary Section -->
        <div class="col-lg-5" id="summaryContainer">
            <div class="card p-4 shadow-sm">
                <h3 class="fw-bold">Summary</h3>
                <div id="itemSummaries"></div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span id="finalTotal">RM 0.00</span>
                </div>
                <button class="btn btn-dark w-100 mt-3 checkout-btn" id="checkoutBtn">Checkout</button>
            </div>
        </div>
    </div>
</div>

<script>
    const userId = @json(auth()->id());
</script>
<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/user/cart.js') }}"></script>
@endsection
