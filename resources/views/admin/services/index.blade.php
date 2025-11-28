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

        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Icon</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->title }}</td>
                        <td>{{ Str::limit($service->description, 50) }}</td>
                        <td>
                            @if($service->icon)
                                @if(Storage::disk('public')->exists($service->icon))
                                    <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->title }}" style="max-width: 50px; max-height: 50px;">
                                @else
                                    <i class="fas {{ $service->icon }} fa-2x"></i>
                                @endif
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
