$(document).ready(function(){

  $('.fa-bars').click(function(){
    $(this).toggleClass('fa-times');
    $('nav').toggleClass('nav-toggle');
  });

  $(window).on('scroll load',function(){
    $('.fa-bars').removeClass('fa-times');
    $('nav').removeClass('nav-toggle');
  });

  $('.count').each(function() {
    var $this = $(this),
        countTo = $this.attr('data-count');
    $({ countNum: $this.text()}).animate({
      countNum: countTo
    },
    {
      duration: 5000,
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum + '+');
      }
    });
  });

  $('.project').magnificPopup({
    delegate:'a',
    type:'image',
    gallery:{
      enabled:true
    }
  });

});
/*
// ---------------------- NAVBAR TOGGLE (converted from jQuery) ----------------------
document.addEventListener("DOMContentLoaded", () => {
  const menuIcon = document.querySelector(".fa-bars");
  const nav = document.querySelector("nav");

  if (menuIcon && nav) {
    menuIcon.addEventListener("click", () => {
      menuIcon.classList.toggle("fa-times");
      nav.classList.toggle("nav-toggle");
    });

    const closeMenu = () => {
      menuIcon.classList.remove("fa-times");
      nav.classList.remove("nav-toggle");
    };

    window.addEventListener("scroll", closeMenu);
    window.addEventListener("load", closeMenu);
  }

  // ---------------------- COUNTER ANIMATION (converted from jQuery) ----------------------
  const counters = document.querySelectorAll(".count");
  counters.forEach(counter => {
    const target = +counter.getAttribute("data-count");
    let count = 0;
    const duration = 5000; // matches your original animation speed
    const increment = target / (duration / 16);

    const updateCount = () => {
      count += increment;
      if (count < target) {
        counter.textContent = Math.floor(count);
        requestAnimationFrame(updateCount);
      } else {
        counter.textContent = target + "+";
      }
    };

    updateCount();
  });

  // ---------------------- IMAGE POPUP (replacing $('.project').magnificPopup) ----------------------
  
  const projectLinks = document.querySelectorAll(".project a");

  projectLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const imgSrc = link.getAttribute("href");
      const overlay = document.createElement("div");
      overlay.classList.add("popup-overlay");
      overlay.innerHTML = `
        <div class="popup-content">
          <img src="${imgSrc}" alt="Project Image" />
        </div>
      `;
      document.body.appendChild(overlay);

      overlay.addEventListener("click", () => {
        document.body.removeChild(overlay);
      });
    });
  });
});
*/

// ---------------------- CART FUNCTIONALITY ----------------------
const cartCount = document.getElementById("cart-count");
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartCount() {
  if (cartCount) {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
  }
}
updateCartCount();

// ---------------------- PRODUCT PAGE ----------------------
const addToCartButtons = document.querySelectorAll(".add-to-cart");

addToCartButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    const card = e.target.closest(".card");
    const title = card.querySelector(".card-title").textContent;
    const price = parseFloat(card.querySelector(".card-text").textContent.replace("$", ""));
    const image = card.querySelector("img").src;
    const qtyInput = card.querySelector(".qty-input");
    const quantity = parseInt(qtyInput.value) || 1;

    const existingItem = cart.find((item) => item.title === title);
    if (existingItem) {
      existingItem.quantity += quantity;
    } else {
      cart.push({ title, price, image, quantity });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(`${title} added to cart!`);
  });
});


