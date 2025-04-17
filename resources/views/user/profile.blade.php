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
<div class="container my-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
        <h2 class="text-center mb-4">User Profile</h2>
        <form id="profileForm" action="/profile/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Photo -->
            <div class="text-center mb-3">
                <img src="" alt="Profile Photo" id="previewPhoto" class="rounded-circle border border-secondary" width="150" height="150">
                <div class="mt-2">
                    <label for="profilePhoto" class="btn btn-dark btn-sm">Choose File</label>
                    <input type="file" name="photo" id="profilePhoto" accept="image/*" class="d-none" onchange="previewImage(event)">
                </div>
            </div>

            <!-- Email (non-editable) -->
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <p class="form-control bg-light" id="emailDisplay"></p>
            </div>

            <!-- Username (editable) -->
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <div class="d-flex align-items-center">
                    <span id="usernameDisplay" class="form-control bg-light me-2"></span>
                    <input type="text" name="username" id="usernameInput" class="form-control d-none">
                    <span class="text-primary ms-2" role="button" onclick="enableEditUsername()">&#9998;</span>
                </div>
            </div>

            <!-- Date of Birth (editable) -->
            <div class="mb-3">
                <label class="form-label">Date of Birth:</label>
                <input type="date" name="dob" id="dobInput" class="form-control d-none">
                <p class="form-control bg-light" id="dobDisplay"></p>
            </div>

            <!-- Submit Button -->
            <button type="button" id="editBtn" class="btn btn-dark w-100" onclick="enableEditing()">Update Profile</button>
            <button type="submit" id="saveBtn" class="btn btn-success w-100 d-none">Save Changes</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userId = 2;  // Replace with dynamic user ID from the session or auth data
        fetchUserProfile(userId);
    });

    function fetchUserProfile(userId) {
        fetch(`http://127.0.0.1:8000/api/user/${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.message === "User record retrieved successfully") {
                    const user = data.user;
                    document.getElementById('previewPhoto').src = `{{ asset('') }}${user.imgPath}`;
                    document.getElementById('emailDisplay').innerText = user.email;
                    document.getElementById('usernameDisplay').innerText = user.username;
                    document.getElementById('usernameInput').value = user.username;
                    document.getElementById('dobDisplay').innerText = user.dob;
                    document.getElementById('dobInput').value = user.dob;
                } else {
                    console.error("Failed to load user data.");
                }
            })
            .catch(error => {
                console.error("Error fetching user data:", error);
            });
    }

    function previewImage(event) {
        var output = document.getElementById('previewPhoto');
        output.src = URL.createObjectURL(event.target.files[0]);
    }

    function enableEditing() {
        // Hide the "Update Profile" button and show "Save Changes" button
        document.getElementById('editBtn').classList.add('d-none');
        document.getElementById('saveBtn').classList.remove('d-none');

        // Enable the fields for editing
        document.getElementById('usernameDisplay').classList.add('d-none');
        document.getElementById('usernameInput').classList.remove('d-none');
        document.getElementById('dobDisplay').classList.add('d-none');
        document.getElementById('dobInput').classList.remove('d-none');
    }

    // Handle form submission (Save Changes)
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        // Send a PUT request to update the profile
        fetch(`http://127.0.0.1:8000/api/user/2`, {  // Use dynamic user ID here
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === "User record updated successfully") {
                alert('Profile updated successfully!');
                // After updating, we can reload or switch the button back
                document.getElementById('editBtn').classList.remove('d-none');
                document.getElementById('saveBtn').classList.add('d-none');
                document.getElementById('usernameDisplay').innerText = document.getElementById('usernameInput').value;
                document.getElementById('dobDisplay').innerText = document.getElementById('dobInput').value;
                // Optionally reload the page or update fields dynamically
            } else {
                alert('Failed to update profile!');
            }
        })
        .catch(error => {
            console.error('Error updating profile:', error);
        });
    });
</script>

@endsection
