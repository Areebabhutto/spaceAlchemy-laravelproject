@extends('frontend.layouts.main')

@section('main.container')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
  <div class="row">
    <!-- Cart Items -->
    <div class="col-md-7">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="mb-0">Order Summary</h4>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="checkoutItems">
              <!-- Items populated by JavaScript -->
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th class="text-success fw-bold">$<span id="checkoutTotal">0.00</span></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <!-- Checkout Form -->
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Delivery Details</h4>
        </div>
        <div class="card-body">
          <form id="checkoutForm">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name *</label>
              <input type="text" id="name" name="customer_name" class="form-control" required />
              <span class="text-danger" id="nameError"></span>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email *</label>
              <input type="email" id="email" name="customer_email" class="form-control" required />
              <span class="text-danger" id="emailError"></span>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="tel" id="phone" name="customer_phone" class="form-control" />
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Shipping Address *</label>
              <textarea id="address" name="shipping_address" class="form-control" rows="3" required></textarea>
              <span class="text-danger" id="addressError"></span>
            </div>

            <div class="mb-3">
              <label for="paymentMethod" class="form-label">Payment Method</label>
              <select id="paymentMethod" name="payment_method" class="form-select">
                <option value="">Select</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cod">Cash on Delivery</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="notes" class="form-label">Special Instructions</label>
              <textarea id="notes" name="notes" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg" id="placeOrderBtn">
              <i class="bi bi-check-circle"></i> Place Order - $<span id="totalDisplay">0.00</span>
            </button>
          </form>

          <div id="errorAlert" class="alert alert-danger mt-3" style="display: none;">
            <strong>Error!</strong>
            <div id="errorMessage"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Message -->
  <div id="confirmationMessage" class="alert alert-success alert-dismissible fade show mt-4" style="display: none;" role="alert">
    <h4 class="alert-heading">✅ Order Placed Successfully!</h4>
    <p>Thank you for your order!</p>
    <hr>
    <p class="mb-0">Order Number: <strong id="orderNumber"></strong></p>
    <p class="mb-0">Order ID: <strong id="orderID"></strong></p>
    <a href="{{ url('/') }}" class="btn btn-outline-primary mt-3">Continue Shopping</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>

<!-- Include checkout service -->
<script src="/frontend/checkout.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Display cart items on checkout page
  function displayCheckoutItems() {
    const itemsContainer = document.getElementById('checkoutItems');
    const totalSpan = document.getElementById('checkoutTotal');
    const totalDisplay = document.getElementById('totalDisplay');
    
    if (!window.orderCheckout || window.orderCheckout.cartItems.length === 0) {
      itemsContainer.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Your cart is empty</td></tr>';
      return;
    }

    const items = window.orderCheckout.cartItems;
    let html = '';
    let total = 0;

    items.forEach(item => {
      const subtotal = item.quantity * item.price;
      total += subtotal;
      html += `
        <tr>
          <td><strong>${item.name}</strong></td>
          <td>${item.quantity}</td>
          <td>$${item.price.toFixed(2)}</td>
          <td>$${subtotal.toFixed(2)}</td>
          <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeItem('${item.product_id}')">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      `;
    });

    itemsContainer.innerHTML = html;
    totalSpan.textContent = total.toFixed(2);
    totalDisplay.textContent = total.toFixed(2);
  }

  // Remove item from cart
  window.removeItem = function(productId) {
    window.orderCheckout.removeFromCart(parseInt(productId));
    displayCheckoutItems();
  };

  // Handle form submission
  const checkoutForm = document.getElementById('checkoutForm');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      // Clear previous errors
      document.getElementById('nameError').textContent = '';
      document.getElementById('emailError').textContent = '';
      document.getElementById('addressError').textContent = '';
      document.getElementById('errorAlert').style.display = 'none';

      // Get form data
      const formData = {
        customer_name: document.getElementById('name').value,
        customer_email: document.getElementById('email').value,
        customer_phone: document.getElementById('phone').value,
        shipping_address: document.getElementById('address').value,
        billing_address: document.getElementById('address').value,
        payment_method: document.getElementById('paymentMethod').value,
        notes: document.getElementById('notes').value,
      };

      // Disable submit button
      const submitBtn = document.getElementById('placeOrderBtn');
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

      try {
        // Call the orderCheckout service to submit order to API
        const result = await window.orderCheckout.submitOrder(formData);

        if (result.success) {
          // Hide form
          document.getElementById('checkoutForm').style.display = 'none';

          // Show success message
          document.getElementById('orderNumber').textContent = result.data.order_number;
          document.getElementById('orderID').textContent = result.data.order_id;
          document.getElementById('confirmationMessage').style.display = 'block';

          // Scroll to success message
          document.getElementById('confirmationMessage').scrollIntoView({ behavior: 'smooth' });

          // Redirect after 5 seconds
          setTimeout(() => {
            window.location.href = '/';
          }, 5000);
        } else {
          // Show error message
          document.getElementById('errorAlert').style.display = 'block';
          let errorText = result.message || 'Failed to place order';

          if (result.errors) {
            if (result.errors.customer_name) {
              document.getElementById('nameError').textContent = result.errors.customer_name;
            }
            if (result.errors.customer_email) {
              document.getElementById('emailError').textContent = result.errors.customer_email;
            }
            if (result.errors.shipping_address) {
              document.getElementById('addressError').textContent = result.errors.shipping_address;
            }
            
            // Show all errors
            let errors = Object.values(result.errors).flat();
            errorText = errors.join('<br>');
          }

          document.getElementById('errorMessage').innerHTML = errorText;
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      } catch (error) {
        console.error('Order submission error:', error);
        document.getElementById('errorAlert').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Network error. Please try again.';
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }
    });
  }

  // Display items when page loads
  displayCheckoutItems();
});
</script>

@endsection