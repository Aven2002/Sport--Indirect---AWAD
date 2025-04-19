document.addEventListener("DOMContentLoaded", function () {
    fetchStores();
});

function fetchStores() {
    axios.get('/api/stores')
        .then(response => {

            const stores = response.data.stores || [];  // Fallback to empty array if stores is undefined

            const storeList = document.getElementById("store-list");  // Ensure storeList is defined

            if (stores.length === 0) {
                let noMatchImage = `
                    <div class="col-12 text-center">
                        <img src="/images/Default/_store.png" alt="No store found" class="img-fluid">
                    </div>
                `;
                storeList.innerHTML = noMatchImage;
            } else {
                storeList.innerHTML = "";  // Clear the store list before adding new items

                stores.forEach(store => {
                    let googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(store.storeName)}`;

                    const storeCard = `
                        <div class="col-md-4 mb-3 d-flex">
                            <div class="card store-card shadow-sm flex-fill">
                                <img src="/${store.imgPath}" class="card-img-top" alt="${store.storeName}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">${store.storeName}</h5>
                                    <p class="card-text">${store.address}</p>
                                    <p class="text-muted"><strong>Hours:</strong> ${store.operation}</p>
                                    <p class="text-muted"><strong>Phone:</strong> ${store.contactNum}</p>
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
            }
        })
        .catch(error => {
            console.error("Error fetching stores:", error);
        });
}

