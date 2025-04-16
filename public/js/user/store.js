document.addEventListener("DOMContentLoaded", function () {
    fetchStores();
});

function fetchStores() {
    axios.get('/api/store')
        .then(response => {
            const stores = response.data.stores;
            const storeList = document.getElementById("store-list");
            storeList.innerHTML = "";

            stores.forEach(store => {
                let googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(store.storeName)}`;

                const storeCard = `
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card store-card shadow-sm flex-fill">
                            <img src="/images/${store.imgPath}" class="card-img-top" alt="${store.storeName}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${store.storeName}</h5>
                                <p class="card-text">${store.address}</p>
                                <p class="text-muted"><strong>Hours:</strong> ${store.operationHour}</p>
                                <p class="text-muted"><strong>Phone:</strong> ${store.phoneNo}</p>
                                <div class="mt-auto">
                                    <a href="${googleMapsUrl}" class="btn btn-primary w-100" target="_blank">
                                        Open in Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                storeList.innerHTML += storeCard;
            });
        })
        .catch(error => {
            console.error("Error fetching stores:", error);
        });
}
