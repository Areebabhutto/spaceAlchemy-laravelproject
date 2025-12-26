@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">{{ $order->order_number }}</h1>
            <p class="text-muted">Order details</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Order Info -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Status:</label>
                        <div class="col-sm-8">
                            <span class="badge bg-{{ $order->status_badge['color'] }} p-2">
                                {{ $order->status_badge['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Order Date:</label>
                        <div class="col-sm-8">
                            <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Total Amount:</label>
                        <div class="col-sm-8">
                            <strong class="text-success fs-5">${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Payment Method:</label>
                        <div class="col-sm-8">
                            <span>{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Name:</label>
                        <div class="col-sm-8">
                            <span>{{ $order->customer_name }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Email:</label>
                        <div class="col-sm-8">
                            <a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label text-muted">Phone:</label>
                        <div class="col-sm-8">
                            <span>{{ $order->customer_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @if($order->user)
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-muted">User:</label>
                            <div class="col-sm-8">
                                <a href="#">{{ $order->user->name }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Shipping Address -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <p class="text-break">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Billing Address</h5>
                </div>
                <div class="card-body">
                    <p class="text-break">{{ $order->billing_address ?? 'Same as shipping' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Order Items ({{ $order->items->count() }})</h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Package</th>
                        <th>Quantity</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                {{ $item->package->name ?? '-' }}
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                            <td class="text-end"><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                    @endforeach
                    <tr class="table-light fw-bold">
                        <td colspan="4" class="text-end">Total:</td>
                        <td class="text-end text-success fs-5">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notes -->
    @if($order->notes)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Notes</h5>
            </div>
            <div class="card-body">
                <p>{{ $order->notes }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
