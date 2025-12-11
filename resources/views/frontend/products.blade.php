@extends('frontend.layouts.main')

@section('main.container')

<!-- Products Section -->
<section class="products container mt-5 pt-5">
    <h1 class="heading text-center mb-5">Our Products</h1>
    
    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <div class="position-relative">
                <div class="input-group">
                    <input 
                        type="text" 
                        id="productSearch" 
                        class="form-control" 
                        placeholder="Search by Name or Description..."
                        autocomplete="off"
                    >
                    <button class="btn btn-primary" type="button" id="searchBtn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <div id="searchResults" class="position-absolute w-100 bg-white border border-secondary rounded mt-1" style="display:none; max-height: 300px; overflow-y: auto; z-index: 1000;">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4" id="productsGrid">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card product-card">
                <a href="{{ url('/product-detail') }}?id={{ $product->id }}">
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">${{ $product->price }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<script>
const originalProducts = [];

// Store original products on page load
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('productsGrid');
    const productCards = grid.querySelectorAll('.col-md-4');
    productCards.forEach(card => {
        const productData = {
            html: card.innerHTML,
            element: card.cloneNode(true)
        };
        originalProducts.push(productData);
    });
});

// Function to highlight matching text
function highlightText(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<mark style="background-color: #ffc107; padding: 2px 4px; border-radius: 3px;">$1</mark>');
}

document.getElementById('productSearch').addEventListener('keyup', function() {
    const query = this.value.trim();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 1) {
        resultsDiv.style.display = 'none';
        resetProducts();
        return;
    }
    
    fetch(`/admin/products/search?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = '';
            
            if (data.length === 0) {
                resultsDiv.innerHTML = '<div class="p-3 text-muted">No results found</div>';
                resultsDiv.style.display = 'block';
                updateGrid([]);
                return;
            }
            
            data.forEach(product => {
                const resultItem = document.createElement('div');
                resultItem.className = 'p-3 border-bottom cursor-pointer';
                resultItem.style.cursor = 'pointer';
                
                // Highlight matching text
                const highlightedName = highlightText(product.name, query);
                
                resultItem.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-3">
                            <img src="/storage/${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </div>
                        <div class="col-9">
                            <div class="fw-bold">${highlightedName}</div>
                            <div class="small text-muted">$${product.price}</div>
                        </div>
                    </div>
                `;
                
                resultItem.addEventListener('click', function() {
                    window.location.href = `/product-detail?id=${product.id}`;
                });
                
                resultItem.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                
                resultItem.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
                
                resultsDiv.appendChild(resultItem);
            });
            
            resultsDiv.style.display = 'block';
            updateGrid(data);
        })
        .catch(error => console.error('Search error:', error));
});

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('productSearch');
    const resultsDiv = document.getElementById('searchResults');
    const searchBtn = document.getElementById('searchBtn');
    
    if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target) && !searchBtn.contains(e.target)) {
        resultsDiv.style.display = 'none';
    }
});

function updateGrid(products) {
    const grid = document.getElementById('productsGrid');
    grid.innerHTML = '';
    
    if (products.length === 0) {
        grid.innerHTML = '<div class="col-12"><p class="text-center text-muted">No products found</p></div>';
        return;
    }
    
    products.forEach(product => {
        const card = document.createElement('div');
        card.className = 'col-md-4';
        card.innerHTML = `
            <div class="card product-card">
                <a href="/product-detail?id=${product.id}">
                    <img src="/storage/${product.image}" class="card-img-top" alt="${product.name}">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">$${product.price}</p>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
}

function resetProducts() {
    const grid = document.getElementById('productsGrid');
    grid.innerHTML = '';
    
    if (originalProducts.length === 0) {
        location.reload();
        return;
    }
    
    originalProducts.forEach(productData => {
        const clone = productData.element.cloneNode(true);
        grid.appendChild(clone);
    });
}

document.getElementById('productSearch').addEventListener('input', function() {
    if (this.value.trim().length === 0) {
        resetProducts();
        document.getElementById('searchResults').style.display = 'none';
    }
});

// Search button click handler
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchInput = document.getElementById('productSearch');
    const event = new Event('keyup', { bubbles: true });
    searchInput.dispatchEvent(event);
});
</script>

<style>
    .cursor-pointer:hover {
        background-color: #f8f9fa !important;
    }
</style>

@endsection
