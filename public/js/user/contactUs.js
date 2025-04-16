document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.querySelector("#contact-form");

    contactForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(contactForm);
        let formObject = Object.fromEntries(formData.entries());

        axios.post("/api/feedback", formObject)
            .then(response => {
                showToast("Thank you for reaching out, We have received your feedback and will get back to you as soon as possible. We appreciate your patience.", "success");
                contactForm.reset();
            })
            .catch(error => {
                if (error.response && error.response.data.error) {
                    showToast("Error: " + JSON.stringify(error.response.data.error), "failure");
                } else {
                    showToast("Something went wrong. Please try again.", "failure");
                }
            });
    });
});
