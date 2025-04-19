@extends('layouts.admin')

@section('title', 'Account Management - Sport Indirect')

@section('content')

@include('components.toast')

<div class="container mt-2">
    <h1 class="text-center">Account Management</h1>
    <input type="text" id="search-input" class="form-control mb-4" placeholder="Search accounts..." onkeyup="searchAccounts()">
<!--Account List Table -->
<table class="table table-bordered mt-4">
    <thead class="table-dark text-center">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Username</th>
            <th>DOB</th>
            <th>Created At</th>
            <th>Actions</th>
        <tr>
    </thead>
    <tbody id="accountTableBody">
        <!-- Account data will be inserted here -->
    </tbody>
</table>
</div>

<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageAccounts.js') }}"></script>
@endsection