<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- magnific popup css link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.min.css">

  <!--  Bootstrap CSS link -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- Font Awesome link -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/style.css') }}" />

  <title>Architecture & Interior Design</title>
</head>
<body>

<!-- home section starts -->

  <header class="header fixed-top">
    <a href="/" class="logo">
    <img src="{{url('frontend/images/logo.png')}}" alt="Logo" />
    <span class="brand-name">SpaceAlchemy</span>
  </a>

   <nav>
  <ul>
    <li><a href="/">Home</a></li>
    <li><a href="#service">Services</a></li>
    <li><a href="#project">Projects</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="{{ url('/products') }}">Products</a></li> 
<li class="cart-icon">
  <a href="{{ url('/cart') }}">
    <i class="fas fa-shopping-cart"></i>
    <span id="cart-count">0</span>
  </a>
</li>
<li class="user-icon">
  <a href="{{url('/login')}}">
    <i class="fas fa-user"></i>
  </a>
</li>

  </ul>
</nav>
    
<div class="fas fa-bars"></div>

</header>