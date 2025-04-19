let accounts = [];

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

function displayTable() {
    const tableBody = document.querySelector("#accountTableBody");
    tableBody.innerHTML = "";

    if (accounts.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No account available.</td></tr>`;
        return;
    }

    accounts.forEach(account => {
        let row = `
            <tr>
                <td>${account.id}</td>
                <td>${account.email}</td>
                <td>${account.username}</td>
                <td>${account.dob}</td>
                <td>${account.created_at}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        ${account.status === 'frozen' ? 
                            `<button class="btn btn-success btn-sm" id="active-btn-${account.id}" onclick="activeAccount(${account.id})">Activate</button>` : 
                            `<button class="btn btn-info btn-sm" id="freeze-btn-${account.id}" onclick="freezeAccount(${account.id})">Freeze</button>`}
                        <button class="btn btn-danger btn-sm" onclick="deleteAccount(${account.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
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


function searchAccounts() {
    let searchTerm = document.getElementById("search-input").value;

    if (!searchTerm) {
        loadAccounts(); 
        return;
    }

    axios.get('/api/user/search-accounts', {
        params: {
            search: searchTerm
        }
    })
    .then(response => {
        accounts = response.data ?? []
        displayTable();
    })
    .catch(error => {
        console.error("There was an error fetching the accounts:", error);
        document.querySelector("#accountTableBody").innerHTML = 
            `<tr><td colspan="9" class="text-center text-danger">Failed to load search results.</td></tr>`;
    });
}

function freezeAccount(userId) {
    axios.put(`/api/user/${userId}/status`, {
        status: 'frozen'
    })
    .then(response => {
        showToast("User status updated successfully.","success");
        loadAccounts();
    })
    .catch(error => {
        console.error(error);
        alert('Failed to freeze account.');
    });
}

function activeAccount(userId) {
    axios.put(`/api/user/${userId}/status`, {
        status: 'active'
    })
    .then(response => {
        showToast("User status updated successfully.","success");
        loadAccounts();
    })
    .catch(error => {
        console.error(error);
        alert('Failed to activate account.');
    });
}

function updateButtonStates(userId, newStatus) {
    console.log(`Updating button states for user ${userId}, new status: ${newStatus}`);

    const freezeBtn = document.getElementById(`freeze-btn-${userId}`);
    const activeBtn = document.getElementById(`active-btn-${userId}`);

    if (freezeBtn && activeBtn) {
        if (newStatus === 'frozen') {
            console.log("Freezing account - disabling freeze button and enabling active button.");
            freezeBtn.disabled = true;
            activeBtn.disabled = false;
        } else {
            console.log("Activating account - disabling active button and enabling freeze button.");
            freezeBtn.disabled = false;
            activeBtn.disabled = true;
        }
    }
}

