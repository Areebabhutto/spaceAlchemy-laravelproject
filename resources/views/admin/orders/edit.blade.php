@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Edit Order - {{ $order->order_number }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PUT')

                <!-- Order Status -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" 
                                            {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   value="{{ old('customer_name', $order->customer_name) }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" name="customer_email" id="customer_email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       value="{{ old('customer_email', $order->customer_email) }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Phone</label>
                                <input type="tel" name="customer_phone" id="customer_phone" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone', $order->customer_phone) }}">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Addresses</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3"
                                      class="form-control @error('shipping_address') is-invalid @enderror" 
                                      required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Billing Address</label>
                            <textarea name="billing_address" id="billing_address" rows="3"
                                      class="form-control @error('billing_address') is-invalid @enderror">{{ old('billing_address', $order->billing_address) }}</textarea>
                            <small class="text-muted">Leave empty to use shipping address</small>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Notes</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Internal Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                      class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Save Changes
                    </button>
                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-trash"></i> Delete Order
                        </button>
                    </form>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Order Number:</dt>
                        <dd class="col-sm-6">{{ $order->order_number }}</dd>

                        <dt class="col-sm-6">Date:</dt>
                        <dd class="col-sm-6">{{ $order->created_at->format('M d, Y') }}</dd>

                        <dt class="col-sm-6">Total Items:</dt>
                        <dd class="col-sm-6">{{ $order->items->count() }}</dd>

                        <dt class="col-sm-6">Total Amount:</dt>
                        <dd class="col-sm-6 text-success fw-bold">${{ number_format($order->total_amount, 2) }}</dd>

                        <dt class="col-sm-6">Payment:</dt>
                        <dd class="col-sm-6">{{ $order->payment_method ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Items Preview -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Items</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                                    @if($item->package)
                                        <br><small class="text-muted">{{ $item->package->name }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-light text-dark">{{ $item->quantity }}x</span>
                            </div>
                            <div class="text-end mt-2">
                                <strong>${{ number_format($item->subtotal, 2) }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
