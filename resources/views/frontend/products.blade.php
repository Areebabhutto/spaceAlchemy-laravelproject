@extends('frontend.layouts.main')

@section('main.container')

  <!-- Products Section -->
  <section class="products container mt-5 pt-5">
    <h1 class="heading text-center mb-5">Our Products</h1>
    
    <div class="row g-4">
      
      <!-- Product 1 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=1">
            <img src="{{ asset('frontend/images/sofa.jpg')}}" class="card-img-top" alt="Modern Sofa">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Modern 3-Seater Sofa</h5>
            <p class="card-text">$799</p>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=2">
            <img src="{{ asset('frontend/images/chair.jpg')}}" class="card-img-top" alt="Accent Chair">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Accent Chair</h5>
            <p class="card-text">$199</p>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=3">
            <img src="{{ asset('frontend/images/rug.jpg')}}" class="card-img-top" alt="Area Rug">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Area Rug</h5>
            <p class="card-text">$249</p>
          </div>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=4">
            <img src="{{ asset('frontend/images/walllight.jpg')}}" class="card-img-top" alt="Wall Light">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Decorative Wall Light</h5>
            <p class="card-text">$120</p>
          </div>
        </div>
      </div>

      <!-- Product 5 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=5">
            <img src="{{ asset('frontend/images/curtain.jpg')}}" class="card-img-top" alt="Curtains">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Luxury Curtains</h5>
            <p class="card-text">$99</p>
          </div>
        </div>
      </div>

      <!-- Product 6 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=6">
            <img src="{{ asset('frontend/images/luxsofa.jpg')}}" class="card-img-top" alt="Fabric Sofa">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Fabric Sofa</h5>
            <p class="card-text">$699</p>
          </div>
        </div>
      </div>

      <!-- Product 7 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=7">
            <img src="{{ asset('frontend/images/dining.jpg')}}" class="card-img-top" alt="Dining Chair">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Dining Chair</h5>
            <p class="card-text">$149</p>
          </div>
        </div>
      </div>

      <!-- Product 8 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=8">
            <img src="{{ asset('frontend/images/carpet.jpg')}}" class="card-img-top" alt="Custom Carpet">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Custom Carpet</h5>
            <p class="card-text">$299</p>
          </div>
        </div>
      </div>

      <!-- Product 9 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=9">
            <img src="{{ asset('frontend/images/plant.jpg')}}" class="card-img-top" alt="Plant">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Plant</h5>
            <p class="card-text">$135</p>
          </div>
        </div>
      </div>

      <!-- Product 10 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=10">
            <img src="{{ asset('frontend/images/sidetable.jpg')}}" class="card-img-top" alt="Side Table">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Side Table</h5>
            <p class="card-text">$79</p>
          </div>
        </div>
      </div>

      <!-- Product 11 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=11">
            <img src="{{ asset('frontend/images/mirror.jpg')}}" class="card-img-top" alt="Mirror">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Mirror</h5>
            <p class="card-text">$899</p>
          </div>
        </div>
      </div>

      <!-- Product 12 -->
      <div class="col-md-4">
        <div class="card product-card">
          <a href="{{ url('/product-detail') }}?id=12">
            <img src="{{ asset('frontend/images/officechair.jpg')}}" class="card-img-top" alt="Office Chair">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Office Chair</h5>
            <p class="card-text">$179</p>
          </div>
        </div>
      </div>

    </div>
  </section>

 @endsection