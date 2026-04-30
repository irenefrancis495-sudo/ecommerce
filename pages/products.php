<?php include __DIR__ . '/../components/ui/navbar.php'; ?>

<main class="pt-32 pb-20 max-w-7xl mx-auto px-8">
    <!-- Hero Header Composition -->
    <header class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-20 items-end">
        <div class="md:col-span-7">
            <p class="font-label text-primary uppercase tracking-[0.3em] text-sm mb-4">The Digital Atelier</p>
            <h1 class="font-display text-5xl md:text-7xl font-bold text-primary leading-tight tracking-tighter">All <br/><span class="text-secondary italic font-light">Products</span></h1>
            <p class="mt-6 text-on-surface-variant max-w-lg leading-relaxed text-lg">
                Discover our complete collection of premium products across all categories. From cutting-edge electronics to natural beauty essentials.
            </p>
        </div>
        <div class="md:col-span-5">
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-primary/10 via-secondary/5 to-tertiary/10 p-8 flex items-center justify-center">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-8xl text-primary/60 mb-4">shopping_bag</span>
                        <p class="text-primary font-semibold text-xl">Premium Collection</p>
                        <p class="text-on-surface-variant">Quality & Style</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filters and Controls -->
    <div class="flex flex-col sm:flex-row gap-4 mb-12 items-start sm:items-center justify-between">
        <div class="flex flex-wrap gap-3">
            <button class="px-4 py-2 rounded-full bg-primary text-on-primary font-medium hover:bg-primary/90 transition-colors" onclick="filterProducts('all')">All Products</button>
            <button class="px-4 py-2 rounded-full bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" onclick="filterProducts('atelier-electronics')">Electronics</button>
            <button class="px-4 py-2 rounded-full bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" onclick="filterProducts('heritage-fashion')">Fashion</button>
            <button class="px-4 py-2 rounded-full bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" onclick="filterProducts('natural-beauty')">Beauty</button>
            <button class="px-4 py-2 rounded-full bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" onclick="filterProducts('lifestyle-essentials')">Lifestyle</button>
            <button class="px-4 py-2 rounded-full bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" onclick="filterProducts('sanctuary-home')">Home</button>
        </div>
        <div class="flex items-center gap-4">
            <select class="px-4 py-2 rounded-lg bg-surface border border-outline text-on-surface focus:outline-none focus:ring-2 focus:ring-primary" id="sortSelect">
                <option value="featured">Sort by: Featured</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="rating">Rating</option>
                <option value="name">Name</option>
            </select>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-16" id="productsGrid">
        <!-- Products will be loaded here -->
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" id="prevBtn">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </button>
            <div class="flex gap-1" id="pageNumbers"></div>
            <button class="px-4 py-2 rounded-lg bg-surface text-on-surface border border-outline hover:bg-surface-variant transition-colors" id="nextBtn">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </button>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>

<script>
const products = <?php echo file_get_contents(__DIR__ . '/../data/products.json'); ?>;

let currentFilter = 'all';
let currentSort = 'featured';
let currentPage = 1;
const itemsPerPage = 12;

function renderProducts() {
    const filteredProducts = filterProductsByCategory(products, currentFilter);
    const sortedProducts = sortProducts(filteredProducts, currentSort);
    const paginatedProducts = paginateProducts(sortedProducts, currentPage, itemsPerPage);

    const productsGrid = document.getElementById('productsGrid');
    productsGrid.innerHTML = '';

    paginatedProducts.forEach(product => {
        const productCard = createProductCard(product);
        productsGrid.appendChild(productCard);
    });

    renderPagination(sortedProducts.length);
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'group bg-surface rounded-2xl shadow-sm border border-outline/50 overflow-hidden hover:shadow-lg transition-all duration-300';

    // Get category color
    const categoryColors = {
        'atelier-electronics': 'bg-primary-container text-on-primary-container',
        'heritage-fashion': 'bg-secondary-container text-on-secondary-container',
        'natural-beauty': 'bg-tertiary-container text-on-tertiary-container',
        'lifestyle-essentials': 'bg-primary-container text-on-primary-container',
        'sanctuary-home': 'bg-secondary-container text-on-secondary-container'
    };

    const categoryColor = categoryColors[product.category] || 'bg-primary-container text-on-primary-container';

    card.innerHTML = `
        <div class="aspect-square bg-gradient-to-br from-primary/5 to-secondary/5 relative overflow-hidden">
            <img src="${product.image_url}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/400x400?text=${encodeURIComponent(product.name)}'">
            <button class="absolute top-4 right-4 w-10 h-10 bg-surface/80 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined text-lg">favorite</span>
            </button>
            ${product.featured ? '<span class="absolute top-4 left-4 px-2 py-1 bg-primary text-on-primary text-xs font-medium rounded-full">Featured</span>' : ''}
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="px-3 py-1 ${categoryColor} text-xs font-medium rounded-full capitalize">${product.category.replace('-', ' ')}</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-yellow-500">star</span>
                    <span class="text-sm font-medium">${product.rating}</span>
                    <span class="text-sm text-on-surface-variant">(${Math.floor(Math.random() * 100) + 50})</span>
                </div>
            </div>
            <h3 class="font-semibold text-lg mb-2">${product.name}</h3>
            <p class="text-on-surface-variant text-sm mb-4 line-clamp-2">${product.description}</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-primary">$${product.price}</span>
                <button class="add-to-cart px-4 py-2 bg-primary text-on-primary rounded-lg font-medium hover:bg-primary/90 transition-colors" data-id="${product.id}" data-name="${product.name.replace(/"/g, '&quot;')}" data-price="${product.price}">
                    Add to Cart
                </button>
            </div>
        </div>
    `;

    return card;
}

function filterProductsByCategory(products, category) {
    if (category === 'all') return products;
    return products.filter(product => product.category === category);
}

function sortProducts(products, sortBy) {
    const sorted = [...products];
    switch (sortBy) {
        case 'price-low':
            return sorted.sort((a, b) => a.price - b.price);
        case 'price-high':
            return sorted.sort((a, b) => b.price - a.price);
        case 'rating':
            return sorted.sort((a, b) => b.rating - a.rating);
        case 'name':
            return sorted.sort((a, b) => a.name.localeCompare(b.name));
        case 'featured':
        default:
            return sorted.sort((a, b) => (b.featured || 0) - (a.featured || 0));
    }
}

function paginateProducts(products, page, itemsPerPage) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return products.slice(start, end);
}

function renderPagination(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pageNumbers = document.getElementById('pageNumbers');
    pageNumbers.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.className = `px-4 py-2 rounded-lg font-medium transition-colors ${i === currentPage ? 'bg-primary text-on-primary' : 'bg-surface text-on-surface hover:bg-surface-variant'}`;
        button.textContent = i;
        button.onclick = () => {
            currentPage = i;
            renderProducts();
        };
        pageNumbers.appendChild(button);
    }

    document.getElementById('prevBtn').onclick = () => {
        if (currentPage > 1) {
            currentPage--;
            renderProducts();
        }
    };

    document.getElementById('nextBtn').onclick = () => {
        if (currentPage < totalPages) {
            currentPage++;
            renderProducts();
        }
    };
}

function filterProducts(category) {
    currentFilter = category;
    currentPage = 1;
    renderProducts();
}

document.getElementById('sortSelect').addEventListener('change', (e) => {
    currentSort = e.target.value;
    currentPage = 1;
    renderProducts();
});

// Initialize products on page load
document.addEventListener('DOMContentLoaded', () => {
    renderProducts();
});
</script>

<script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/app.js"></script>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>