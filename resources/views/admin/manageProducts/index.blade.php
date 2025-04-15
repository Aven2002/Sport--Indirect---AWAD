@extends('layouts.admin')

@section('title', 'Product Management - Sport Indirect')

@section('content')

@include('components.toast')

<div class="container mt-2">
    <h1 class="text-center">Product Management</h1>
<!-- Add Product Button -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
    Add New Product
</button>

    <!-- Product List Table -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Sport</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <!-- Product data will be inserted here -->
        </tbody>
    </table>

    <!-- Bootstrap Pagination -->
    <nav>
        <ul class="pagination justify-content-center" id="pagination">
            <!-- Pagination buttons will be generated dynamically -->
        </ul>
    </nav>

</div>

<!-- Product View Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 id="productName"class="text-muted text-start text-justify"></h4>
                <img id="productImage" class="img-fluid rounded mb-3 product-img" alt="Product Image">
                <p id="productDescription" class="text-muted text-start text-justify"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 id="deleteProductName" class="text-muted text-start text-justify"></h4>
                <img id="deleteProductImage" class="img-fluid rounded mb-3 product-img" alt="Product Image">
                <p>Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- Update Product Modal -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Product Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm">
                    <input type="hidden" id="updateProductId">
                    
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" id="updateProductName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sport Category</label>
                        <input type="text" id="updateSportCategory" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Category</label>
                        <input type="text" id="updateProductCategory" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Brand</label>
                        <input type="text" id="updateProductBrand" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" id="updateStock" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" id="updatePrice" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="updateDescription" class="form-control" rows="3"></textarea>
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

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="createProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="createProductName" required>
                    </div>
                    <div class="mb-3">
                        <label for="createSportCategory" class="form-label">Sport Category</label>
                        <input type="text" class="form-control" id="createSportCategory" required>
                    </div>
                    <div class="mb-3">
                        <label for="createProductCategory" class="form-label">Product Category</label>
                        <input type="text" class="form-control" id="createProductCategory" required>
                    </div>
                    <div class="mb-3">
                        <label for="createProductBrand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="createProductBrand" required>
                    </div>
                    <div class="mb-3">
                        <label for="createStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="createStock" required>
                    </div>
                    <div class="mb-3">
                        <label for="createPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="createPrice" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="createDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="createDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createProductImage" class="form-label">Upload Product Image</label>
                        <input type="file" class="form-control" id="createProductImage" accept="image/*">
                        <small class="text-muted">Only JPG, PNG, and JPEG files are allowed.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .product-img {
        max-width: 100%;  
        max-height: 300px; 
        object-fit: cover; 
    }
    
    .text-justify {
        text-align: justify;
    }
</style>

<!-- Bootstrap & Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/manageProducts.js') }}"></script>
@endsection


