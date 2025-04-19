let stores = [];

document.addEventListener("DOMContentLoaded", function (){
    loadStores();
})

function loadStores(){
    axios.get("/api/stores")
        .then(response=>{
            stores = response.data.stores ??[];
            displayTable();
        })
        .catch(()=>{
            document.querySelector("#storeTableBody").innerHTML =
            `<tr><td colspan="9" class="text-center text-danger"> Failed to load store record.</td></tr>`;
        });
}

function displayTable(){

    const tableBody = document.querySelector("#storeTableBody");
    tableBody.innerHTML = "";

    if (stores.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No Stores available.</td></tr>`;
        return;
    }

    stores.forEach(store=>{
        let row = `
            <tr>
                <td>${store.id}</td>
                <td>${store.storeName}</td>
                <td>${store.address}</td>
                <td>${store.operation}</td>
                <td>${store.contactNum}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button class="btn btn-warning btn-sm" onclick="UpdateStore(${store.id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteStore(${store.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

window.deleteStore = function(id){
    if(confirm("Are you sure want to delete this store record?")){
        axios.delete(`/api/stores/${id}`)
        .then(()=>{
            showToast("Store record deleted successfully.","success");
            loadStores();
        })
        .catch(()=>showToast("Error deleting store record.","error"));
    }
};

function UpdateStore(storeId){
    axios.get(`/api/stores/${storeId}`)
        .then(response=>{
            const store = response.data.store;

            if(!store){
                alert("Store record not found")
                return;
            }

            //Populate form fields with current store data
            document.getElementById("updateStoreId").value = store.id;
            document.getElementById("updateStoreName").value = store.storeName;
            document.getElementById("updateAddress").value = store.address;
            document.getElementById("updateOperation").value = store.operation;
            document.getElementById("updateContact").value = store.contactNum;

            // Store current image path in a hidden variable
            document.getElementById("updateStoreId").setAttribute("data-imgPath", store.imgPath);

            // Show Bootstrap modal
            let updateModal = new bootstrap.Modal(document.getElementById("updateStoreModal"));
            updateModal.show();
        })
        .catch(error => {
            console.error("Error fetching store record:",error.response?.data || error.message);
            alert("Failed to fetch store record");
        });
}

//Handle form submisson --Update
document.getElementById("updateStoreForm").addEventListener("submit",function (event){
    event.preventDefault();

    const storeId = document.getElementById("updateStoreId").value;

    const updatedStore = {
        storeName: document.getElementById("updateStoreName").value.trim(),
        address: document.getElementById("updateAddress").value.trim(),
        operation: document.getElementById("updateOperation").value.trim(),
        contactNum: document.getElementById("updateContact").value.trim(),
        imgPath: document.getElementById("updateStoreId").getAttribute("data-imgPath"), //Always use the existing image path
    };

    axios.put(`/api/stores/${storeId}`, updatedStore, {
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response =>{
        showToast("Store record updated successfully.","success");
        loadStores();
    })
    .catch(()=>showToast("Error updating store record.","error"));

});

//Handle form submission --Create
document.getElementById("createStoreForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    // Step 1: Check if image is selected
    const storeImg = document.getElementById("storeImg").files[0];
    let imgPath = "images/Default/_product.png"; // Default image path if no image is selected

    if (storeImg) {
        const imageFormData = new FormData();
        imageFormData.append("image", storeImg);

        try {
            const uploadRes = await axios.post("/api/upload-image", imageFormData, {
                headers: { "Content-Type": "multipart/form-data" }
            });
            imgPath = uploadRes.data.imgPath; // Update imgPath if image is uploaded successfully
        } catch (error) {
            console.error("Image upload failed:", error);
            alert("Failed to upload image.");
            return;
        }
    }

    // Step 2: Submit store record with imgPath (either default or uploaded)
    const storeData = {
        storeName: document.getElementById("storeName").value.trim(),
        address: document.getElementById("address").value.trim(),
        operation: document.getElementById("operation").value.trim(),
        contactNum: document.getElementById("contact").value.trim(),
        imgPath: imgPath // Send the imgPath (default or uploaded)
    };

    try {
        const response = await axios.post("/api/stores", storeData, {
            headers: { "Content-Type": "application/json" }
        });
        showToast("Store record inserted successfully.", "success");
        loadStores();
    } catch (error) {
        if (error.response && error.response.data) {
            console.error("Validation Errors:", error.response.data);
            alert("Validation Error: " + JSON.stringify(error.response.data.errors));
        } else {
            console.error("Error adding store record:", error);
            alert("Error adding store record.");
        }
    }
});



function searchStores() {
    let searchTerm = document.getElementById("search-input").value;

    if (!searchTerm) {
        loadStores(); 
        return;
    }

    axios.get('/api/store/search-stores', {
        params: {
            search: searchTerm
        }
    })
    .then(response => {
        stores = response.data ?? []
        displayTable();
    })
    .catch(error => {
        console.error("There was an error fetching the stores:", error);
        document.querySelector("#storeTableBody").innerHTML = 
            `<tr><td colspan="9" class="text-center text-danger">Failed to load search results.</td></tr>`;
    });
}
