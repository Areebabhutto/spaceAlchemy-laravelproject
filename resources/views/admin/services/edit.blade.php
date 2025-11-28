<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Service</h2>
    </x-slot>

     <div class="py-4 d-flex justify-content-center">
    <div class="w-50"> 
        <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Service Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $service->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" required>{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Service Icon</label>
                <input type="file" class="form-control" name="icon">
                @if($service->icon)
                    <div class="mt-2">
                        <small class="text-muted">Current icon:</small><br>
                        @if(Storage::disk('public')->exists($service->icon))
                            <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->title }}" style="max-width: 100px; max-height: 100px;">
                        @else
                            <i class="fas {{ $service->icon }} fa-2x"></i>
                        @endif
                    </div>
                @endif
            </div>
            
            <button type="submit" class="btn btn-success">Update Service</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>
</x-app-layout>
