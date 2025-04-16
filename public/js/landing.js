document.addEventListener("DOMContentLoaded", function () {
    fetchProducts();
});

function fetchProducts() {
    axios.get("http://127.0.0.1:8000/api/product")
        .then(response => {
            renderProducts(response.data);
        })
        .catch(error => {
            console.error("Error fetching products:", error);
        });
}

function renderProducts(products) {
    let carouselInner = document.getElementById("carousel-items");
    carouselInner.innerHTML = ""; // Clear previous content

    let itemsPerSlide = window.innerWidth >= 1024 ? 5 : 3;
    let totalSlides = Math.ceil(products.length / itemsPerSlide);
    
    for (let i = 0; i < totalSlides; i++) {
        let activeClass = i === 0 ? "active" : "";
        let startIdx = i * itemsPerSlide;
        let endIdx = startIdx + itemsPerSlide;
        let productsChunk = products.slice(startIdx, endIdx);

        let carouselItem = `
            <div class="carousel-item ${activeClass}">
                ${productsChunk.map(product => `
                    <div class="product-card">
                        <div class="card shadow">
                            <img src="/images/${product.product_detail.imgPath}" class="card-img-top" alt="${product.productName}">
                            <div class="card-body text-center">
                                <h4 class="card-title">${product.productName}</h4>
                                <p class="fw-bold">RM ${parseFloat(product.product_detail.equipPrice).toFixed(2)}</p>
                                <div class="badge-container">
                                    <p class="badge bg-warning text-dark">${product.productCategory}</p>
                                    <p class="badge bg-primary text-dark">${product.productBrand}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>`;
        
        carouselInner.innerHTML += carouselItem;
    }
}
