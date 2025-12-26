/**
 * Vue 3 Checkout Component Example
 * This is a complete example of how to integrate the order checkout system with Vue 3
 */

<template>
  <div class="checkout-container">
    <div class="container py-5">
      <h1>Checkout</h1>

      <!-- Cart Summary -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Order Summary</h5>
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
                <tbody>
                  <tr v-for="item in cartItems" :key="`${item.product_id}-${item.package_id}`">
                    <td>
                      <strong>{{ item.name }}</strong>
                    </td>
                    <td>
                      <input
                        type="number"
                        v-model.number="item.quantity"
                        @change="updateQuantity(item)"
                        min="1"
                        class="form-control"
                        style="width: 80px"
                      />
                    </td>
                    <td>${{ item.price.toFixed(2) }}</td>
                    <td><strong>${{ (item.quantity * item.price).toFixed(2) }}</strong></td>
                    <td>
                      <button
                        @click="removeItem(item.product_id, item.package_id)"
                        class="btn btn-sm btn-danger"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tfoot class="table-light">
                  <tr>
                    <th colspan="3">Total:</th>
                    <th class="text-success">${{ cartTotal.toFixed(2) }}</th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Delivery Details</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitOrder">
                <!-- Customer Name -->
                <div class="mb-3">
                  <label for="customer_name" class="form-label">Full Name*</label>
                  <input
                    id="customer_name"
                    v-model="formData.customer_name"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': formErrors.customer_name }"
                    required
                  />
                  <div v-if="formErrors.customer_name" class="invalid-feedback">
                    {{ formErrors.customer_name }}
                  </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                  <label for="customer_email" class="form-label">Email*</label>
                  <input
                    id="customer_email"
                    v-model="formData.customer_email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': formErrors.customer_email }"
                    required
                  />
                  <div v-if="formErrors.customer_email" class="invalid-feedback">
                    {{ formErrors.customer_email }}
                  </div>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                  <label for="customer_phone" class="form-label">Phone</label>
                  <input
                    id="customer_phone"
                    v-model="formData.customer_phone"
                    type="tel"
                    class="form-control"
                  />
                </div>

                <!-- Shipping Address -->
                <div class="mb-3">
                  <label for="shipping_address" class="form-label">Address*</label>
                  <textarea
                    id="shipping_address"
                    v-model="formData.shipping_address"
                    class="form-control"
                    :class="{ 'is-invalid': formErrors.shipping_address }"
                    rows="3"
                    required
                  ></textarea>
                  <div v-if="formErrors.shipping_address" class="invalid-feedback">
                    {{ formErrors.shipping_address }}
                  </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                  <label for="payment_method" class="form-label">Payment Method</label>
                  <select
                    id="payment_method"
                    v-model="formData.payment_method"
                    class="form-select"
                  >
                    <option value="">Select method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                  </select>
                </div>

                <!-- Submit Button -->
                <button
                  type="submit"
                  :disabled="isSubmitting || cartItems.length === 0"
                  class="btn btn-primary w-100 btn-lg"
                >
                  <span v-if="!isSubmitting">
                    <i class="bi bi-check-circle"></i> Place Order
                  </span>
                  <span v-else>
                    <i class="spinner-border spinner-border-sm me-2"></i> Processing...
                  </span>
                </button>
              </form>
            </div>
          </div>

          <!-- Success Alert -->
          <div v-if="orderSuccess" class="alert alert-success alert-dismissible mt-3">
            <strong>Success!</strong> Order {{ orderNumber }} placed successfully.
            <button
              type="button"
              @click="orderSuccess = false"
              class="btn-close"
            ></button>
          </div>

          <!-- Error Alert -->
          <div v-if="orderError" class="alert alert-danger alert-dismissible mt-3">
            <strong>Error!</strong> {{ orderError }}
            <button
              type="button"
              @click="orderError = ''"
              class="btn-close"
            ></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Data
const formData = ref({
  customer_name: '',
  customer_email: '',
  customer_phone: '',
  shipping_address: '',
  billing_address: '',
  payment_method: '',
  notes: '',
});

const formErrors = ref({});
const isSubmitting = ref(false);
const orderSuccess = ref(false);
const orderError = ref('');
const orderNumber = ref('');

// Get cart from the global orderCheckout service
const cartItems = computed(() => window.orderCheckout?.cartItems || []);

// Calculate cart total
const cartTotal = computed(() => {
  return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0);
});

// Methods
const removeItem = (productId, packageId) => {
  window.orderCheckout.removeFromCart(productId, packageId);
};

const updateQuantity = (item) => {
  window.orderCheckout.updateQuantity(item.product_id, item.quantity, item.package_id);
};

const submitOrder = async () => {
  isSubmitting.value = true;
  orderError.value = '';
  orderSuccess.value = false;
  formErrors.value = {};

  try {
    const result = await window.orderCheckout.submitOrder({
      ...formData.value,
      total_amount: cartTotal.value,
    });

    if (result.success) {
      orderSuccess.value = true;
      orderNumber.value = result.data.order_number;

      // Reset form
      resetForm();

      // Redirect after 3 seconds
      setTimeout(() => {
        window.location.href = `/order-success?order=${result.data.order_id}`;
      }, 3000);
    } else {
      if (result.errors && Object.keys(result.errors).length > 0) {
        formErrors.value = result.errors;
      }
      orderError.value = result.message || 'Failed to place order';
    }
  } catch (error) {
    console.error('Checkout error:', error);
    orderError.value = 'An unexpected error occurred. Please try again.';
  } finally {
    isSubmitting.value = false;
  }
};

const resetForm = () => {
  formData.value = {
    customer_name: '',
    customer_email: '',
    customer_phone: '',
    shipping_address: '',
    billing_address: '',
    payment_method: '',
    notes: '',
  };
};
</script>

<style scoped>
.checkout-container {
  background-color: #f8f9fa;
  min-height: 100vh;
}

.card {
  border: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
  border-bottom: 1px solid #dee2e6;
  background-color: #f8f9fa;
}

.form-control:focus,
.form-select:focus {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

button:disabled {
  cursor: not-allowed;
}

.spinner-border {
  width: 1rem;
  height: 1rem;
}
</style>

/**
 * Alternative: React Component Example
 */

/*
import React, { useState, useEffect } from 'react';

const CheckoutComponent = () => {
  const [cartItems, setCartItems] = useState([]);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [orderSuccess, setOrderSuccess] = useState(false);
  const [formData, setFormData] = useState({
    customer_name: '',
    customer_email: '',
    customer_phone: '',
    shipping_address: '',
    billing_address: '',
    payment_method: '',
    notes: '',
  });
  const [formErrors, setFormErrors] = useState({});

  useEffect(() => {
    // Load cart from global orderCheckout service
    if (window.orderCheckout) {
      setCartItems(window.orderCheckout.cartItems);
    }
  }, []);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    setFormErrors({});

    try {
      const result = await window.orderCheckout.submitOrder({
        ...formData,
        total_amount: cartTotal
      });

      if (result.success) {
        setOrderSuccess(true);
        // Redirect after 3 seconds
        setTimeout(() => {
          window.location.href = '/order-success?order=' + result.data.order_id;
        }, 3000);
      } else {
        if (result.errors) {
          setFormErrors(result.errors);
        }
      }
    } catch (error) {
      console.error('Checkout error:', error);
    } finally {
      setIsSubmitting(false);
    }
  };

  const cartTotal = cartItems.reduce((total, item) => 
    total + (item.price * item.quantity), 0
  );

  return (
    // JSX component code here
  );
};

export default CheckoutComponent;
*/
