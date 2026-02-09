// Products Data
const products = [
    {
        id: 1,
        name: "Monocrystalline (Mono) Solar Panels",
        description: "Made from a single silicon crystal, offering the highest efficiency (around 19-22%) and a sleek black look, ideal for limited roof space but costlier.",
        price: 45000,
        rating: 4.8,
        reviews: 124,
        image: "https://suratexim.com/wp-content/uploads/2019/08/mono-perc-solar-panel-530-550-watt-1000x1000-1.webp",
        customerReviews: [
            "Excellent efficiency ⭐⭐⭐⭐⭐",
            "Very premium quality ⭐⭐⭐⭐",
            "Worth the price ⭐⭐⭐⭐⭐",
            "Perfect for home ⭐⭐⭐⭐"
        ]
    },
    {
        id: 2,
        name: "Polycrystalline (Poly) Solar Panel",
        description: "Formed from multiple silicon fragments, resulting in a blue, speckled appearance, lower efficiency (15-17%), and a more budget-friendly option for larger areas.",
        price: 14950,
        rating: 4.9,
        reviews: 89,
        image: "https://shop.genusinnovation.com/cdn/shop/products/panel_poly165-12_1_1.jpg?v=1647861629",
        customerReviews: [
            "Budget friendly ⭐⭐⭐⭐",
            "Good performance ⭐⭐⭐⭐",
            "Nice build ⭐⭐⭐⭐",
            "Satisfied ⭐⭐⭐⭐⭐"
        ]
    },
    {
        id: 3,
        name: "Premium Solar Thin-Film Solar Panel",
        description: "Created by depositing photovoltaic material on a substrate, making them flexible, lightweight, and good for unconventional surfaces, though they have lower efficiency (10-12%).",
        price: 19950,
        rating: 4.7,
        reviews: 256,
        image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQowgeXQSpA2oYbnYfWf1rdYVnCXSADGlTI-A&s",
        customerReviews: [
            "Lightweight ⭐⭐⭐⭐",
            "Easy install ⭐⭐⭐⭐",
            "Modern tech ⭐⭐⭐⭐⭐",
            "Good design ⭐⭐⭐⭐"
        ]
    },
    {
        id: 4,
        name: "Off-Grid Solar Kit PERC Panels",
        description: "An enhancement for mono/poly cells with a rear layer that reflects light, increasing sunlight capture and efficiency (up to 23%).",
        price: 79950,
        rating: 4.9,
        reviews: 67,
        image: "https://cpimg.tistatic.com/9814672/b/4/3-kw-400wp-black-mono-perc-non-dcr-on-grid-solar-kit.jpg",
        customerReviews: [
            "High output ⭐⭐⭐⭐⭐",
            "Best off-grid ⭐⭐⭐⭐⭐",
            "Excellent quality ⭐⭐⭐⭐",
            "Reliable ⭐⭐⭐⭐"
        ]
    },
    {
        id: 5,
        name: "Bifacial Solar Panels",
        description: "Generate power from both the front and back sides, capturing reflected light for higher energy yield.",
        price: 64950,
        rating: 4.6,
        reviews: 198,
        image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTe9nsutaYe0FZFJgjhOqEzc762IlQ8uVQxrQ&s",
        customerReviews: [
            "Innovative ⭐⭐⭐⭐⭐",
            "High efficiency ⭐⭐⭐⭐",
            "Good investment ⭐⭐⭐⭐",
            "Advanced tech ⭐⭐⭐⭐⭐"
        ]
    },
    {
        id: 6,
        name: "Perovskite Solar Cells",
        description: "An emerging technology promising very high efficiencies (over 29%).",
        price: 39950,
        rating: 4.8,
        reviews: 145,
        image: "https://s7d1.scene7.com/is/image/CENODS/09624-feature1-tandemcellcxd?%24responsive%24=&wid=418&fit=constrain&qlt=90%2C0&resMode=sharp2&fmt=webp",
        customerReviews: [
            "Future technology ⭐⭐⭐⭐⭐",
            "Very powerful ⭐⭐⭐⭐",
            "Impressive ⭐⭐⭐⭐⭐",
            "Promising ⭐⭐⭐⭐"
        ]
    }
];

// Customer Reviews (Home Page)
const customerReviews = [
    {
        name: "Rajesh Patel",
        location: "Katargam, Surat",
        comment: "Amazing experience! The installation was quick and my bill is now zero.",
        stars: 5
    },
    {
        name: "Suresh Mehta",
        location: "Vesu, Surat",
        comment: "Very professional team. The panels are of high quality.",
        stars: 5
    },
    {
        name: "Anjali Shah",
        location: "Adajan, Surat",
        comment: "The kit is perfect for my bungalow.",
        stars: 4
    }
];

// Cart (LocalStorage)
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Render Products
function renderProducts() {
    const grid = document.getElementById("productGrid");
    if (!grid) return;

    grid.innerHTML = products.map(p => `
        <div class="product-card" onclick="openProduct(${p.id})">
            <div class="product-image" style="background-image:url('${p.image}')"></div>
            <div class="product-info">
                <h3>${p.name}</h3>
                <p>${p.description}</p>
                <div class="product-price">₹${p.price.toLocaleString("en-IN")}</div>
                <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(${p.id})">
                    Add to Cart
                </button>
            </div>
        </div>
    `).join("");
}

// Product click
function openProduct(id) {
    localStorage.setItem("selectedProductId", id);
    localStorage.setItem("productsData", JSON.stringify(products));
    window.location.href = "product.html";
}

// Cart functions
function addToCart(id) {
    const product = products.find(p => p.id === id);
    const existing = cart.find(item => item.id === id);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ ...product, qty: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    showMessage(`${product.name} added to cart`);
}

function updateCartCount() {
    const count = document.getElementById("cartCount");
    if (count) count.textContent = cart.reduce((sum, i) => sum + i.qty, 0);
}

function showCart() {
    window.location.href = "cart.html";
}

// Reviews render
function renderReviews() {
    const reviewGrid = document.getElementById("reviewGrid");
    if (!reviewGrid) return;

    reviewGrid.innerHTML = customerReviews.map(r => `
        <div class="review-card">
            <div class="stars">${"⭐".repeat(r.stars)}</div>
            <p>"${r.comment}"</p>
            <h4>${r.name}</h4>
            <p>${r.location}</p>
        </div>
    `).join("");
}

// Message
function showMessage(text) {
    const msg = document.getElementById("successMessage");
    if (!msg) return;
    msg.textContent = text;
    msg.style.display = "block";
    setTimeout(() => msg.style.display = "none", 3000);
}

// Init
document.addEventListener("DOMContentLoaded", () => {
    renderProducts();
    renderReviews();
    updateCartCount();
});
