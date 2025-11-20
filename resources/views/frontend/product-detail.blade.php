@extends('frontend.layouts.main')

@section('main.container')

<section class="product-detail container ">
    <div class="row align-items-center">
        <!-- Product Image -->
        <div class="col-md-6 text-center">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow">
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-primary fs-4 fw-bold">${{ $product->price }}</p>
            <p class="text-muted">{{ $product->description }}</p>

            <!-- Quantity Selector -->
            <div class="input-group mb-3 quantity-selector">
                <button class="btn btn-outline-secondary decrement" type="button">-</button>
                <input type="number" id="detailQty" class="form-control text-center qty-input" min="1" value="1">
                <button class="btn btn-outline-secondary increment" type="button">+</button>
            </div>

            <button class="btn btn-primary" id="addToCartDetail">Add to Cart</button>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews mt-5">
        <h3>Customer Reviews</h3>
        <div id="reviewList" class="mb-3"></div>

        <h5>Leave a Review</h5>
        <form id="reviewForm">
            <input type="text" id="reviewName" class="form-control mb-2" placeholder="Your Name" required>
            <textarea id="reviewText" class="form-control mb-2" placeholder="Your Review" required></textarea>
            <button class="btn btn-success" type="submit">Submit Review</button>
        </form>
    </div>
</section>

@endsection
