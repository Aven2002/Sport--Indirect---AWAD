@extends('layouts.admin')

@section('title','Store Management - Sport Indirect')

@section('content')

@include('components.toast')

<div class="container mt-2">
    <h1 class="text-center">Store Management</h1>
<!-- Add Store Button -->
 <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createStoreModal">
    Add new Store
 </button>
 <input type="text" id="search-input" class="form-control mb-4" placeholder="Search stores..." onkeyup="searchStores()">

 <!-- Store List Table -->
  <table class="table table-bordered mt-4">
    <thead class="table-dark text-center">
        <tr>
            <th>ID</th>
            <th>Store Name </th>
            <th>Address</th>
            <th>Operation</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="storeTableBody">
        <!-- Store data will be inserted here -->
    </tbody>
 </table>    

</div>

<!-- Update Store Modal -->
<div class="modal fade" id="updateStoreModal" tabindex="-1" aria-labelledby="updateStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg for better width -->
        <div class="modal-content"> <!-- Fixed typo from modal-contetn -->
            <div class="modal-header">
                <h5 class="modal-title">Update Store Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStoreForm">
                    <input type="hidden" id="updateStoreId">

                    <div class="mb-3">
                        <label class="form-label">Store Name</label> 
                        <input type="text" id="updateStoreName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label> 
                        <input type="text" id="updateAddress" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Operation</label>
                        <input type="text" id="updateOperation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact</label> 
                        <input type="text" id="updateContact" class="form-control" required>
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


<!-- Create Store Modal -->
 <div class="modal fade" id="createStoreModal" tabindex="-1" aria-labelledby="createStoreModalLabel" aria-hidden=true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStoreModalLabel"> Add New Store</h5>
                <button type="buton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createStoreForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Store Name</label>
                        <input type="text" class="form-control" id="storeName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Operation</label>
                        <input type="text" class="form-control" id="operation" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="storeImg" class="form-label">Upload Store Image</label>
                        <input type="file" class="form-control" id="storeImg" accept="image/*">
                         <small class="text-muted">Only JPG, PNG, and JPEG files are allowed.</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"> Add Store</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageStores.js') }}"></script>
@endsection