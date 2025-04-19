@extends('layouts.user')

@section('title', 'User Profile')

@section('content')

@include('components.toast')
<div class="container my-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
        <h2 class="text-center mb-4">User Profile</h2>
        <form id="profileForm" action="/profile/update" method="Put" >
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Section: Profile Image -->
                <div class="col-md-4 text-center mb-3">
                    <img src="{{ asset('images/Default/_profile.png') }}" alt="Profile Photo" id="previewPhoto" class="rounded-circle border border-secondary" width="150" height="150">
                    <div class="mt-2">
                        <!-- Button to trigger image selection -->
                        <button type="button" class="btn btn-dark btn-sm" onclick="toggleImageSelection()">Select Profile Image</button>
                    </div>
                </div>
                </form>
                <!-- Right Section: Email, Username, and DOB -->
                <div class="col-md-8">
                    <!-- Image Selection Container (hidden by default) -->
                    <div id="img-selection-container" class="mt-3 mb-3 d-none">
                        <div class="row">
                            @foreach (glob(public_path('images/Profile_Img/*.png')) as $image)
                                <div class="col-3 text-center">
                                    <img src="{{ asset('images/Profile_Img/' . basename($image)) }}" alt="Profile Image" class="img-thumbnail img-selection" style="cursor: pointer;" onclick="selectProfileImage('{{ basename($image) }}')">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="mb-3">
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
                        <p><strong>Date of Birth:</strong> {{ Auth::user()->dob }}</p>
                    </div>


                    <div class="text-center mb-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger">
                    Update Profile
                </a>
            </div>
                </div>
            </div>

       
    </div>
</div>


<script>
    const userId = @json(auth()->id());
    const BASE_URL = '{{ url('/') }}';
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/user/profile.js') }}"></script>
@endsection