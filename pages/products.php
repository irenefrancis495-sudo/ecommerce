<?php include __DIR__ . '/../components/ui/navbar.php';

$itemsPerPage = 12;
$products = \Mpemba\Entity\Product::getAllProducts($itemsPerPage);

//print_r($products);
?>

<main class="pt-40 pb-24 max-w-7xl mx-auto px-6 sm:px-8">
    <!-- Hero Header Composition -->
    <header class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-24 items-end">
        <div class="md:col-span-7">
            <p class="font-label text-primary uppercase tracking-[0.3em] text-xs mb-6 font-bold">The Digital Atelier</p>
            <h1 class="font-display text-6xl md:text-7xl lg:text-8xl font-black text-slate-900 leading-none tracking-tighter mb-6">All <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Products</span></h1>
            <p class="mt-8 text-slate-600 max-w-lg leading-relaxed text-lg font-medium">
                Discover our curated collection of premium products across all categories. From cutting-edge electronics to natural beauty essentials, handpicked for quality and style.
            </p>
        </div>
        <div class="md:col-span-5">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-secondary/10 to-tertiary/20 rounded-3xl blur-2xl"></div>
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-12 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.3),transparent_50%)]"></div>
                    <div class="text-center relative z-10">
                        <span class="material-symbols-outlined text-9xl text-white/40 mb-4 block">shopping_bag</span>
                        <p class="text-white font-bold text-2xl">Premium Collection</p>
                        <p class="text-slate-400 text-sm mt-2">Quality & Style Combined</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filters and Controls -->
    <div class="mb-16">
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative max-w-2xl focus-within:ring-2 focus-within:ring-primary/30 rounded-2xl">
                <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                <input id="productSearchInput" data-search-target="products" class="w-full bg-white border-2 border-slate-200 text-slate-900 placeholder-slate-400 rounded-2xl py-4 pl-14 pr-6 text-base focus:outline-none focus:border-primary focus:ring-0 transition-all shadow-sm hover:border-slate-300" placeholder="Search by name, category, or description..." type="search" />
            </div>
        </div>

        <!-- Filter and Sort Controls -->
        <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
            <!-- Category Filters -->
            <div class="flex flex-wrap gap-3">
                <button class="px-5 py-2.5 rounded-full bg-primary text-white font-semibold hover:bg-primary/90 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5" onclick="filterProducts('all')">All Products</button>
                <button class="px-5 py-2.5 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-medium hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200" onclick="filterProducts('atelier-electronics')">Electronics</button>
                <button class="px-5 py-2.5 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-medium hover:border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-200" onclick="filterProducts('heritage-fashion')">Fashion</button>
                <button class="px-5 py-2.5 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-medium hover:border-tertiary hover:text-tertiary hover:bg-tertiary/5 transition-all duration-200" onclick="filterProducts('natural-beauty')">Beauty</button>
                <button class="px-5 py-2.5 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-medium hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-200" onclick="filterProducts('lifestyle-essentials')">Lifestyle</button>
                <button class="px-5 py-2.5 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-medium hover:border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-200" onclick="filterProducts('sanctuary-home')">Home</button>
            </div>

            <!-- Sort Dropdown -->
            <div class="relative min-w-max">
                <select class="appearance-none px-6 py-2.5 rounded-lg bg-white border-2 border-slate-200 text-slate-700 font-medium focus:outline-none focus:border-primary transition-all cursor-pointer hover:border-slate-300 pr-10" id="sortSelect">
                    <option value="featured">Featured</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="rating">Top Rated</option>
                    <option value="name">A-Z</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">unfold_more</span>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-20" id="productsGrid">
        <!-- Products will be loaded here -->
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center">
        <div class="flex items-center gap-2 bg-white rounded-xl p-2 border border-slate-200 shadow-md">
            <button class="p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all" id="prevBtn" title="Previous page">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <div class="flex gap-1.5" id="pageNumbers"></div>
            <button class="p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all" id="nextBtn" title="Next page">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>
</main>

<script>

const sortedProducts = <?php echo json_encode($products['products']); ?>;
console.log(sortedProducts);
let currentFilter = 'all';
let currentSort = 'featured';
let currentPage = 1;
let currentSearchQuery = '';
const itemsPerPage = <?php echo $itemsPerPage; ?>;

