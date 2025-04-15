function showToast(message, type = "success") {
    const toastEl = document.getElementById("toastNotification");
    const toastBody = document.getElementById("toastMessage");

    // Set message and background color
    toastBody.textContent = message;
    
    if (type === "success") {
        toastEl.classList.remove("bg-danger");
        toastEl.classList.add("bg-success");
    } else {
        toastEl.classList.remove("bg-success");
        toastEl.classList.add("bg-danger");
    }

    // Show toast using Bootstrap’s Toast API
    const toast = new bootstrap.Toast(toastEl, { delay: 10000 });
    toast.show();
}
