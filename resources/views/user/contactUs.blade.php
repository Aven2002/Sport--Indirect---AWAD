@extends('layouts.user')

@section('content')
<head>
    <title>Product - Sport Indirect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user/contactUs.css') }}">
</head>

<div class="container contact-page shadow-lg rounded">
    <h2 class="fw-bold text-center">Contact Us</h2>
    <p class="text-dark">Fill out the form below with your inquiry and we will get back to you soon.</p>

    <div id="alert-container"></div> {{-- Bootstrap Alert Container --}}

    <form id="contact-form">
        @csrf {{-- CSRF Token for Security --}}
        
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Your Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label fw-bold">Subject:</label>
            <select class="form-select" id="subject" name="subject" required>
                <option value="" selected disabled>Select a subject</option>
                <option value="General Inquiry">General Inquiry</option>
                <option value="Product Support">Product Support</option>
                <option value="Order Issue">Order Issue</option>
                <option value="Feedback & Suggestions">Feedback & Suggestions</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label fw-bold">Your Message:</label>
            <textarea class="form-control" id="message" name="message" placeholder="Type your message here" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Send Message</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/user/contactUs.js') }}"></script>
@endsection
