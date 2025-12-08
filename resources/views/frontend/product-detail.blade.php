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

            <button class="btn btn-primary" id="addToCartDetail" type="button" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-image="{{ asset('storage/'.$product->image) }}">Add to Cart</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const addToCartDetailBtn = document.getElementById("addToCartDetail");
  
  if (addToCartDetailBtn) {
    addToCartDetailBtn.addEventListener("click", function(e) {
      e.preventDefault();
      
      const detailQty = document.getElementById("detailQty");
      const quantity = parseInt(detailQty.value) || 1;
      const title = this.dataset.productName;
      const price = parseFloat(this.dataset.productPrice);
      const image = this.dataset.productImage;

      console.log("Adding to cart - Detail Page", { title, price, image, quantity });

      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      const existingItem = cart.find((item) => item.title === title);
      
      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        cart.push({ title, price, image, quantity });
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      console.log("Cart saved:", cart);
      
      // Update cart count
      const cartCount = document.getElementById("cart-count");
      if (cartCount) {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
      }
      
      alert(`${title} added to cart!`);
      detailQty.value = 1;
    });
  }
  
  // Quantity controls
  const detailQty = document.getElementById("detailQty");
  if (detailQty) {
    const quantitySelector = detailQty.closest(".quantity-selector");
    if (quantitySelector) {
      const incrementBtn = quantitySelector.querySelector(".increment");
      const decrementBtn = quantitySelector.querySelector(".decrement");
      
      if (incrementBtn) {
        incrementBtn.addEventListener("click", function(e) {
          e.preventDefault();
          detailQty.value = parseInt(detailQty.value) + 1;
        });
      }
      
      if (decrementBtn) {
        decrementBtn.addEventListener("click", function(e) {
          e.preventDefault();
          if (parseInt(detailQty.value) > 1) {
            detailQty.value = parseInt(detailQty.value) - 1;
          }
        });
      }
    }
  }
});
</script>

@endsection
