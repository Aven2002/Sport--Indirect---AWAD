const addressList = document.getElementById('addressesContainer');
const form = document.getElementById('addAddressForm');

async function fetchAddresses() {
    try {
        if (!userId) {
            console.error('User ID not found in session!');
            return;
        }

        const response = await axios.get(`/api/address/${userId}/user`);

        if (response.data.message === "No address found for this user") {
            addressList.innerHTML = `
                <div class="text-center">
                     <img src="${noAddressImage}" alt="No Address" class="img-fluid" style="max-width: 150px;">
                    <p class="mt-3 text-muted">No saved addresses found. You can add a new address.</p>
                </div>
            `;
        } else if (response.data.message === "User addresses retrieved successfully") {
            renderAddresses(response.data.addresses);
        }
    } catch (error) {
        console.error("Error fetching addresses:", error);
    }
}

function renderAddresses(addresses) {
    console.log("Rendering addresses:", addresses);

    addressList.innerHTML = ''; // Clear previous

    if (addresses && addresses.length > 0) {
        addresses.forEach(address => {
            const addressDiv = document.createElement('div');
            addressDiv.classList.add('address-card', 'mb-4', 'p-4', 'border', 'rounded');

            addressDiv.innerHTML = `
                <h5>${address.name} <span class="badge ${address.isDefault ? 'bg-success' : 'bg-secondary'}">${address.isDefault ? 'Default' : 'Not Default'}</span></h5>
                <p>${address.addressLine}, ${address.city}, ${address.state}, ${address.postcode}</p>
                <p>Phone: ${address.phoneNo}</p>
                <button class="btn btn-outline-primary btn-sm" onclick="setDefaultAddress(${address.id})">Set as Default</button>
                <button class="btn btn-danger btn-sm ms-2" onclick="deleteAddress(${address.id})">Delete</button>
            `;

            addressList.appendChild(addressDiv);
        });
    } else {
        addressList.innerHTML = `
            <div class="text-center">
                <img src="/images/Default/_address.png" alt="No Address" class="img-fluid" style="max-width: 150px;">
                <p class="mt-3 text-muted">No saved addresses found. You can add a new address.</p>
            </div>
        `;
    }
}

function deleteAddress(addressId) {
    axios.delete(`/api/address/${addressId}`)
        .then(response => {
            if (response.status === 200) {
                showToast("Address deleted successfully.", "failure");
                fetchAddresses();
            } else {
                showToast("Failed to delete the address. Please try again", "failure");
            }
        })
        .catch(error => {
            console.error("Error deleting address:", error);
            showToast("There was an error. Please try again.", "failure");
        });
}

form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('user_id', userId);
    const data = Object.fromEntries(formData.entries());

    data.isDefault = formData.has('isDefault') ? true : false;

    try {
        const response = await axios.post('/api/address', data);

        if (response.status === 201) {
            showToast("Address added successfully.", "success");
            form.reset();
            fetchAddresses();
        } else {
            showToast("Failed to add address", "failure");
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            let messages = '';
            for (let field in errors) {
                messages += `${errors[field].join(', ')}\n`;
            }
            alert("Validation Error:\n" + messages);
        } else {
            console.error("Error adding address:", error);
            showToast("Something went wrong. Please check your input", "failure");
        }
    }
});

function setDefaultAddress(addressId) {
    axios.post(`/api/address/${addressId}/set-default`)
        .then(response => {
            if (response.status === 200) {
                fetchAddresses(); // Refresh the address list
            } else {
                showToast("Failed to set default address", "failure");
            }
        })
        .catch(error => {
            console.error("Error setting default address:", error);
            showToast("Something went wrong. Please try again.", "failure");
        });
}

document.addEventListener("DOMContentLoaded", function() {
    fetchAddresses();
});