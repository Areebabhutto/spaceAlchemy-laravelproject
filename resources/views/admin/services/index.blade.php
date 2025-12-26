<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Services
            </h2>
            <a href="{{ route('services.create') }}" class="btn btn-primary">Add Service</a>
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
                    id="serviceSearch" 
                    class="form-control" 
                    placeholder="Search by Title or Description..."
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
            <table class="table table-bordered" id="servicesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Icon</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="servicesTableBody">
                    @forelse($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->title }}</td>
                        <td>{{ Str::limit($service->description, 50) }}</td>
                        <td>
                            @if($service->icon)
                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->title }}" style="max-width: 50px; max-height: 50px; object-fit: cover;">
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No services found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const originalRows = [];

// Store original rows on page load
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('servicesTableBody');
    originalRows.push(...tbody.querySelectorAll('tr'));
});

document.getElementById('serviceSearch').addEventListener('keyup', function() {
    const query = this.value.trim();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 1) {
        resultsDiv.style.display = 'none';
        resetTable();
        return;
    }
    
    fetch(`{{ route('services.search') }}?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = '';
            
            if (data.length === 0) {
                resultsDiv.innerHTML = '<div class="p-3 text-muted">No results found</div>';
                resultsDiv.style.display = 'block';
                updateTable([]);
                return;
            }
            
            data.forEach(service => {
                const resultItem = document.createElement('div');
                resultItem.className = 'p-3 border-bottom cursor-pointer';
                resultItem.style.cursor = 'pointer';
                resultItem.innerHTML = `
                    <div class="fw-bold">${service.title}</div>
                    <div class="small text-muted">${service.description.substring(0, 50)}...</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    document.getElementById('serviceSearch').value = service.title;
                    resultsDiv.style.display = 'none';
                    updateTable([service]);
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
    const searchInput = document.getElementById('serviceSearch');
    const resultsDiv = document.getElementById('searchResults');
    const searchBtn = document.getElementById('searchBtn');
    
    if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target) && !searchBtn.contains(e.target)) {
        resultsDiv.style.display = 'none';
    }
});

function updateTable(services) {
    const tbody = document.getElementById('servicesTableBody');
    tbody.innerHTML = '';
    
    if (services.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No services found</td></tr>';
        return;
    }
    
    services.forEach(service => {
        const iconHtml = service.icon ? 
            (service.icon.includes('/') ? 
                `<img src="/storage/${service.icon}" alt="${service.title}" style="max-width: 50px; max-height: 50px;">` :
                `<i class="fas ${service.icon} fa-2x"></i>`) :
            '<span class="text-muted">No icon</span>';
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${service.id}</td>
            <td>${service.title}</td>
            <td>${service.description.substring(0, 50)}...</td>
            <td>${iconHtml}</td>
            <td>
                <a href="/admin/services/${service.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/services/${service.id}" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                </form>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function resetTable() {
    const tbody = document.getElementById('servicesTableBody');
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

document.getElementById('serviceSearch').addEventListener('input', function() {
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
