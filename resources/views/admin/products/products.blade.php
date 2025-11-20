<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Our Products
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($products as $p)
            <div class="bg-white shadow rounded p-4">
                @if($p->image)
                    <img src="{{ asset('storage/uploads/'.$p->image) }}" class="w-full h-48 object-cover mb-2 rounded">
                @endif
                <h3 class="font-semibold text-lg">{{ $p->name }}</h3>
                <p class="text-gray-700 mb-2">{{ $p->description }}</p>
                <p class="font-bold">Rs. {{ $p->price }}</p>
            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
