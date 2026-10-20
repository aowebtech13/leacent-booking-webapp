@extends('layouts.simple.master')

@section('title', 'Receipt - Subscription Payment #' . $payment->id)

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.book-payments.index') }}">Subscription Payments</a></li>
                        <li class="breadcrumb-item active">Receipt #{{ $payment->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="receipt-container">
            <div class="receipt-header">
                <h3>SUBSCRIPTION PAYMENT RECEIPT</h3>
                <p class="order-id">Payment #{{ $payment->id }}</p>
                <p class="text-muted">Date: {{ $payment->created_at->format('F d, Y h:i A') }}</p>
            </div>

            <div class="receipt-section">
                <h6>Payment Details</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span class="receipt-status {{ $payment->status === 'active' ? 'paid' : ($payment->status === 'failed' || $payment->status === 'refunded' ? 'failed' : 'pending') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </p>
                        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'bank_transfer')) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Reference:</strong> {{ $payment->payment_reference ?? 'N/A' }}</p>
                        <p><strong>Plan:</strong> {{ $payment->bookPlan->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="receipt-section">
                <h6>Customer Details</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $payment->user?->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $payment->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Amount Paid:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->currency ?? 'NGN' }}</p>
                        <p><strong>Paid At:</strong> {{ optional($payment->paid_at)->format('F d, Y h:i A') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($payment->payment_receipt && \Illuminate\Support\Facades\Storage::disk('public')->exists($payment->payment_receipt))
            <div class="receipt-section">
                <h6>Payment Receipt</h6>
                <img src="{{ Storage::disk('public')->url($payment->payment_receipt) }}" alt="Payment Receipt" class="receipt-image">
            </div>
            @endif

            @if($payment->notes)
            <div class="receipt-section">
                <h6>Notes</h6>
                <p>{{ $payment->notes }}</p>
            </div>
            @endif

            @if($payment->verified_at)
            <div class="receipt-section">
                <h6>Payment Verification</h6>
                <p><strong>Verified At:</strong> {{ $payment->verified_at->format('F d, Y h:i A') }}</p>
                <p><strong>Verified By:</strong> {{ $payment->verifier?->name ?? 'N/A' }}</p>
                @if($payment->rejection_reason)
                <p><strong>Rejection Reason:</strong> {{ $payment->rejection_reason }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection
