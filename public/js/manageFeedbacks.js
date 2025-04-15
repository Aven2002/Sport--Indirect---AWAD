document.addEventListener("DOMContentLoaded", function () {
    loadFeedbacks();
    loadUnreadCount();

    // Load Unread Feedback Count
    function loadUnreadCount() {
        axios.get("/api/feedback/unread")
            .then(response => {
                document.querySelector("#unreadFeedbackCount").innerHTML = 
                    `Unread Feedbacks: <strong>${response.data.unread_count}</strong>`;
            })
            .catch(() => {
                document.querySelector("#unreadFeedbackCount").innerHTML = 
                    `<div class="alert alert-danger">Failed to load unread count.</div>`;
            });
    }

    function loadFeedbacks() {
        axios.get("/api/feedback")
            .then(response => {
                const feedbacks = response.data.feedback ??[];
                const tableBody = document.querySelector("#feedbackTableBody");
                tableBody.innerHTML = "";
    
                if (feedbacks.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No feedback available.</td></tr>`;
                    return;
                }
    
                // Fetch unread feedback IDs separately
                axios.get("/api/feedback/unread").then(unreadRes => {
                    const unreadIds = unreadRes.data.unread_ids;
    
                    feedbacks.forEach(feedback => {
                        const isUnread = unreadIds.includes(feedback.id);
    
                        let row = `
                            <tr>
                                <td>${feedback.id}</td>
                                <td>${feedback.name}</td>
                                <td>${feedback.email}</td>
                                <td>${feedback.subject}</td>
                                <td>${new Date(feedback.created_at).toLocaleString()}</td>
                               <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                     ${isUnread ? '<span class="badge bg-info text-dark unread-badge">Unread</span>' : ''}
                                        <button class="btn btn-primary btn-sm" onclick="viewFeedback(${feedback.id})">View Details</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteFeedback(${feedback.id})">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        `;
    
                        tableBody.innerHTML += row;
                    });
    
                    // Update unread count display
                    document.getElementById("unreadFeedbackCount").innerHTML = `Unread Feedbacks: <strong>${unreadRes.data.unread_count}</strong>`;
                });
            })
            .catch(() => {
                document.querySelector("#feedbackTableBody").innerHTML = 
                    `<tr><td colspan="6" class="text-center text-danger">Failed to load feedbacks.</td></tr>`;
                document.getElementById("unreadFeedbackCount").innerHTML = `Error loading unread feedback count`;
            });
    }
    

    // View Feedback & Mark as Read
    window.viewFeedback = function (id) {
        axios.get(`/api/feedback/${id}`)
            .then(response => {
                const feedback = response.data.feedback;
                document.getElementById("modalName").textContent = feedback.name;
                document.getElementById("modalEmail").textContent = feedback.email;
                document.getElementById("modalSubject").textContent = feedback.subject;
                document.getElementById("modalMessage").textContent = feedback.message;
                document.getElementById("modalCreatedAt").textContent = new Date(feedback.created_at).toLocaleString();

                new bootstrap.Modal(document.getElementById("viewFeedbackModal")).show();

                // Mark as Read if Unread
                if (!feedback.status) {
                    axios.put(`/api/feedback/${id}`, { status: 1 })
                        .then(() => {
                            loadFeedbacks();
                            loadUnreadCount();
                            let row = document.querySelector(`#feedback-${id}`);
                            if (row) {
                                let badge = row.querySelector(".unread-badge");
                                if (badge) badge.remove(); // Remove the "Unread" badge
                            }
                        })
                        .catch(error => console.error("Error marking as read", error));
                }
            })
            .catch(error => console.error("Error fetching feedback", error));
    };

    // Delete Feedback
    window.deleteFeedback = function (id) {
        if (confirm("Are you sure you want to delete this feedback?")) {
            axios.delete(`/api/feedback/${id}`)
                .then(() => {
                    alert("Feedback deleted successfully.");
                    loadFeedbacks();
                    loadUnreadCount();
                })
                .catch(() => alert("Error deleting feedback."));
        }
    };
});
