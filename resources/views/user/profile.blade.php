<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - Sport Indirect</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

@extends('layouts.user')

@section('title', 'User Profile')

@section('content')
@php
    $userProfile = (object)[
        'email' => 'alice@example.com',
        'username' => 'Alice Smith',
        'dob' => '1990-01-01',
        'photo' => '/images/default-profile.png'
    ];
@endphp

<div class="container my-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
        <h2 class="text-center mb-4">User Profile</h2>
        <form action="/profile/update" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Photo -->
            <div class="text-center mb-3">
                <img src="{{ asset($userProfile->photo) }}" alt="Profile Photo" id="previewPhoto" class="rounded-circle border border-secondary" width="150" height="150">
                <div class="mt-2">
                    <label for="profilePhoto" class="btn btn-dark btn-sm">Choose File</label>
                    <input type="file" name="photo" id="profilePhoto" accept="image/*" class="d-none" onchange="previewImage(event)">
                </div>
            </div>

            <!-- Email (non-editable) -->
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <p class="form-control bg-light">{{ $userProfile->email }}</p>
            </div>

            <!-- Username (editable) -->
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <div class="d-flex align-items-center">
                    <span id="usernameDisplay" class="form-control bg-light me-2">{{ $userProfile->username }}</span>
                    <input type="text" name="username" id="usernameInput" value="{{ $userProfile->username }}" class="form-control d-none">
                    <span class="text-primary ms-2" role="button" onclick="enableEditUsername()">&#9998;</span>
                </div>
            </div>

            <!-- Date of Birth (non-editable) -->
            <div class="mb-3">
                <label class="form-label">Date of Birth:</label>
                <p class="form-control bg-light">{{ $userProfile->dob }}</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-dark w-100">Update Profile</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var output = document.getElementById('previewPhoto');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
    function enableEditUsername() {
        document.getElementById('usernameDisplay').classList.add('d-none');
        document.getElementById('usernameInput').classList.remove('d-none');
        document.getElementById('usernameInput').focus();
    }
</script>

@endsection
