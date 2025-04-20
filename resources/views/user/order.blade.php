@extends('layouts.user')

@section('title', 'Track Your Orders')

@section('content')

@include('components.toast')
<div class="container my-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 900px;">
        <h2 class="text-center mb-4">Your Orders</h2>
        
        <!-- If no orders exist -->
        <div id="noOrdersMessage" class="alert alert-info" style="display: none;" role="alert">
            You have not placed any orders yet. Start shopping now!
        </div>

        <ul class="nav nav-pills mb-3 justify-content-center" id="orderTabs">
    <li class="nav-item">
        <a class="nav-link active" data-status="Processing" href="#">To Ship</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-status="Shipping" href="#">To Receive</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-status="Completed" href="#">To Rate</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-status="Return" href="#">Return & Refund</a>
    </li>
</ul>

        <!-- Orders Table -->
        <table id="ordersTable" class="table table-striped table-bordered" style="display: none;">
            <thead class="thead-dark text-center">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Shipping Address</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="ordersBody">
                <!-- Orders will be populated here via JS -->
            </tbody>
        </table>
        </table>
    </div>
</div>

<script>
    const userId = @json(auth()->id());
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/user/order.js') }}"></script> 
@endsection
