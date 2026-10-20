@extends('layouts.simple.master')

@section('title', 'Subscription Payments')

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Subscription Payments</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Subscription Payments</li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Search &amp; Filter</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.book-payments.index') }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, email or reference" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Subscription Payments</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reference</th>
                                        <th>Customer</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Receipt</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->payment_reference ?? 'N/A' }}</td>
                                        <td>
                                            {{ $payment->user->name ?? 'N/A' }}<br>
                                            <small class="f-light">{{ $payment->user->email ?? '' }}</small>
                                        </td>
                                        <td>{{ $payment->bookPlan->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency ?? 'NGN' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->status === 'active' ? 'success' : ($payment->status === 'failed' || $payment->status === 'refunded' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($payment->payment_receipt)
                                                <a href="{{ route('admin.book-payments.receipt', $payment) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                                            @else
                                                <span class="f-light">Not uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.book-payments.show', $payment) }}" class="btn btn-info btn-sm">Manage</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center f-light">No subscription payments found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $payments->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
