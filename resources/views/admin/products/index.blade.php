<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
    <div class="w-75">   
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Bar -->
        <div class="mb-4 position-relative">
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
            <div id="searchResults" class="position-absolute w-100 bg-white border border-gray-300 rounded mt-1" style="display:none; max-height: 300px; overflow-y: auto; z-index: 1000;">
            </div>
        </div>

        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <table class="table table-bordered" id="productsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const originalRows = [];

// Store original rows on page load
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('productsTableBody');
    originalRows.push(...tbody.querySelectorAll('tr'));
});

document.getElementById('productSearch').addEventListener('keyup', function() {
    const query = this.value.trim();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 1) {
        resultsDiv.style.display = 'none';
        resetTable();
        return;
    }
    
    fetch(`{{ route('products.search') }}?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = '';
            
            if (data.length === 0) {
                resultsDiv.innerHTML = '<div class="p-3 text-muted">No results found</div>';
                resultsDiv.style.display = 'block';
                updateTable([]);
                return;
            }
            
            data.forEach(product => {
                const resultItem = document.createElement('div');
                resultItem.className = 'p-3 border-bottom cursor-pointer';
                resultItem.style.cursor = 'pointer';
                resultItem.innerHTML = `
                    <div class="fw-bold">${product.name}</div>
                    <div class="small text-muted">$${product.price}</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    document.getElementById('productSearch').value = product.name;
                    resultsDiv.style.display = 'none';
                    updateTable([product]);
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
            updateTable(data);
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

function updateTable(products) {
    const tbody = document.getElementById('productsTableBody');
    tbody.innerHTML = '';
    
    if (products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No products found</td></tr>';
        return;
    }
    
    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>$${product.price}</td>
            <td>
                <a href="/admin/products/${product.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/products/${product.id}" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                </form>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function resetTable() {
    const tbody = document.getElementById('productsTableBody');
    tbody.innerHTML = '';
    
    if (originalRows.length === 0) {
        // If no original rows stored, reload the page
        location.reload();
        return;
    }
    
    originalRows.forEach(row => {
        tbody.appendChild(row.cloneNode(true));
    });
}

document.getElementById('productSearch').addEventListener('input', function() {
    if (this.value.trim().length === 0) {
        resetTable();
        document.getElementById('searchResults').style.display = 'none';
    }
});
</script>

<style>
    .cursor-pointer:hover {
        background-color: #f8f9fa;
    }
</style>
</x-app-layout>
