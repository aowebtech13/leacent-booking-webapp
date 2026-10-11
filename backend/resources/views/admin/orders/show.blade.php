@extends('layouts.simple.master')

@section('title', 'Order #' . $order->id . ' Details')

@section('css')
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Order #{{ $order->id }} Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-8 box-col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge badge-{{ $order->status === 'completed' || $order->status === 'paid' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p><strong>Payment Status:</strong>
                                    <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' || $order->payment_status === 'refunded' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </p>
                                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                                <p><strong>Currency:</strong> {{ $order->currency ?? 'USD' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Subtotal:</strong> {{ number_format($order->subtotal, 2) }}</p>
                                <p><strong>Tax:</strong> {{ number_format($order->tax, 2) }}</p>
                                <p><strong>Shipping:</strong> {{ number_format($order->shipping_cost, 2) }}</p>
                                <p><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>
                                <p><strong>Amount Paid:</strong> {{ number_format($order->amount_paid ?? 0, 2) }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Billing Details</h5>
                                <p><strong>Name:</strong> {{ $order->billing_name ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $order->billing_phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Customer</h5>
                                <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($order->shipping_address)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Shipping Address</h5>
                                <p>{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                        @endif
                        @if($order->notes)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Notes</h5>
                                <p>{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <p><strong>Created At:</strong> {{ $order->created_at->format('d M, Y H:i') }}</p>
                                @if($order->paid_at)
                                <p><strong>Paid At:</strong> {{ $order->paid_at->format('d M, Y H:i') }}</p>
                                @endif
                                @if($order->payment_verified_at)
                                <p><strong>Verified At:</strong> {{ $order->payment_verified_at->format('d M, Y H:i') }}</p>
                                <p><strong>Verified By:</strong> {{ $order->verifier->name ?? 'N/A' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 box-col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Actions</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100 mb-2">Back to Orders</a>
                        @if($order->payment_receipt)
                        <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="btn btn-info w-100 mb-2">View Receipt</a>
                        @endif
                        @if($order->isPendingVerification())
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verify this payment?')">Verify Payment</button>
                        </form>
                        <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this payment?')">Reject Payment</button>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Update Status</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Order Status</label>
                                <select name="status" class="form-control">
                                    @foreach(\App\Models\Order::validStatuses() as $status)
                                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Add notes..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product->name ?? 'Product #' . $item->product_id }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center f-light">No items found for this order.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
