@extends('layouts.admin')

@section('title', 'Account Management - Sport Indirect')

@section('content')

@include('components.toast')

<div class="container mt-2">
    <h1 class="text-center">Account Management</h1>

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

<!-- Bootstrap Pagination -->
 <nav>
    <ul class="pagination justify-content-center" id="pagination">
        <!-- Pagination buttons will be generated dynamically -->
    </ul>
</nav>

</div>

<!-- Update Account Modal -->
 <div class="modal fade" id="updateAccountModal" tabindex="-1" aria-labelledby="updateStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title"> Update Account Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateAccountForm">
                    <input type="hidden" id="updateAccountId">

                    <div class="mb-3">
                        <label class="form-label">Email</label> 
                        <input type="email" id="updateEmail" class="form-control" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label> 
                        <input type="text" id="updateUsername" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label> 
                        <input type="text" id="updateDob" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageAccounts.js') }}"></script>
@endsection