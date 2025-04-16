document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.querySelector("#contact-form");
    const alertContainer = document.createElement("div");
    alertContainer.classList.add("alert", "d-none", "mt-3");
    contactForm.parentNode.insertBefore(alertContainer, contactForm);

    contactForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(contactForm);
        let formObject = Object.fromEntries(formData.entries());

        axios.post("/api/feedback", formObject)
            .then(response => {
                showAlert("success", "Thank you for reaching out, We have received your feedback and will get back to you as soon as possible. We appreciate your patience.");
                contactForm.reset();
            })
            .catch(error => {
                if (error.response && error.response.data.error) {
                    showAlert("danger", "Error: " + JSON.stringify(error.response.data.error));
                } else {
                    showAlert("danger", "Something went wrong. Please try again.");
                }
            });
    });

    function showAlert(type, message) {
        alertContainer.classList.remove("d-none", "alert-success", "alert-danger");
        alertContainer.classList.add(`alert-${type}`);
        alertContainer.innerHTML = message;

        setTimeout(() => {
            alertContainer.classList.add("d-none");
        }, 60000); 
    }
});
