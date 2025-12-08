<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Package</h2>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
    <div class="w-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('packages.update', $package) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Package Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $package->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $package->price) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Product</label>
                <select class="form-control" name="product_id" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $package->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (${{ $product->price }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Services (Select at least one)</label>
                <div class="border p-3 rounded" style="max-height: 250px; overflow-y: auto;">
                    @foreach($services as $service)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="services[]" 
                                value="{{ $service->id }}"
                                id="service_{{ $service->id }}"
                                {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="service_{{ $service->id }}">
                                {{ $service->title }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update Package</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>
</x-app-layout>
