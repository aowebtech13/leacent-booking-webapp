@extends('layouts.simple.master')

@section('title', 'Orders Management')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Orders Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Orders</li>
                        <li class="breadcrumb-item active">Orders Management</li>
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
                        <h4>Search & Filter</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.orders.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, order ID..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="payment_status" class="form-control">
                                        <option value="">All Payments</option>
                                        @foreach($paymentStatuses as $paymentStatus)
                                            <option value="{{ $paymentStatus }}" {{ request('payment_status') === $paymentStatus ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-1">
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
                        <h4>All Orders</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Billing Email</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Total</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ $order->billing_email ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status === 'completed' || $order->status === 'paid' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' || $order->payment_status === 'refunded' ? 'danger' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($order->total, 2) }} {{ $order->currency ?? 'USD' }}</td>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center f-light">No orders found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection
