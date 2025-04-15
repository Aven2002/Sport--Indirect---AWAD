let products = [];  // Store all products
let currentPage = 1;
const rowsPerPage = 15;

document.addEventListener("DOMContentLoaded", function () {
    loadProducts();
});

function loadProducts() {
    axios.get("/api/product")
        .then(response => {
            products = response.data.products ?? [];  
            displayTable();
        })
        .catch(() => {
            document.querySelector("#productTableBody").innerHTML = 
                `<tr><td colspan="9" class="text-center text-danger">Failed to load product records.</td></tr>`;
        });
}

function displayTable() {
    const tableBody = document.querySelector("#productTableBody");
    tableBody.innerHTML = "";

    if (products.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No product available.</td></tr>`;
        return;
    }

    products.forEach(product => {
        let row = `
            <tr>
                <td>${product.id}</td>
                <td>${product.productName}</td>
                <td>${product.sportCategory}</td>
                <td>${product.productCategory}</td>
                <td>${product.productBrand}</td>
                <td>${product.product_detail ? product.product_detail.stock : 'N/A'}</td>
                <td>${product.product_detail ? product.product_detail.price : 'N/A'}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button class="btn btn-info btn-sm" onclick="viewProduct(${product.id})">More</button>
                        <button class="btn btn-warning btn-sm" onclick="UpdateProduct(${product.id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;

        tableBody.innerHTML += row;
    });

    updatePagination();
}


function updatePagination() {
    const totalPages = Math.ceil(products.length / rowsPerPage);
    const pagination = document.querySelector("#pagination");
    pagination.innerHTML = "";

    if (totalPages <= 1) return; // Hide pagination if only one page

    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`;
    }
}

function changePage(page) {
    currentPage = page;
    displayTable();
}

function viewProduct(productId) {
    axios.get(`/api/product/${productId}`)
        .then(response => {
            const product = response.data.product;

            const productName = document.getElementById('productName');
            const productImage = document.getElementById('productImage');
            const productDescription = document.getElementById('productDescription');
            const productModalEl = document.getElementById('viewProductModal');

            if (!productName || !productImage || !productDescription || !productModalEl) {
                console.error("Modal elements not found in the HTML.");
                alert("Error: Modal elements missing from the page.");
                return;
            }

            // Populate modal with product details
            productName.textContent = product.productName;
            productImage.src = product.product_detail?.imgPath 
                ? `/images/${product.product_detail.imgPath}` 
                : "/images/defaultImg.png";
            productDescription.textContent = product.product_detail?.description || "No description available";

            // Show modal using Bootstrap
            const productModal = new bootstrap.Modal(productModalEl);
            productModal.show();

            // Wait until the modal is shown, then set focus
            productModalEl.addEventListener('shown.bs.modal', () => {
                const closeBtn = productModalEl.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.focus();
                }
            }, { once: true });

        })
        .catch(error => {
            console.error("Error fetching product:", error.response?.data || error.message);
            alert("Failed to fetch product details.");
        });
}




window.deleteProduct = function (id) {
    // Fetch product details to display in the modal
    axios.get(`/api/product/${id}`)
        .then(response => {
            const product = response.data.product;
            
            // Populate the modal with product details
            document.getElementById("deleteProductName").textContent = product.productName;
            document.getElementById("deleteProductImage").src = product.product_detail.imgPath ? `/images/${product.product_detail.imgPath}` : "/images/defaultImg.png";
            
            // Show the modal
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
            deleteModal.show();

            // Handle the actual deletion if user confirms
            document.getElementById("confirmDeleteBtn").onclick = function() {
                axios.delete(`/api/product/${id}`)
                    .then(() => {
                        showToast("Product record deleted successfully.", "success");
                        loadProducts(); // Reload the product list
                    })
                    .catch(() => showToast("Error deleting product record.", "error"));
            };
        })
        .catch(() => showToast("Error fetching product details.", "error"));
};



function UpdateProduct(productId) {
    axios.get(`/api/product/${productId}`)
        .then(response => {
            const product = response.data.product;

            if (!product) {
                alert("Product record not found");
                return;
            }

            // Populate form fields with current product data
            document.getElementById("updateProductId").value = product.id;
            document.getElementById("updateProductName").value = product.productName;
            document.getElementById("updateSportCategory").value = product.sportCategory;
            document.getElementById("updateProductCategory").value = product.productCategory;
            document.getElementById("updateProductBrand").value = product.productBrand;
            document.getElementById("updateStock").value = product.product_detail.stock;
            document.getElementById("updatePrice").value = product.product_detail.price;
            document.getElementById("updateDescription").value = product.product_detail.description;

            // Store current image path in a hidden variable
            document.getElementById("updateProductId").setAttribute("data-imgPath", product.product_detail.imgPath);

            // Show Bootstrap modal
            let updateModal = new bootstrap.Modal(document.getElementById("updateProductModal"));
            updateModal.show();
        })
        .catch(error => {
            console.error("Error fetching product record:", error.response?.data || error.message);
            alert("Failed to fetch product details.");
        });
}

// Handle form submission --Update
document.getElementById("updateProductForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const productId = document.getElementById("updateProductId").value;
    
    const updatedProduct = {
        productName: document.getElementById("updateProductName").value.trim(),
        sportCategory: document.getElementById("updateSportCategory").value.trim(),
        productCategory: document.getElementById("updateProductCategory").value.trim(),
        productBrand: document.getElementById("updateProductBrand").value.trim(),
        description: document.getElementById("updateDescription").value.trim(),
        stock: parseInt(document.getElementById("updateStock").value, 10), 
        imgPath: document.getElementById("updateProductId").getAttribute("data-imgPath"),  
        price: parseFloat(document.getElementById("updatePrice").value)
    };

    axios.put(`/api/product/${productId}`, updatedProduct, {
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        showToast("Product record updated successfully.", "success");
        loadProducts();
    })
    .catch(error => {
        console.error("Error updating product:", error.response?.data || error.message);
        showToast("Failed to update product. Check required fields.", "failure");
    });
});

// Handle form submission --Create
document.getElementById("createProductForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append("productName", document.getElementById("createProductName").value.trim());
    formData.append("sportCategory", document.getElementById("createSportCategory").value.trim());
    formData.append("productCategory", document.getElementById("createProductCategory").value.trim());
    formData.append("productBrand", document.getElementById("createProductBrand").value.trim());
    formData.append("description", document.getElementById("createDescription").value.trim());
    formData.append("stock", parseInt(document.getElementById("createStock").value, 10));
    formData.append("price", parseFloat(document.getElementById("createPrice").value));

    const productImage = document.getElementById("createProductImage").files[0];

    if (productImage) {
        formData.append("productImage", productImage); // Append image file if provided
    } else {
        formData.append("productImage", "Default/_product.png"); // Path to default image
    }

    try {
        const response = await axios.post("/api/product", formData, {
            headers: { "Content-Type": "multipart/form-data" }
        });

        showToast("Product created successfully.", "success");
        document.getElementById("createProductForm").reset();
        let createModal = bootstrap.Modal.getInstance(document.getElementById("createProductModal"));
        createModal.hide();
        loadProducts(); 
    } catch (error) {
        console.error("Error adding product:", error.response?.data || error.message);
        showToast("Failed to add product. Check required fields.", "failure");
    }
});





