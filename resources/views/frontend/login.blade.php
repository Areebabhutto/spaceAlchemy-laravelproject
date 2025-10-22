@extends('frontend.layouts.main')

@section('main.container')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 100px;">
  
  <div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-3">Login</h3>
    <form>
      <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-dark w-100">Login</button>
      <p class="text-center mt-3">Don’t have an account? <a href="{{ url('/signup')}}">Sign Up</a></p>
    </form>
  </div>

</div>

@endsection



