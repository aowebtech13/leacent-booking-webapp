@extends('layouts.simple.master')

@section('title', 'Subscription Payment #' . $payment->id)

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Subscription Payment #{{ $payment->id }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.book-payments.index') }}">Subscription Payments</a></li>
                        <li class="breadcrumb-item active">#{{ $payment->id }}</li>
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
                        <h4>Payment Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment ID:</strong> #{{ $payment->id }}</p>
                                <p><strong>Reference:</strong> {{ $payment->payment_reference ?? 'N/A' }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge badge-{{ $payment->status === 'active' ? 'success' : ($payment->status === 'failed' || $payment->status === 'refunded' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'bank_transfer')) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Plan:</strong> {{ $payment->bookPlan->name ?? 'N/A' }}</p>
                                <p><strong>Amount:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->currency ?? 'NGN' }}</p>
                                <p><strong>Access Duration:</strong> {{ $payment->bookPlan->access_duration_days ?? 0 }} days</p>
                                <p><strong>Books Included:</strong> {{ $payment->bookPlan->unlimited_books ? 'Unlimited' : ($payment->bookPlan->book_limit ?? 0) }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Customer</h5>
                                <p><strong>Name:</strong> {{ $payment->user->name ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $payment->user->email ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $payment->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Timeline</h5>
                                <p><strong>Created At:</strong> {{ $payment->created_at->format('d M, Y H:i') }}</p>
                                @if($payment->paid_at)
                                <p><strong>Paid At:</strong> {{ $payment->paid_at->format('d M, Y H:i') }}</p>
                                @endif
                                @if($payment->verified_at)
                                <p><strong>Verified At:</strong> {{ $payment->verified_at->format('d M, Y H:i') }}</p>
                                <p><strong>Verified By:</strong> {{ $payment->verifier?->name ?? 'N/A' }}</p>
                                @endif
                            </div>
                        </div>
                        @if($payment->notes)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Customer Notes</h5>
                                <p>{{ $payment->notes }}</p>
                            </div>
                        </div>
                        @endif
                        @if($payment->rejection_reason)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Rejection Reason</h5>
                                <p class="text-danger">{{ $payment->rejection_reason }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 box-col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Actions</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.book-payments.index') }}" class="btn btn-secondary w-100 mb-2">Back to Payments</a>
                        @if($payment->payment_receipt)
                        <a href="{{ route('admin.book-payments.receipt', $payment) }}" target="_blank" class="btn btn-info w-100 mb-2">View Receipt</a>
                        @endif
                        @if($payment->status === 'pending')
                        <form action="{{ route('admin.book-payments.verify', $payment) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Add notes..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verify this payment and activate the subscription?')">Verify Payment</button>
                        </form>
                        <form action="{{ route('admin.book-payments.reject', $payment) }}" method="POST" class="mb-2">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Rejection Reason</label>
                                <textarea name="rejection_reason" class="form-control" rows="2" placeholder="Why is this payment rejected?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this payment?')">Reject Payment</button>
                        </form>
                        @else
                        <p class="f-light">This payment has already been processed.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
