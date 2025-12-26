/**
 * Order Checkout Service
 * Handles checkout flow and saves orders to database via API
 */

class OrderCheckoutService {
    constructor() {
        this.cartItems = this.getCartFromLocalStorage();
        this.apiEndpoint = '/api/orders';
    }

    /**
     * Get cart items from localStorage
     */
    getCartFromLocalStorage() {
        try {
            const cart = localStorage.getItem('cart');
            return cart ? JSON.parse(cart) : [];
        } catch (error) {
            console.error('Error reading cart from localStorage:', error);
            return [];
        }
    }

    /**
     * Save cart to localStorage
     */
    saveCartToLocalStorage(items) {
        try {
            localStorage.setItem('cart', JSON.stringify(items));
            this.cartItems = items;
        } catch (error) {
            console.error('Error saving cart to localStorage:', error);
        }
    }

    /**
     * Add item to cart
     */
    addToCart(product, quantity = 1, packageId = null) {
        const item = {
            product_id: product.id,
            name: product.name,
            price: parseFloat(product.price),
            quantity: quantity,
            package_id: packageId,
            packageName: null,
        };

        const existingItem = this.cartItems.find(
            (i) => i.product_id === product.id && i.package_id === packageId
        );

        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.cartItems.push(item);
        }

        this.saveCartToLocalStorage(this.cartItems);
        console.log('Item added to cart:', item);
        return item;
    }

    /**
     * Remove item from cart
     */
    removeFromCart(productId, packageId = null) {
        this.cartItems = this.cartItems.filter(
            (item) => !(item.product_id === productId && item.package_id === packageId)
        );
        this.saveCartToLocalStorage(this.cartItems);
    }

    /**
     * Update item quantity
     */
    updateQuantity(productId, quantity, packageId = null) {
        const item = this.cartItems.find(
            (i) => i.product_id === productId && i.package_id === packageId
        );
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.saveCartToLocalStorage(this.cartItems);
        }
    }

    /**
     * Calculate cart total
     */
    getCartTotal() {
        return this.cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
    }

    /**
     * Get cart items count
     */
    getCartItemsCount() {
        return this.cartItems.reduce((count, item) => count + item.quantity, 0);
    }

    /**
     * Clear cart
     */
    clearCart() {
        this.cartItems = [];
        localStorage.removeItem('cart');
    }

    /**
     * Validate checkout form
     */
    validateCheckoutForm(formData) {
        const errors = {};

        if (!formData.customer_name || formData.customer_name.trim() === '') {
            errors.customer_name = 'Customer name is required';
        }

        if (!formData.customer_email || formData.customer_email.trim() === '') {
            errors.customer_email = 'Email is required';
        } else if (!this.isValidEmail(formData.customer_email)) {
            errors.customer_email = 'Invalid email format';
        }

        if (!formData.shipping_address || formData.shipping_address.trim() === '') {
            errors.shipping_address = 'Shipping address is required';
        }

        if (this.cartItems.length === 0) {
            errors.cart = 'Cart is empty';
        }

        return { valid: Object.keys(errors).length === 0, errors };
    }

    /**
     * Validate email format
     */
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Submit order to API
     */
    async submitOrder(formData) {
        // Validate form
        const validation = this.validateCheckoutForm(formData);
        if (!validation.valid) {
            return {
                success: false,
                errors: validation.errors,
                message: 'Please fix validation errors',
            };
        }

        // Prepare order data
        const orderData = {
            customer_name: formData.customer_name,
            customer_email: formData.customer_email,
            customer_phone: formData.customer_phone || null,
            shipping_address: formData.shipping_address,
            billing_address: formData.billing_address || formData.shipping_address,
            payment_method: formData.payment_method || null,
            total_amount: this.getCartTotal(),
            items: this.cartItems.map((item) => ({
                product_id: item.product_id,
                package_id: item.package_id,
                quantity: item.quantity,
                price: item.price,
            })),
            notes: formData.notes || null,
        };

        try {
            const response = await fetch(this.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                },
                body: JSON.stringify(orderData),
            });

            const data = await response.json();

            if (response.ok) {
                // Clear cart after successful order
                this.clearCart();
                return {
                    success: true,
                    message: 'Order placed successfully!',
                    data: data.data,
                };
            } else {
                return {
                    success: false,
                    message: data.message || 'Failed to create order',
                    errors: data.errors || {},
                };
            }
        } catch (error) {
            console.error('Order submission error:', error);
            return {
                success: false,
                message: 'Network error. Please try again.',
            };
        }
    }

    /**
     * Get CSRF token from meta tag or cookie
     */
    getCsrfToken() {
        // Try to get from meta tag
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            return token.getAttribute('content');
        }

        // Try to get from cookie
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            cookie = cookie.trim();
            if (cookie.startsWith('XSRF-TOKEN=')) {
                return decodeURIComponent(cookie.substring('XSRF-TOKEN='.length));
            }
        }

        return '';
    }

    /**
     * Get user's orders (requires authentication)
     */
    async getUserOrders() {
        try {
            const response = await fetch(this.apiEndpoint, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${this.getAuthToken()}`,
                },
            });

            if (response.ok) {
                const data = await response.json();
                return {
                    success: true,
                    data: data.data,
                };
            } else {
                return {
                    success: false,
                    message: 'Failed to fetch orders',
                };
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
            return {
                success: false,
                message: 'Network error',
            };
        }
    }

    /**
     * Get authentication token from localStorage
     */
    getAuthToken() {
        return localStorage.getItem('auth_token') || '';
    }
}

// Initialize and export
const orderCheckout = new OrderCheckoutService();

// Make it global for HTML onclick handlers if needed
window.orderCheckout = orderCheckout;
