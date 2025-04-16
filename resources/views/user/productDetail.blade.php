<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details - Sport Indirect</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/productdetail.css') }}">
</head>

@extends('layouts.user')

@section('content')

<body>
    @php
    $product = (object)[
        'name' => 'Nike Vomero 18',
        'price' => 'RM 669',
        'description' => 'Experience supreme comfort and support with the Nike Vomero 18, designed for long-distance running. Its soft cushioning and breathable upper provide unmatched performance.',
        'main_image' => asset('images/Nike Vomero 18.png'),
        'gallery' => [
            asset('images/category-basketball.png'),
            asset('images/category-basketball.png')
        ],
        'colors' => [
            ['color' => 'black', 'image' => asset('images/category-basketball.png')],
            ['color' => 'gray', 'image' => asset('images/category-basketball.png')],
            ['color' => 'blue', 'image' => asset('images/category-basketball.png')]
        ],
        'sizes' => ['US 7', 'US 8', 'US 9', 'US 10'],
        'reviews' => [
            ['name' => 'John Doe', 'rating' => 5, 'comment' => 'Great comfort and support! Perfect for long runs.'],
            ['name' => 'Jane Smith', 'rating' => 4, 'comment' => 'Very comfortable, but took a while to break in.'],
            ['name' => 'Mike Lee', 'rating' => 5, 'comment' => 'Best running shoes I’ve ever owned!']
        ]
    ];
    @endphp

    <div class="container mt-4">
        <div class="row">
            <!-- Image Section -->
            <div class="col-md-6">
                <div class="mb-3">
                    <img id="mainImage" src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid rounded">
                </div>
                <div class="d-flex gap-2">
                    @foreach ($product->gallery as $galleryImage)
                        <img src="{{ $galleryImage }}" alt="Gallery Image" class="img-thumbnail" onclick="changeMainImage('{{ $galleryImage }}')">
                    @endforeach
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-md-6">
                <h2 class="fw-bold">{{ $product->name }}</h2>
                <p class="fs-4 fw-bold">{{ $product->price }}</p>

                <!-- Color Selection -->
                <div class="mt-3">
                    <p class="mb-1">Select Color:</p>
                    <div class="d-flex gap-2">
                        @foreach ($product->colors as $colorOption)
                            <div class="color-box" style="background: {{ $colorOption['color'] }};" 
                                onclick="selectColor('{{ $colorOption['color'] }}', '{{ $colorOption['image'] }}', event)">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="mt-3">
                    <p class="mb-1">Select Size:</p>
                    <div class="d-flex gap-2">
                        @foreach ($product->sizes as $size)
                            <div class="size-box" onclick="selectSize(event)">{{ $size }}</div>
                        @endforeach
                    </div>
                </div>

                <button class="btn w-100 mt-4 add-to-cart" style="background-color: white; color: black; border: 2px solid black;">
                    Add to Bag
                </button>
                <div class="mt-4 text-white">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h3 class="fw-bold">Customer Reviews</h3>
            @foreach ($product->reviews as $review)
                <div class="review p-3 rounded mt-2">
                    <p class="fw-bold mb-1">{{ $review['name'] }} - 
                        @for ($i = 0; $i < $review['rating']; $i++)
                            ★
                        @endfor
                    </p>
                    <p class="mb-0">{{ $review['comment'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        let selectedColor = null;
        let selectedSize = null;

        function changeMainImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }

        function selectColor(color, imageSrc, event) {
            selectedColor = color;
            changeMainImage(imageSrc);

            document.querySelectorAll('.color-box').forEach(box => box.classList.remove('selected'));
            event.target.classList.add('selected');

            document.querySelectorAll('.size-box').forEach(size => size.classList.add('enabled'));
            selectedSize = null;
            document.querySelector('.add-to-cart').classList.remove('enabled');
        }

        function selectSize(event) {
            selectedSize = event.target.innerText;
            document.querySelectorAll('.size-box').forEach(size => size.classList.remove('selected'));
            event.target.classList.add('selected');

            if (selectedColor) {
                document.querySelector('.add-to-cart').classList.add('enabled');
            }
        }
    </script>
</body>
</html>
@endsection
