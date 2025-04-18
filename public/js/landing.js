document.addEventListener("DOMContentLoaded", function () {
    loadTrendingProducts();
    loadNewArrivalsProducts()
});

async function loadTrendingProducts() {
    const carouselInner = document.getElementById("carousel-items-trending");

    try {
        const response = await axios.get("/api/product/trending");
        const products = response.data.products;

        if (!products || products.length === 0) {
            carouselInner.innerHTML = `<div class="text-center p-4">No trending products found.</div>`;
            return;
        }

        const itemsPerSlide = window.innerWidth >= 1024 ? 3 : 2; // Adjust based on screen size
        const totalSlides = Math.ceil(products.length / itemsPerSlide);

        for (let i = 0; i < totalSlides; i++) {
            const slideProducts = products.slice(i * itemsPerSlide, (i + 1) * itemsPerSlide);
            const activeClass = i === 0 ? 'active' : '';

            const slide = document.createElement('div');
            slide.className = `carousel-item ${activeClass}`;

            const row = document.createElement('div');
            row.className = 'row justify-content-center';

            slideProducts.forEach(product => {
                const col = document.createElement('div');
                col.className = 'col-md-3'; // 4 per row

                col.innerHTML = `
                 <a href="user/product/detail/${product.id}" class="text-decoration-none text-dark">
                <div class="trending-card mb-3 shadow-sm h-100 d-flex flex-column" style="min-height: 400px;">
                    <img src="/images/${product.product_detail.imgPath}" class="card-img-top" alt="${product.productName}" style="height: 250px; object-fit: contain;">
                    <div class="card-body text-center mt-auto">
                        <h5 class="card-title">${product.productName}</h5>
                        <p class="text-muted mb-1">${product.productBrand}</p>
                        <p class="fw-bold">RM ${parseFloat(product.product_detail.price).toFixed(2)}</p>
                    </div>
                </div>
            </a>
                `;
                row.appendChild(col);
            });

            slide.appendChild(row);
            carouselInner.appendChild(slide);
        }
    } catch (error) {
        console.error("Error loading trending products:", error);
        carouselInner.innerHTML = `<div class="alert alert-danger text-center">Failed to load trending products.</div>`;
    }
}

async function loadNewArrivalsProducts() {
    const carouselInner = document.getElementById("carousel-items-new-arrivals");

    try {
        const response = await axios.get("/api/product/newArrivals");
        const products = response.data.products;

        if (!products || products.length === 0) {
            carouselInner.innerHTML = `<div class="text-center p-4">No new arrivals.</div>`;
            return;
        }

        const itemsPerSlide = window.innerWidth >= 1024 ? 3 : 2; // Adjust based on screen size
        const totalSlides = Math.ceil(products.length / itemsPerSlide);

        for (let i = 0; i < totalSlides; i++) {
            const slideProducts = products.slice(i * itemsPerSlide, (i + 1) * itemsPerSlide);
            const activeClass = i === 0 ? 'active' : '';

            const slide = document.createElement('div');
            slide.className = `carousel-item ${activeClass}`;

            const row = document.createElement('div');
            row.className = 'row justify-content-center';

            slideProducts.forEach(product => {
                const col = document.createElement('div');
                col.className = 'col-md-3'; // 4 per row

                col.innerHTML = `
                 <a href="user/product/detail/${product.id}" class="text-decoration-none text-dark">
                <div class="trending-card mb-3 shadow-sm h-100 d-flex flex-column" style="min-height: 400px;">
                    <img src="/images/${product.product_detail.imgPath}" class="card-img-top" alt="${product.productName}" style="height: 250px; object-fit: contain;">
                    <div class="card-body text-center mt-auto">
                        <h5 class="card-title">${product.productName}</h5>
                        <p class="text-muted mb-1">${product.productBrand}</p>
                        <p class="fw-bold">RM ${parseFloat(product.product_detail.price).toFixed(2)}</p>
                    </div>
                </div>
            </a>
                `;
                row.appendChild(col);
            });

            slide.appendChild(row);
            carouselInner.appendChild(slide);
        }
    } catch (error) {
        console.error("Error loading trending products:", error);
        carouselInner.innerHTML = `<div class="alert alert-danger text-center">Failed to load trending products.</div>`;
    }
}
