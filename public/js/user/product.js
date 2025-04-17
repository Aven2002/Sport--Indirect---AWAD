document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    selectedCategory = urlParams.get("category") || null;
    selectedBrand = urlParams.get("brand") || null;
    selectedSportCategory = urlParams.get("sport") || null;
    selectedMaxPrice = parseInt(urlParams.get("price")) || 3000;

    document.getElementById("price-range").value = selectedMaxPrice;
    document.getElementById("price-value-label").textContent = `RM ${selectedMaxPrice}`;

    fetchProducts();
    loadFilters();
   

    document.getElementById("clear-filters").addEventListener("click", clearFilters);

    const priceSlider = document.getElementById("price-range");
    const priceLabel = document.getElementById("price-value-label");
    priceSlider.addEventListener("input", function () {
        selectedMaxPrice = parseInt(this.value);
        priceLabel.textContent = `RM ${selectedMaxPrice}`;
        applyFilters();
        updateURL(); 
    });

    const sortDropdown = document.getElementById("sort");
    sortDropdown.addEventListener("change", function () {
        const selectedOption = this.value;
        sortProducts(selectedOption);
    });
});



let productsData = [];
let filteredProducts = [];
let currentSortOption = "newest"; 

function fetchProducts() {
    axios.get("/api/product")
        .then(response => {
            productsData = response.data.products ?? [];
            filteredProducts = [...productsData];
            applyFilters();
        })
        .catch(error => {
            console.error("Error fetching products:", error);
        });
}

function searchProducts() {
    let searchTerm = document.getElementById("search-input").value;

    axios.get('/api/product/search-products', {
        params: {
            search: searchTerm
        }
    })
    .then(response => {
        renderProducts(response.data);
    })
    .catch(error => {
        console.error("There was an error fetching the products:", error);
    });
}

