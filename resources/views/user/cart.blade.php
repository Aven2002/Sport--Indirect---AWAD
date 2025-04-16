<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart - Sport Indirect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>

@extends('layouts.user')

@section('content')
@php
    // Dummy cart data for frontend demonstration
    $cartItems = [
        (object)[
            'id' => 1,
            'name' => 'Nike Dunk Low Retro',
            'category' => "Men's Shoe",
            'color' => 'White/White/Black',
            'size' => '10',
            'price' => 489.00,
            'quantity' => 1,
            'image' => '/images/category-fitness.png'
        ],
        (object)[
            'id' => 2,
            'name' => 'Nike Dunk Low Retro',
            'category' => "Men's Shoe",
            'color' => 'White/White/Black',
            'size' => '10.5',
            'price' => 489.00,
            'quantity' => 1,
            'image' => 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/0ccbd6b2-8561-4aa3-a4d3-f74c1f110443/dunk-low-retro-mens-shoes-6Q1tFQ.png'
        ]
    ];
@endphp

<div class="container mt-4">
    <h2 class="text-center fw-bold">Shopping Bag</h2>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            @foreach ($cartItems as $item)
            <div class="card mb-3 p-3 shadow-sm cart-item" data-id="{{ $item->id }}" data-base-price="{{ $item->price }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <img src="{{ $item->image }}" alt="Product Image" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">{{ $item->name }}</h5>
                        <p class="text-muted">{{ $item->category }}</p>
                        <p class="text-muted">{{ $item->color }}</p>
                        <p class="text-muted">Size: <strong>{{ $item->size }}</strong></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p class="fw-bold fs-5">RM {{ number_format($item->price, 2) }}</p>
                        <div class="d-flex align-items-center justify-content-end">
                            <button class="btn btn-outline-dark btn-sm minus-btn">-</button>
                            <span class="mx-2 quantity-value">{{ $item->quantity }}</span>
                            <button class="btn btn-dark btn-sm plus-btn">+</button>
                            <button class="btn btn-danger btn-sm ms-2 delete-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Summary Section -->
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm">
                <h3 class="fw-bold">Summary</h3>
                <div id="itemSummaries"></div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span id="finalTotal">RM 0.00</span>
                </div>
                <button class="btn btn-dark w-100 mt-3 checkout-btn" onclick="window.location.href='/checkout'">Checkout</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        function updateSummary() {
            let total = 0;
            const summaryContainer = document.getElementById("itemSummaries");
            summaryContainer.innerHTML = "";

            document.querySelectorAll(".cart-item").forEach(item => {
                let basePrice = parseFloat(item.getAttribute("data-base-price"));
                let quantity = parseInt(item.querySelector(".quantity-value").textContent);
                let subTotal = basePrice * quantity;
                total += subTotal;

                let row = document.createElement("div");
                row.classList.add("d-flex", "justify-content-between");
                let productName = item.querySelector("h5").textContent;
                row.innerHTML = `<span>${productName}:</span>
                                 <span>RM ${basePrice.toFixed(2)} x ${quantity} = RM ${subTotal.toFixed(2)}</span>`;
                summaryContainer.appendChild(row);
            });

            document.getElementById("finalTotal").textContent = `RM ${total.toFixed(2)}`;
        }

        updateSummary();

        document.querySelectorAll(".cart-item").forEach((item) => {
            const minusBtn = item.querySelector(".minus-btn");
            const plusBtn = item.querySelector(".plus-btn");
            const quantitySpan = item.querySelector(".quantity-value");
            let quantity = parseInt(quantitySpan.textContent);

            minusBtn.addEventListener("click", function () {
                if (quantity > 1) {
                    quantity--;
                    quantitySpan.textContent = quantity;
                    updateSummary();
                } else {
                    item.remove();
                    updateSummary();
                }
            });

            plusBtn.addEventListener("click", function () {
                quantity++;
                quantitySpan.textContent = quantity;
                updateSummary();
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
