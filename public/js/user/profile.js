document.addEventListener("DOMContentLoaded", function () {
    fetchUserProfile(userId);
});

function fetchUserProfile(userId) {
    axios.get(`/api/user/${userId}`)
        .then(response => {
            if (response.data.message === "User record retrieved successfully") {
                const user = response.data.user;
                document.getElementById('previewPhoto').src = `${BASE_URL}/${user.imgPath}`;
            }
        })
        .catch(error => console.error("Error fetching user data:", error));
}

function toggleImageSelection() {
    const container = document.getElementById('img-selection-container');
    container.classList.toggle('d-none');
}

function selectProfileImage(imageName) {
    const payload = {
        selected_image: imageName,  
        user_id: userId  
    };

    console.log('Sending payload:', payload);  
    axios({
        method: 'put',
        url: `/api/user/update/profile/img`,
        data: payload,  
        headers: {
            'Content-Type': 'application/json',  
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  
        },
    })
    .then(response => {
        document.getElementById('previewPhoto').src = `${BASE_URL}/images/Profile_Img/${imageName}`;
        showToast("Profile image updated successfully.", "success");
    })
    .catch(error => {
        console.error('Error updating profile image:', error.response.data);
        showToast("Failed to update profile image.", "failure");
    });
}