function renderProducts(products) {
    let productContainer = document.getElementById("product-grid");
    productContainer.innerHTML = ""; // Clear previous content

    if (products.length === 0) {
        let noMatchImage = `
            <div class="col-12 text-center">
                <img src="/images/Default/_ntg-match.png" alt="No matches found" class="img-fluid">
            </div>
        `;
        productContainer.innerHTML = noMatchImage;
    } else {
        // Display filtered products
        products.forEach(product => {
            let price = product.product_detail && product.product_detail.price 
                        ? parseFloat(product.product_detail.price).toFixed(2) 
                        : "N/A";  // Fallback to "N/A" if price is missing

            let imgPath = product.product_detail && product.product_detail.imgPath 
                          ? product.product_detail.imgPath 
                          : '/Default/_product.png';  // Fallback to default image

            let productCard = `
                <div class="col-md-4 col-sm-6 mb-4 product-card" data-category="${product.productCategory}">
                    <div class="card shadow">
                        <img src="/images/${imgPath}" class="card-img-top" alt="${imgPath}">
                        <div class="card-body text-center">
                            <h4 class="card-title">${product.productName}</h4>
                            <p class="fw-bold">RM ${price}</p>
                            <div class="badge-container">
                                <p class="badge bg-warning text-dark">${product.productCategory}</p>
                                <p class="badge bg-primary text-dark">${product.productBrand}</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            productContainer.innerHTML += productCard;
        });
    }
}

function loadFilters() {
    // For Product Category
    axios.get('/api/product/category')
        .then(res => {
            if (res.data.productCategory && Array.isArray(res.data.productCategory)) {
                populateFilterList('category-list', res.data.productCategory, 'productCategory');
            } else {
                console.log('No product categories available');
            }
        })
        .catch(error => console.error('Error fetching product categories:', error));

    // For Product Brands
    axios.get('/api/product/brand')
        .then(res => {
            if (res.data.productBrands && Array.isArray(res.data.productBrands)) {
                populateFilterList('brand-list', res.data.productBrands, 'productBrand');
            } else {
                console.log('No product brands available');
            }
        })
        .catch(error => console.error('Error fetching product brands:', error));

    // For Sport Categories
    axios.get('/api/product/sport/category')
        .then(res => {
            if (res.data.sportCategory && Array.isArray(res.data.sportCategory)) {
                populateFilterList('sport-category-list', res.data.sportCategory, 'sportCategory');
            } else {
                console.log('No sport categories available');
            }
        })
        .catch(error => console.error('Error fetching sport categories:', error));
}


function populateFilterList(elementId, dataList, fieldName) {
    const list = document.getElementById(elementId);
    list.innerHTML = ''; 

    const kebabField = fieldName.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();

    // Add "All" option
    const allLi = document.createElement("li");
    allLi.className = "list-group-item";
    allLi.innerHTML = `<a href="#" class="text-decoration-none text-dark fw-bold" data-${fieldName}="">All</a>`;
    list.appendChild(allLi);

    dataList.forEach(item => {
        const li = document.createElement("li");
        li.className = "list-group-item";
        li.innerHTML = `<a href="#" class="text-decoration-none text-dark" data-${kebabField}="${item[fieldName]}">${item[fieldName]}</a>`;
        list.appendChild(li);
    });

    list.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const value = this.getAttribute(`data-${kebabField}`);
            applyFilters(fieldName, value);

            // 👇 Highlight selected
            list.querySelectorAll('a').forEach(a => {
                a.classList.remove("text-primary", "fw-bold", "text-decoration-underline");
            });
            this.classList.add("text-primary", "fw-bold", "text-decoration-underline");
        });
    });
}


function applyFilters(fieldName, value) {
    if (fieldName === "productCategory") selectedCategory = value;
    if (fieldName === "productBrand") selectedBrand = value;
    if (fieldName === "sportCategory") selectedSportCategory = value;

    updateURL(); 

    filteredProducts = productsData.filter(product => {
        const matchesCategory = !selectedCategory || product.productCategory === selectedCategory;
        const matchesBrand = !selectedBrand || product.productBrand === selectedBrand;
        const matchesSport = !selectedSportCategory || product.sportCategory === selectedSportCategory;

        const price = product.product_detail?.price ? parseFloat(product.product_detail.price) : 0;
        const matchesPrice = price <= selectedMaxPrice;

        return matchesCategory && matchesBrand && matchesSport && matchesPrice;
    });

    sortProducts(currentSortOption);
}


function clearFilters() {
    // Reset filter values
    selectedCategory = null;
    selectedBrand = null;
    selectedSportCategory = null;
    selectedMaxPrice = 3000;

    // Reset the price slider to max value
    document.getElementById("price-range").value = 3000;
    document.getElementById("price-value-label").innerText = "RM 3000";

    // Reset the selected filter styles in the sidebar
    resetFilterUI('category-list');
    resetFilterUI('brand-list');
    resetFilterUI('sport-category-list');

    // Reset the search bar
    document.getElementById("search-input").value = "";

    // Reset the sort dropdown
    document.getElementById("sort").value = "newest";

    // Reset filtered products to all products
    filteredProducts = [...productsData];

    const newUrl = window.location.pathname;
    history.replaceState(null, '', newUrl);

    // Re-render products and apply current sort
    renderProducts(filteredProducts);
    sortProducts(currentSortOption);
}

// Function to reset filter UI styles (called for each filter list)
function resetFilterUI(filterListId) {
    const list = document.getElementById(filterListId);
    list.querySelectorAll('a').forEach(link => {
        link.classList.remove("text-primary", "fw-bold", "text-decoration-underline");
    });
}


function sortProducts(sortOption) {
    currentSortOption = sortOption;

    let sortedProducts = [...filteredProducts]; 

    switch (sortOption) {
        case "newest":
            // Sort by newest (assuming product has a 'dateAdded' property)
            sortedProducts.sort((a, b) => new Date(b.dateAdded) - new Date(a.dateAdded));
            break;
        case "high-low":
            // Sort by price (High to Low)
            sortedProducts.sort((a, b) => parseFloat(b.product_detail?.price) - parseFloat(a.product_detail?.price));
            break;
        case "low-high":
            // Sort by price (Low to High)
            sortedProducts.sort((a, b) => parseFloat(a.product_detail?.price) - parseFloat(b.product_detail?.price));
            break;
        default:
            break;
    }

    // Render the sorted products
    renderProducts(sortedProducts);
}

function updateURL() {
    const params = new URLSearchParams();

    if (selectedCategory) params.set("category", selectedCategory);
    if (selectedBrand) params.set("brand", selectedBrand);
    if (selectedSportCategory) params.set("sport", selectedSportCategory);
    if (selectedMaxPrice !== 3000) params.set("price", selectedMaxPrice);

    const newUrl = `${window.location.pathname}?${params.toString()}`;
    history.replaceState(null, '', newUrl);
}