// ---------------------- CART PAGE ----------------------
// 🛒 CART PAGE SCRIPT — Compatible with old structure
function renderCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartItemsContainer = document.getElementById('cart-items');
  const cartTotalElement = document.getElementById('cart-total');

  if (!cartItemsContainer) return;

  cartItemsContainer.innerHTML = '';
  let total = 0;

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = `
      <tr><td colspan="6" class="text-center py-4">Your cart is empty!</td></tr>
    `;
    document.querySelector(".cart-summary")?.classList.add("d-none");
    return;
  } else {
    document.querySelector(".cart-summary")?.classList.remove("d-none");
  }

  cart.forEach((item, index) => {
    const itemName = item.title || item.name || "Unnamed Product";
    const itemImage = item.image
      ? (item.image.includes('/frontend/') ? item.image : '/frontend/' + item.image)
      : '/frontend/images/default.jpg';
    const itemPrice = parseFloat(item.price) || 0;
    const itemQty = parseInt(item.quantity) || 1;
    const itemTotal = itemPrice * itemQty;
    total += itemTotal;

    const row = `
      <tr>
        <td><img src="${itemImage}" alt="${itemName}" class="cart-img"></td>
        <td>${itemName}</td>
        <td>$${itemPrice.toFixed(2)}</td>
        <td>
          <div class="quantity-control">
            <button class="decrement" data-index="${index}">-</button>
            <input type="text" value="${itemQty}" readonly>
            <button class="increment" data-index="${index}">+</button>
          </div>
        </td>
        <td>$${itemTotal.toFixed(2)}</td>
        <td><button class="btn-remove" data-index="${index}">Remove</button></td>
      </tr>
    `;
    cartItemsContainer.insertAdjacentHTML('beforeend', row);
  });

  cartTotalElement.textContent = total.toFixed(2);

  document.querySelectorAll('.increment').forEach(btn =>
    btn.addEventListener('click', incrementQty)
  );
  document.querySelectorAll('.decrement').forEach(btn =>
    btn.addEventListener('click', decrementQty)
  );
  document.querySelectorAll('.btn-remove').forEach(btn =>
    btn.addEventListener('click', removeItem)
  );
}

function incrementQty(e) {
  const index = e.target.dataset.index;
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart[index].quantity++;
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}

function decrementQty(e) {
  const index = e.target.dataset.index;
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  if (cart[index].quantity > 1) {
    cart[index].quantity--;
  } else {
    cart.splice(index, 1);
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}

function removeItem(e) {
  const index = e.target.dataset.index;
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  renderCart();
}

//  Clear Cart
document.getElementById('clear-cart')?.addEventListener('click', () => {
  localStorage.removeItem('cart');
  renderCart();
});

//  Initialize on page load
document.addEventListener('DOMContentLoaded', renderCart);



// ---------------------- CHECKOUT ----------------------
const checkoutBtn = document.getElementById("checkout-btn");
if (checkoutBtn) {
  checkoutBtn.addEventListener("click", () => {
    window.location.href = "/checkout"; 
  });
}

// ---------------------- CHECKOUT PAGE ----------------------
document.addEventListener("DOMContentLoaded", () => {
  const checkoutItems = document.getElementById("checkoutItems");
  const checkoutTotal = document.getElementById("checkoutTotal");
  const checkoutForm = document.getElementById("checkoutForm");
  const confirmationMessage = document.getElementById("confirmationMessage");

  if (checkoutItems && checkoutTotal && checkoutForm) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {
      checkoutItems.innerHTML = "<p>Your cart is empty.</p>";
      checkoutForm.style.display = "none";
    } else {
      cart.forEach((item) => {
        const safeImagePath = item.image.includes('/frontend/') ? item.image : '/frontend/' + item.image;
        const div = document.createElement("div");
        div.classList.add("checkout-item");
        div.innerHTML = `
          <div class="checkout-item">
            <img src="${safeImagePath}" alt="${item.title}" style="width:50px; height:50px; border-radius:6px; margin-right:10px;">
            <span>${item.title} - ${item.quantity} × $${item.price}</span>
          </div>
        `;
        checkoutItems.appendChild(div);
      });

      const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
      checkoutTotal.textContent = total.toFixed(2);
    }

    checkoutForm.addEventListener("submit", (e) => {
      e.preventDefault();

      // Hide form and show confirmation
      checkoutForm.style.display = "none";
      confirmationMessage.style.display = "block";

      // Clear cart
      localStorage.removeItem("cart");
    });
  }
});