function renderProducts() {
    // const filteredProducts = filterProductsByCategory(products, currentFilter);
    // const searchedProducts = filterProductsBySearch(filteredProducts, currentSearchQuery);
    // const sortedProducts = sortProducts(searchedProducts, currentSort);
    const paginatedProducts = paginateProducts(sortedProducts, currentPage, itemsPerPage);

    const productsGrid = document.getElementById('productsGrid');
    productsGrid.innerHTML = '';

    if (paginatedProducts.length === 0) {
        productsGrid.innerHTML = `
            <div class="col-span-full rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 to-slate-100 p-20 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">shopping_bag</span>
                <p class="text-2xl font-bold text-slate-700 mb-2">No products found</p>
                <p class="text-slate-500 max-w-lg mx-auto">Try adjusting your filters, search terms, or explore other categories to find what you're looking for.</p>
            </div>
        `;
    } else {
        paginatedProducts.forEach(product => {
            const productCard = createProductCard(product);
            productsGrid.appendChild(productCard);
        });
    }

    renderPagination(sortedProducts.length);
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'group bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden hover:shadow-xl hover:border-slate-300 transition-all duration-300 transform hover:-translate-y-1 flex flex-col';

    // Get category color
    const categoryColors = {
        'atelier-electronics': 'bg-blue-100 text-blue-700',
        'heritage-fashion': 'bg-pink-100 text-pink-700',
        'natural-beauty': 'bg-purple-100 text-purple-700',
        'lifestyle-essentials': 'bg-amber-100 text-amber-700',
        'sanctuary-home': 'bg-emerald-100 text-emerald-700'
    };

    const categoryColor = categoryColors[product.category_name] || 'bg-slate-100 text-slate-700';

    card.innerHTML = `
        <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-200 relative overflow-hidden">
            <img src="${product.image_url}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=400&h=400&fit=crop&crop=center'">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
            <button class="absolute top-4 right-4 w-11 h-11 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg hover:bg-white transform hover:scale-110">
                <span class="material-symbols-outlined text-lg text-red-500">favorite</span>
            </button>
            ${product.featured ? '<span class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-primary to-secondary text-white text-xs font-bold rounded-full shadow-lg">✨ Featured</span>' : ''}
        </div>
        <div class="p-5 flex flex-col flex-1">
            <div class="flex items-center justify-between gap-2 mb-3">
                <span class="px-3 py-1 ${categoryColor} text-xs font-bold rounded-full capitalize">${product.category_name.replace('-', ' ')}</span>
                <div class="flex items-center gap-1.5 bg-amber-50 px-2.5 py-1 rounded-lg">
                    <span class="material-symbols-outlined text-sm text-amber-500">star</span>
                    <span class="text-sm font-bold text-amber-900">${product.rating}</span>
                </div>
            </div>
            <h3 class="font-bold text-base text-slate-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors">${product.name}</h3>
            <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1">${product.description}</p>
            <div class="flex items-center justify-between gap-2 mb-4 text-xs font-medium">
                <span class="flex items-center gap-1.5 ${product.stock_quantity > 10 ? 'text-emerald-600' : product.stock_quantity > 0 ? 'text-amber-600' : 'text-red-600'}">
                    <span class="material-symbols-outlined text-sm">${product.stock_quantity > 0 ? 'check_circle' : 'cancel'}</span>
                    ${product.stock_quantity > 10 ? 'In Stock' : product.stock_quantity > 0 ? 'Limited' : 'Out of Stock'}
                </span>
                <span class="text-slate-500">${product.stock_quantity} left</span>
            </div>
            <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">$${product.price}</span>
                <button class="add-to-cart px-4 py-2.5 bg-gradient-to-r from-primary to-primary/90 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95" data-id="${product.id}" data-name="${product.name.replace(/"/g, '&quot;')}" data-price="${product.price}" data-image="${(product.image_url || '').replace(/"/g, '&quot;')}">
                    Add
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

function filterProductsBySearch(products, query) {
    if (!query) return products;
    const normalizedQuery = query.trim().toLowerCase();
    return products.filter(product => {
        const combined = `${product.name} ${product.description} ${product.category}`.toLowerCase();
        return combined.includes(normalizedQuery);
    });
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
        button.className = `px-3.5 py-1.5 rounded-lg font-semibold transition-all duration-200 ${i === currentPage ? 'bg-gradient-to-r from-primary to-primary/90 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'}`;
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

const productSearchInput = document.getElementById('productSearchInput');
if (productSearchInput) {
    productSearchInput.addEventListener('input', (e) => {
        currentSearchQuery = e.target.value;
        currentPage = 1;
        renderProducts();
    });
}

window.executeProductSearch = (query) => {
    currentSearchQuery = query || '';
    const searchInput = document.getElementById('productSearchInput');
    if (searchInput) {
        searchInput.value = currentSearchQuery;
    }
    currentPage = 1;
    renderProducts();
};

// Initialize products on page load
document.addEventListener('DOMContentLoaded', () => {
    renderProducts();
});
</script>

<script src="assets/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/js/app.js"></script>

<?php include __DIR__ . '/../components/ui/footer.php'; ?>