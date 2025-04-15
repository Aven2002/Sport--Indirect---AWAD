@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sport Indirect')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Explore Our Key Services</h2>

    <div class="row justify-content-center mt-4">
        <!-- Manage Product -->
        <div class="col-md-4 col-sm-6 mb-4">
            <a href="{{ route('admin.manageProducts') }}" class="text-decoration-none">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <i class="bi bi-search icon"></i>
                        <h5 class="fw-bold mt-2">Manage Product</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Manage Account -->
        <div class="col-md-4 col-sm-6 mb-4">
            <a href="{{ route('admin.manageAccounts') }}" class="text-decoration-none">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <i class="bi bi-people icon"></i>
                        <h5 class="fw-bold mt-2">Manage Account</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Manage Feedback -->
        <div class="col-md-4 col-sm-6 mb-4">
            <a href="{{ route('admin.manageFeedbacks') }}" class="text-decoration-none">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <i class="bi bi-chat-dots icon"></i>
                        <h5 class="fw-bold mt-2">Manage Feedback</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Manage Order -->
        <div class="col-md-4 col-sm-6 mb-4">
            <a href="{{ route('admin.manageOrders') }}" class="text-decoration-none">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <i class="bi bi-receipt icon"></i>
                        <h5 class="fw-bold mt-2">Manage Order</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Manage Store-->
        <div class="col-md-4 col-sm-6 mb-4">
            <a href="{{ route('admin.manageStores') }}" class="text-decoration-none">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <i class="bi bi-shop icon"></i>
                        <h5 class="fw-bold mt-2">Manage Store</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Custom Styles -->
<style>
    .service-card {
        background-color: #d3d8c5; /* Light green */
        border: 2px solid #5b2c2c; /* Dark red border */
        border-radius: 10px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
    }

    .icon {
        font-size: 50px;
        color: #000;
    }

    h5 {
        color: #5b2c2c; /* Dark red */
    }
</style>
@endsection