// ---------------------- PRODUCT DETAILS + REVIEWS ----------------------
const products = [
  {id: 1, name: "Modern 3-Seater Sofa", price: "$799", image: "images/sofa.jpg", desc: "A comfortable modern sofa perfect for your living space. Designed with premium cushions for ultimate relaxation. Its sleek design effortlessly complements any contemporary interior."},
  {id: 2, name: "Accent Chair", price: "$199", image: "images/chair.jpg", desc: "Elegant accent chair for stylish interiors. Crafted with high-quality materials for durability and comfort. Ideal for reading corners or adding a chic touch to your living room."},
  {id: 3, name: "Area Rug", price: "$249", image: "images/rug.jpg", desc: "Soft and elegant area rug to complement your decor. Its intricate patterns add warmth and style to any room. Perfect for living rooms, bedrooms, or hallways."},
  {id: 4, name: "Decorative Wall Light", price: "$120", image: "images/walllight.jpg", desc: "Add charm to your walls with this decorative wall light. Provides ambient lighting while enhancing your interior aesthetic. A perfect blend of function and style."},
  {id: 5, name: "Luxury Curtains", price: "$99", image: "images/curtain.jpg", desc: "Premium fabric curtains to elevate your interiors. They offer both privacy and a sophisticated look. Available in versatile designs to match any decor theme."},
  {id: 6, name: "Fabric Sofa", price: "$699", image: "images/luxsofa.jpg", desc: "A luxurious fabric sofa built for comfort and elegance. Its plush seating ensures relaxation after a long day. Ideal for living rooms or entertainment spaces."},
  {id: 7, name: "Dining Chair", price: "$149", image: "images/dining.jpg", desc: "Stylish dining chair crafted with premium wood and cushioned seating. Adds sophistication to your dining area. Comfortable enough for long family meals or gatherings."},
  {id: 8, name: "Custom Carpet", price: "$299", image: "images/carpet.jpg", desc: "Custom-designed carpet that brings sophistication to your floor. Soft to touch and durable for daily use. A perfect statement piece for modern interiors."},
  {id: 9, name: "Indoor Plant", price: "$135", image: "images/plant.jpg", desc: "Add a touch of green with this beautiful decorative indoor plant. Improves air quality and livens up any room. Easy to maintain and perfect for home or office."},
  {id: 10, name: "Side Table", price: "$79", image: "images/sidetable.jpg", desc: "A compact and elegant wooden side table for any corner. Ideal for holding drinks, books, or decor items. Blends effortlessly with modern and classic interiors alike."},
  {id: 11, name: "Wall Mirror", price: "$899", image: "images/mirror.jpg", desc: "A stunning decorative mirror that adds brightness to your space."},
  {id: 12, name: "Office Chair", price: "$179", image: "images/officechair.jpg", desc: "Ergonomic office chair designed for long hours of comfort. Adjustable features ensure proper posture support. Ideal for home offices or professional workspaces."}
];

const urlParams = new URLSearchParams(window.location.search);
const productId = parseInt(urlParams.get('id'));
const product = products.find(p => p.id === productId);

if (product) {
    // 💡 CRITICAL FIX: Prepend the Laravel public folder structure
    document.getElementById("productImage").src = '/frontend/' + product.image;
    document.getElementById("productName").textContent = product.name;
    document.getElementById("productPrice").textContent = product.price;
    document.getElementById("productDesc").textContent = product.desc;
}

const qtyInput = document.getElementById("detailQty");
const incrementBtn = document.querySelector(".increment");
const decrementBtn = document.querySelector(".decrement");

if (qtyInput && incrementBtn && decrementBtn) {
  incrementBtn.addEventListener("click", () => qtyInput.value++);
  decrementBtn.addEventListener("click", () => {
    if (qtyInput.value > 1) qtyInput.value--;
  });
}

