@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-center mb-4">Manage Your Addresses</h2>

    <div class="row">
        <!-- Address List -->
        <div class="col-md-8" id="mainContainer">
            <div id="addressesContainer" class="list-group"></div> <!-- This is where the addresses or image will be injected -->
        </div>

        <!-- Add New Address -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Add New Address</div>
                <div class="card-body">
                <form id="addAddressForm">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phoneNo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line</label>
                        <input type="text" name="addressLine" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="isDefault" value="1" id="isDefault">
                        <label class="form-check-label" for="isDefault">Set as default</label>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Save Address</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const userId = @json(auth()->id());
    const noAddressImage = "{{ asset('images/Default/_address.png') }}";
</script>
<!-- Axios Script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/user/address.js') }}"></script>
@endsection
