let stores = [];
let currentPage = 1;
const rowsPerPage =5;

document.addEventListener("DOMContentLoaded", function (){
    loadStores();
})

function loadStores(){
    axios.get("/api/store")
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
    const start = (currentPage -1)*rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedStores = stores.slice(start,end);

    const tableBody = document.querySelector("#storeTableBody");
    tableBody.innerHTML = "";

    if (paginatedStores.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No Stores available.</td></tr>`;
        return;
    }

    paginatedStores.forEach(store=>{
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
    updatePagination();
}

function updatePagination() {
    if (!stores.length) return;  // Do nothing if there are no stores

    const totalPages = Math.ceil(stores.length / rowsPerPage);
    const pagination = document.querySelector("#pagination");
    pagination.innerHTML = "";

    if (totalPages <= 1) return; // Hide pagination if only one page

    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`;
    }
}


function changePage(page) {
    currentPage = page;
    displayTable();
}

window.deleteStore = function(id){
    if(confirm("Are you sure want to delete this store record?")){
        axios.delete(`/api/store/${id}`)
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
            document.getElementById("updateContact").value = store.phoneNo;

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
        phoneNo: document.getElementById("updateContact").value.trim(),
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
document.getElementById("createStoreForm").addEventListener("submit", async function (event){
    event.preventDefault();

    const formData = new FormData();
    formData.append("storeName", document.getElementById("storeName").value.trim());
    formData.append("address", document.getElementById("address").value.trim());
    formData.append("operation", document.getElementById("operation").value.trim());
    formData.append("phoneNo", document.getElementById("contact").value.trim());
    
    const storeImg = document.getElementById("storeImg").files[0];
    if(!storeImg){
        alert("Please select a product image.");
        return;
    }
    formData.append("imgPath", storeImg);

    try{
        const response = await axios.post("/api/stores", formData,{
            headers: { "Content-Type": "multipart/form-data" }
        });
        showToast("Store record inserted successfully.","success");
        loadStores();
    }catch (error) {
        if (error.response && error.response.data) {
            console.error("Validation Errors:", error.response.data);
            alert("Validation Error: " + JSON.stringify(error.response.data.errors));
        } else {
            console.error("Error adding store record:", error);
            alert("Error adding store record.");
        }
    }
})