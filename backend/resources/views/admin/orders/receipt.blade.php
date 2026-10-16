@extends('layouts.simple.master')

@section('title', 'Receipt - Order #' . $order->id)

@section('css')
    <style>
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .receipt-header h3 {
            margin-bottom: 5px;
        }
        .receipt-header .order-id {
            font-size: 1.1rem;
            color: #6c757d;
        }
        .receipt-section {
            margin-bottom: 20px;
        }
        .receipt-section h6 {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-table th,
        .receipt-table td {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
        }
        .receipt-table th {
            background-color: #f8f9fa;
            text-align: left;
        }
        .receipt-table td.text-end {
            text-align: right;
        }
        .receipt-total {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
            padding: 10px 0;
        }
        .receipt-status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .receipt-status.paid {
            background-color: #d4edda;
            color: #155724;
        }
        .receipt-status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .receipt-status.failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            color: #6c757d;
        }
        .receipt-image {
            max-width: 100%;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Payment Receipt</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Receipt #{{ $order->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="receipt-container">
            {{-- Header --}}
            <div class="receipt-header">
                <h3>Mictomon TailorPAYMENT RECEIPT</h3>
                <p class="order-id">Order #{{ $order->id }}</p>
                <p class="text-muted">Date: {{ $order->created_at->format('F d, Y h:i A') }}</p>
            </div>

            {{-- Order Status --}}
            <div class="receipt-section">
                <h6>Order Status</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span class="receipt-status {{ $order->status === 'paid' || $order->status === 'completed' ? 'paid' : ($order->status === 'cancelled' ? 'failed' : 'pending') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Payment Status:</strong>
                            <span class="receipt-status {{ $order->payment_status === 'paid' ? 'paid' : ($order->payment_status === 'failed' || $order->payment_status === 'refunded' ? 'failed' : 'pending') }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                        @if($order->payment_reference)
                            <p><strong>Reference:</strong> {{ $order->payment_reference }}</p>
                        @endif
                        @if($order->flutterwave_tx_ref)
                            <p><strong>Flutterwave TX Ref:</strong> {{ $order->flutterwave_tx_ref }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Customer Details --}}
            <div class="receipt-section">
                <h6>Customer Details</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $order->billing_name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $order->billing_phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> {{ $order->user?->name ?? 'N/A' }}</p>
                        <p><strong>User Email:</strong> {{ $order->user?->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            @if($order->shipping_address)
            <div class="receipt-section">
                <h6>Shipping Address</h6>
                <p>{{ $order->shipping_address }}</p>
            </div>
            @endif

            {{-- Order Items --}}
            <div class="receipt-section">
                <h6>Order Items</h6>
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name ?? 'Product #' . $item->product_id }}</td>
                            <td class="text-end">₦{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">₦{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="receipt-section">
                <table class="receipt-table" style="width: 50%; margin-left: auto;">
                    <tr>
                        <td><strong>Subtotal</strong></td>
                        <td class="text-end">₦{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tax</strong></td>
                        <td class="text-end">₦{{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Shipping</strong></td>
                        <td class="text-end">₦{{ number_format($order->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-end"><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Amount Paid</strong></td>
                        <td class="text-end"><strong>₦{{ number_format($order->amount_paid ?? $order->total, 2) }}</strong></td>
                    </tr>
                </table>
            </div>

            {{-- Payment Receipt Image --}}
            @if($order->payment_receipt && \Illuminate\Support\Facades\Storage::disk('public')->exists($order->payment_receipt))
            <div class="receipt-section">
                <h6>Payment Receipt</h6>
                <img src="{{ Storage::disk('public')->url($order->payment_receipt) }}" alt="Payment Receipt" class="receipt-image">
            </div>
            @endif

            {{-- Notes --}}
            @if($order->notes)
            <div class="receipt-section">
                <h6>Notes</h6>
                <p>{{ $order->notes }}</p>
            </div>
            @endif

            {{-- Verification Info --}}
            @if($order->verified_at)
            <div class="receipt-section">
                <h6>Payment Verification</h6>
                <p><strong>Verified At:</strong> {{ $order->verified_at->format('F d, Y h:i A') }}</p>
                <p><strong>Verified By:</strong> {{ $order->verifier?->name ?? 'N/A' }}</p>
                @if($order->payment_rejection_reason)
                <p><strong>Rejection Reason:</strong> {{ $order->payment_rejection_reason }}</p>
                @endif
            </div>
            @endif

            {{-- Footer --}}
            <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-print the receipt when the page loads
        window.addEventListener('load', function() {
            // Optional: uncomment the line below to auto-print
            // window.print();
        });
    </script>
@endsection