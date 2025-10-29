@extends('frontend.layouts.main')

@section('main.container')

<!-- Cart Section -->
<section class="cart-section container mt-5 pt-5">
  <h1 class="heading text-center mb-5">Your Shopping Cart</h1>

  <div class="table-responsive">
    <table class="cart-table table align-middle">
      <thead class="cart-header">
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody id="cart-items"></tbody>
    </table>
  </div>

  <div class="cart-summary mt-4 text-end">
    <h3>Total: $<span id="cart-total">0</span></h3>
    <button class="btn btn-success" id="checkout-btn">Checkout</button>
    <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
  </div>
</section>

@endsection
