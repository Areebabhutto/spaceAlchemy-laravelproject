<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Packages
            </h2>
            <a href="{{ route('packages.create') }}" class="btn btn-primary">Add Package</a>
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
                    id="packageSearch" 
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
            <table class="table table-bordered" id="packagesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Product</th>
                        <th>Services</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="packagesTableBody">
                    @foreach($packages as $package)
                    <tr>
                        <td>{{ $package->id }}</td>
                        <td>{{ $package->name }}</td>
                        <td>{{ $package->product->name ?? 'N/A' }}</td>
                        <td>
                            @foreach($package->services as $service)
                                <span class="badge bg-info">{{ $service->title }}</span>
                            @endforeach
                        </td>
                        <td>${{ $package->price }}</td>
                        <td>
                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
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
    const tbody = document.getElementById('packagesTableBody');
    originalRows.push(...tbody.querySelectorAll('tr'));
});

document.getElementById('packageSearch').addEventListener('keyup', function() {
    const query = this.value.trim();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 1) {
        resultsDiv.style.display = 'none';
        resetTable();
        return;
    }
    
    fetch(`{{ route('packages.search') }}?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = '';
            
            if (data.length === 0) {
                resultsDiv.innerHTML = '<div class="p-3 text-muted">No results found</div>';
                resultsDiv.style.display = 'block';
                updateTable([]);
                return;
            }
            
            data.forEach(package => {
                const resultItem = document.createElement('div');
                resultItem.className = 'p-3 border-bottom cursor-pointer';
                resultItem.style.cursor = 'pointer';
                resultItem.innerHTML = `
                    <div class="fw-bold">${package.name}</div>
                    <div class="small text-muted">$${package.price}</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    document.getElementById('packageSearch').value = package.name;
                    resultsDiv.style.display = 'none';
                    updateTable([package]);
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
    const searchInput = document.getElementById('packageSearch');
    const resultsDiv = document.getElementById('searchResults');
    const searchBtn = document.getElementById('searchBtn');
    
    if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target) && !searchBtn.contains(e.target)) {
        resultsDiv.style.display = 'none';
    }
});

function updateTable(packages) {
    const tbody = document.getElementById('packagesTableBody');
    tbody.innerHTML = '';
    
    if (packages.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No packages found</td></tr>';
        return;
    }
    
    packages.forEach(package => {
        const servicesBadges = package.services.map(s => `<span class="badge bg-info">${s.title}</span>`).join(' ');
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${package.id}</td>
            <td>${package.name}</td>
            <td>${package.product.name}</td>
            <td>${servicesBadges}</td>
            <td>$${package.price}</td>
            <td>
                <a href="/admin/packages/${package.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/packages/${package.id}" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
                </form>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function resetTable() {
    const tbody = document.getElementById('packagesTableBody');
    tbody.innerHTML = '';
    
    if (originalRows.length === 0) {
        location.reload();
        return;
    }
    
    originalRows.forEach(row => {
        tbody.appendChild(row.cloneNode(true));
    });
}

document.getElementById('packageSearch').addEventListener('input', function() {
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