const reviewForm = document.getElementById("reviewForm");
const reviewList = document.getElementById("reviewList");
const reviewsKey = "reviews_" + productId;
const reviews = JSON.parse(localStorage.getItem(reviewsKey)) || [];

function renderReviews() {
  if (!reviewList) return; // ✅ Prevents error if not on product page
  reviewList.innerHTML = reviews.length
    ? reviews.map(r => `<p><strong>${r.name}:</strong> ${r.text}</p>`).join("")
    : "<p>No reviews yet. Be the first to review!</p>";
}

if (reviewForm) {
  reviewForm.addEventListener("submit", e => {
    e.preventDefault();
    const newReview = {
    name: document.getElementById("reviewName").value,
      text: document.getElementById("reviewText").value
    };
    reviews.push(newReview);
    localStorage.setItem(reviewsKey, JSON.stringify(reviews));
    renderReviews();
    reviewForm.reset();
  });
}

renderReviews();


const addToCartDetailBtn = document.getElementById("addToCartDetail");
if (addToCartDetailBtn && product) {
  addToCartDetailBtn.addEventListener("click", () => {
    const quantity = parseInt(document.getElementById("detailQty").value) || 1;
    const title = product.name;
    const price = parseFloat(product.price.replace("$", ""));
    const image = product.image;

    const existingItem = cart.find((item) => item.title === title);
    if (existingItem) {
      existingItem.quantity += quantity;
    } else {
      cart.push({ title, price, image, quantity });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(`${title} added to cart!`);
  });
}


/*$(document).ready(function(){

  $('.fa-bars').click(function(){
    $(this).toggleClass('fa-times');
    $('nav').toggleClass('nav-toggle');
  });

  $(window).on('scroll load',function(){
    $('.fa-bars').removeClass('fa-times');
    $('nav').removeClass('nav-toggle');
  });

  $('.count').each(function() {
    var $this = $(this),
        countTo = $this.attr('data-count');
    $({ countNum: $this.text()}).animate({
      countNum: countTo
    },
    {
      duration: 5000,
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum + '+');
      }
    });
  });

  $('.project').magnificPopup({
    delegate:'a',
    type:'image',
    gallery:{
      enabled:true
    }
  });

});










// ---------------------- CART FUNCTIONALITY ----------------------

// Select cart count display
const cartCount = document.getElementById("cart-count");

// Load existing cart from localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Update cart icon count
function updateCartCount() {
  if (cartCount) {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
  }
}
updateCartCount();

// ---------------------- PRODUCT PAGE ----------------------
const addToCartButtons = document.querySelectorAll(".add-to-cart");

addToCartButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    const card = e.target.closest(".card");
    const title = card.querySelector(".card-title").textContent;
    const price = parseFloat(card.querySelector(".card-text").textContent.replace("$", ""));
    const image = card.querySelector("img").src;
    const qtyInput = card.querySelector(".qty-input");
    const quantity = parseInt(qtyInput.value) || 1;

    // Check if product already exists in cart
    const existingItem = cart.find((item) => item.title === title);
    if (existingItem) {
      existingItem.quantity += quantity;
    } else {
      cart.push({ title, price, image, quantity });
    }

    // Save updated cart
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(`${title} added to cart!`);
  });
});

// ---------------------- CART PAGE ----------------------
const cartItemsContainer = document.getElementById("cart-items");
const cartTotal = document.getElementById("cart-total");

if (cartItemsContainer) {
  displayCartItems();
}

function displayCartItems() {
  cartItemsContainer.innerHTML = "";
  let total = 0;

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = "<p class='text-center'>Your cart is empty!</p>";
    document.querySelector(".cart-summary").style.display = "none";
    return;
  }

  cart.forEach((item, index) => {
    total += item.price * item.quantity;

    const itemHTML = `
      <div class="col-md-4">
        <div class="card">
          <img src="${item.image}" class="card-img-top" alt="${item.title}">
          <div class="card-body text-center">
            <h5 class="card-title">${item.title}</h5>
            <p class="card-text">$${item.price} x ${item.quantity}</p>
            <p><strong>Subtotal: $${item.price * item.quantity}</strong></p>
            <button class="btn btn-danger remove-item" data-index="${index}">Remove</button>
          </div>
        </div>
      </div>
    `;
    cartItemsContainer.innerHTML += itemHTML;
  });

  cartTotal.textContent = total.toFixed(2);

  // Attach remove button functionality
  document.querySelectorAll(".remove-item").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const index = e.target.getAttribute("data-index");
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      displayCartItems();
      updateCartCount();
    });
  });
}

// ---------------------- CLEAR CART ----------------------
const clearCartBtn = document.getElementById("clear-cart");
if (clearCartBtn) {
  clearCartBtn.addEventListener("click", () => {
    if (confirm("Are you sure you want to clear the cart?")) {
      localStorage.removeItem("cart");
      cart = [];
      displayCartItems();
      updateCartCount();
    }
  });
}

// ---------------------- CHECKOUT ----------------------
const checkoutBtn = document.getElementById("checkout-btn");
if (checkoutBtn) {
  checkoutBtn.addEventListener("click", () => {
    // Navigate to checkout page
    window.location.href = "checkout.html";
  });
}


// ---------------------- QUANTITY BUTTONS ----------------------
document.querySelectorAll(".increment").forEach((btn) => {
  btn.addEventListener("click", () => {
    const input = btn.parentElement.querySelector(".qty-input");
    input.value = parseInt(input.value || 1) + 1;
  });
});

document.querySelectorAll(".decrement").forEach((btn) => {
  btn.addEventListener("click", () => {
    const input = btn.parentElement.querySelector(".qty-input");
    if (parseInt(input.value || 1) > 1) {
      input.value = parseInt(input.value) - 1;
    }
  });
});














document.addEventListener("DOMContentLoaded", () => {
  const checkoutItems = document.getElementById("checkoutItems");
  const checkoutTotal = document.getElementById("checkoutTotal");
  const checkoutForm = document.getElementById("checkoutForm");
  const confirmationMessage = document.getElementById("confirmationMessage");

  // Get cart data
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Display cart items
  if (cart.length === 0) {
    checkoutItems.innerHTML = "<p>Your cart is empty.</p>";
  } else {
    cart.forEach((item) => {
      const div = document.createElement("div");
      div.classList.add("checkout-item");
      div.innerHTML = `
      <div class="checkout-item">
  <img src="${item.image}" alt="${item.title}" style="width:50px; height:50px; border-radius:6px; margin-right:10px;">
  <span>${item.title} - ${item.quantity} × $${item.price}</span>
</div>

      `;
      checkoutItems.appendChild(div);
    });

    // Calculate total
    const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    checkoutTotal.textContent = total.toFixed(2);
  }

 checkoutForm.addEventListener("submit", (e) => {
  e.preventDefault();

  // Clear the cart after order
  localStorage.removeItem("cart");

  // Show success message
  alert("✅ Your order has been placed successfully!\nThank you for shopping with us.");

  // Optionally redirect back to home or services page
  window.location.href = "index.html"; // change this to your homepage if different
});

});












    // Simple product data (you can extend it later)
   const products = [
  {id: 1, name: "Modern 3-Seater Sofa", price: "$799", image: "images/sofa.jpg", desc: "A comfortable modern sofa perfect for your living space."},
  {id: 2, name: "Accent Chair", price: "$199", image: "images/chair.jpg", desc: "Elegant accent chair for stylish interiors."},
  {id: 3, name: "Area Rug", price: "$249", image: "images/rug.jpg", desc: "Soft and elegant area rug to complement your decor."},
  {id: 4, name: "Decorative Wall Light", price: "$120", image: "images/walllight.jpg", desc: "Add charm to your walls with this decorative wall light."},
  {id: 5, name: "Luxury Curtains", price: "$99", image: "images/curtain.jpg", desc: "Premium fabric curtains to elevate your interiors."},
  {id: 6, name: "Fabric Sofa", price: "$699", image: "images/luxsofa.jpg", desc: "A luxurious fabric sofa built for comfort and elegance."},
  {id: 7, name: "Dining Chair", price: "$149", image: "images/dining.jpg", desc: "Stylish dining chair crafted with premium wood and cushion."},
  {id: 8, name: "Custom Carpet", price: "$299", image: "images/carpet.jpg", desc: "Custom-designed carpet that brings sophistication to your floor."},
  {id: 9, name: "Indoor Plant", price: "$135", image: "images/plant.jpg", desc: "Add a touch of green with this beautiful decorative indoor plant."},
  {id: 10, name: "Side Table", price: "$79", image: "images/sidetable.jpg", desc: "A compact and elegant wooden side table for any corner."},
  {id: 11, name: "Wall Mirror", price: "$899", image: "images/mirror.jpg", desc: "A stunning decorative mirror that adds brightness to your space."},
  {id: 12, name: "Office Chair", price: "$179", image: "images/officechair.jpg", desc: "Ergonomic office chair designed for long hours of comfort."}
];

    // Get product ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = parseInt(urlParams.get('id'));
    const product = products.find(p => p.id === productId);

    // Load product details
    if (product) {
      document.getElementById("productImage").src = product.image;
      document.getElementById("productName").textContent = product.name;
      document.getElementById("productPrice").textContent = product.price;
      document.getElementById("productDesc").textContent = product.desc;
    }

    // Quantity buttons
   const qtyInput = document.getElementById("detailQty");
const incrementBtn = document.querySelector(".increment");
const decrementBtn = document.querySelector(".decrement");

if (qtyInput && incrementBtn && decrementBtn) {
  incrementBtn.addEventListener("click", () => qtyInput.value++);
  decrementBtn.addEventListener("click", () => {
    if (qtyInput.value > 1) qtyInput.value--;
  });
}

    // Review Section Logic
    const reviewForm = document.getElementById("reviewForm");
    const reviewList = document.getElementById("reviewList");
    const reviewsKey = "reviews_" + productId;
    const reviews = JSON.parse(localStorage.getItem(reviewsKey)) || [];

    function renderReviews() {
      reviewList.innerHTML = reviews.length
        ? reviews.map(r => `<p><strong>${r.name}:</strong> ${r.text}</p>`).join("")
        : "<p>No reviews yet. Be the first to review!</p>";
    }

    reviewForm.addEventListener("submit", e => {
      e.preventDefault();
      const newReview = {
        name: document.getElementById("reviewName").value,
        text: document.getElementById("reviewText").value
      };
      reviews.push(newReview);
      localStorage.setItem(reviewsKey, JSON.stringify(reviews));
      renderReviews();
      reviewForm.reset();
    });

    renderReviews();



    // ---------------------- ADD TO CART (DETAIL PAGE) ----------------------
const addToCartDetailBtn = document.getElementById("addToCartDetail");

if (addToCartDetailBtn && product) {
  addToCartDetailBtn.addEventListener("click", () => {
    const quantity = parseInt(document.getElementById("detailQty").value) || 1;
    const title = product.name;
    const price = parseFloat(product.price.replace("$", ""));
    const image = product.image;

    // Check if product already exists in cart
    const existingItem = cart.find((item) => item.title === title);
    if (existingItem) {
      existingItem.quantity += quantity;
    } else {
      cart.push({ title, price, image, quantity });
    }

    // Save and update
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(`${title} added to cart!`);
  });
}
*/