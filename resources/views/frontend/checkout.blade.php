@extends('frontend.layouts.main')

@section('main.container')

  <div class="checkout-container">
    <h2>Checkout</h2>

    <div id="checkoutItems"></div>

    <div class="checkout-summary">
      <h3>Total: $<span id="checkoutTotal">0</span></h3>
    </div>

    <form id="checkoutForm">
      <h3>Customer Details</h3>
      <label>Full Name:</label>
      <input type="text" id="name" required />

      <label>Email:</label>
      <input type="email" id="email" required />

      <label>Address:</label>
      <textarea id="address" required></textarea>

      <label>Payment Method:</label>
      <select id="paymentMethod" required>
        <option value="">Select</option>
        <option value="credit">Credit Card</option>
        <option value="debit">Debit Card</option>
        <option value="cod">Cash on Delivery</option>
      </select>

      <button type="submit" class="btn">Place Order</button>
    </form>

    <div id="confirmationMessage" style="display: none;" class="hidden">
      <h3>✅ Order Placed Successfully!</h3>
      <p>Thank you for shopping with us.</p>
      <a href="{{ url('/') }}" class="btn btn-outline-primary">Go Home</a>
    </div>
  </div>

 @endsection