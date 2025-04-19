@extends('layouts.admin')

@section('title', 'Feedback Management - Sport Indirect')

@section('content')

@include('components.toast')
<div class="container mt-5">
    <h1 class="text-center">Feedback Management</h1>

    <!-- Unread Feedback Count -->
    <div class="alert alert-info" id="unreadFeedbackCount">Loading...</div>

    <!-- Feedback List Table -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="feedbackTableBody">
            <!-- Feedback data will be inserted here -->
        </tbody>
    </table>
</div>

<!-- View Feedback Modal -->
<div class="modal fade" id="viewFeedbackModal" tabindex="-1" aria-labelledby="viewFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="viewFeedbackLabel">Feedback Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modalName"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
                <p><strong>Message:</strong></p>
                <p id="modalMessage"></p>
                <p class="text-muted"><small>Created at: <span id="modalCreatedAt"></span></small></p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageFeedbacks.js') }}"></script>
@endsection


