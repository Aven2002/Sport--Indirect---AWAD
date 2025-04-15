let accounts = [];
let currentPage = 1;
const rowsPerPage =5;

document.addEventListener("DOMContentLoaded", function (){
    loadAccounts();
})

function loadAccounts(){
    axios.get("/api/user")
        .then(response=>{
            accounts = response.data.users ??[];
            displayTable();
        })
        .catch(()=>{
            document.querySelector("#accountTableBody").innerHTML =
            `<tr><td colspan="9" class="text-center text-danger"> Failed to load account record.</td></tr>`;
        });
}

function displayTable(){
    const start = (currentPage -1)*rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedAccounts = accounts.slice(start,end);

    const tableBody = document.querySelector("#accountTableBody");
    tableBody.innerHTML = "";

    if (paginatedAccounts.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No Account available.</td></tr>`;
        return;
    }

    paginatedAccounts.forEach(account=>{
        let row = `
            <tr>
                <td>${account.id}</td>
                <td>${account.email}</td>
                <td>${account.username}</td>
                <td>${account.dob}</td>
                <td>${account.created_at}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button class="btn btn-warning btn-sm" onclick="UpdateAccount(${account.id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAccount(${account.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
    updatePagination();
}

function updatePagination() {
    if (!accounts.length) return;  // Do nothing if there are no accounts

    const totalPages = Math.ceil(accounts.length / rowsPerPage);
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

window.deleteAccount = function(id){
    if(confirm("Are you sure want to delete this account record?")){
        axios.delete(`/api/user/${id}`)
        .then(()=>{
            showToast("User record deleted successfully.","success");
            loadAccounts();
        })
        .catch(()=>showToast("Error deleting user record.","error"));
    }
};

function UpdateAccount(id){
    axios.get(`/api/profile/${id}`)
        .then(response=>{
            const user = response.data.profile;

            if(!user){
                alert("User record not found")
                return;
            }

            //Populate form fields with current user data
            document.getElementById("updateAccountId").value = user.id;
            document.getElementById("updateEmail").value = user.email;
            document.getElementById("updateUsername").value = user.username;
            document.getElementById("updateDob").value = user.dob;

            // User current image path in a hidden variable
            document.getElementById("updateAccountId").setAttribute("data-imgPath", user.imgPath);

            // Show Bootstrap modal
            let updateModal = new bootstrap.Modal(document.getElementById("updateAccountModal"));
            updateModal.show();
        })
        .catch(error => {
            console.error("Error fetching user record:",error.response?.data || error.message);
            alert("Failed to fetch user record");
        });
}

//Handle form submisson --Update
document.getElementById("updateAccountForm").addEventListener("submit",function (event){
    event.preventDefault();

    const id = document.getElementById("updateAccountId").value;

    const updatedUser = {
        email: document.getElementById("updateEmail").value.trim(),
        username: document.getElementById("updateUsername").value.trim(),
        dob: document.getElementById("updateDob").value.trim(),
        imgPath: document.getElementById("updateAccountId").getAttribute("data-imgPath"), //Always use the existing image path
    };

    axios.put(`/api/profile/${id}`, updatedUser, {
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response =>{
        showToast("User record updated successfully.","success");
        loadAccounts();
    })
    .catch(()=>showToast("Error updating user record.","error"));

});