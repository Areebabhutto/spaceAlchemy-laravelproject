@extends('frontend.layouts.main')

@section('main.container')

  <!-- Cart Section -->
  <section class="cart-section container mt-5 pt-5">
    <h1 class="heading text-center mb-5">Your Cart</h1>
    <div id="cart-items" class="row g-4"></div>

    <div class="cart-summary mt-5 text-end">
      <h3>Total: $<span id="cart-total">0</span></h3>
      <button class="btn btn-success" id="checkout-btn">Checkout</button>
      <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
    </div>
  </section>


@endsection