<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Service</h2>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
    <div class="w-50"> 
<form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Service Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" required>{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Service Icon</label>
        <input type="file" class="form-control" name="icon">
    </div>

    <button type="submit" class="btn btn-success">Save Service</button>
    <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
</form>
    </div>
    </div>
</x-app-layout>
