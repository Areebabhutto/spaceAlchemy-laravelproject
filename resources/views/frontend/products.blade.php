@extends('frontend.layouts.main')

@section('main.container')

<!-- Products Section -->
<section class="products container mt-5 pt-5">
    <h1 class="heading text-center mb-5">Our Products</h1>
    
    <div class="row g-4">
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

@endsection
