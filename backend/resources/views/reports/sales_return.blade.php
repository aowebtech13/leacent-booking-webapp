@extends('layouts.simple.master')

@section('title', 'Payment Management')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/autoFill.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/keyTable.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/fixedHeader.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/rowReorder.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select/bootstrap-select.min.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Payment Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Reports</li>
                        <li class="breadcrumb-item active">Payment Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid sale-return-wrapper">
        {{-- Payment Verification Panel --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment Verification</h4>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa-solid fa-gear fa-spin"></i></li>
                                <li><i class="view-html fa-solid fa-code"></i></li>
                                <li><i class="icofont icofont-maximize full-card"></i></li>
                                <li><i class="icofont icofont-minus minimize-card"></i></li>
                                <li><i class="icofont icofont-refresh reload-card"></i></li>
                                <li><i class="icofont icofont-error close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Flash Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i data-feather="alert-circle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Pending Payments Table --}}
                        <div class="recent-table table-responsive custom-scrollbar">
                            <table class="table table-bordered" id="pending-payments-table">
                                <thead>
                                    <tr>
                                
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Receipt</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingPayments as $order)
                                    <tr>
                        
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->billing_name ?? $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ $order->billing_email ?? $order->user->email ?? 'N/A' }}</td>
                                        <td><span class="badge badge-success">₦{{ number_format($order->total, 2) }}</span></td>
                                        <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->payment_status === 'pending_verification' ? 'warning' : ($order->payment_status === 'paid' ? 'success' : 'danger') }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->payment_receipt)
                                                <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i data-feather="eye"></i> View Receipt
                                                </a>
                                            @else
                                                <span class="badge badge-light-secondary">No Receipt</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                {{-- Verify Payment --}}
                                                <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Verify this payment for Order #{{ $order->id }}?')" title="Verify Payment">
                                                        <i data-feather="check"></i> Verify
                                                    </button>
                                                </form>
                                                {{-- Reject Payment --}}
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $order->id }}" title="Reject Payment">
                                                    <i data-feather="x-circle"></i> Reject
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Reject Payment Modal --}}
                                    <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Payment - Order #{{ $order->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Rejection Reason <span class="txt-danger">*</span></label>
                                                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Enter reason for rejection..."></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Additional Notes (optional)</label>
                                                            <textarea name="notes" class="form-control" rows="2" placeholder="Add any additional notes..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this payment for Order #{{ $order->id }}?')">Reject Payment</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No pending payments found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($pendingPayments->isEmpty())
                            <div class="alert alert-info mt-3 mb-0">
                                <i data-feather="info"></i> No pending payments require verification at this time.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment History Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment History</h4>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa-solid fa-gear fa-spin"></i></li>
                                <li><i class="view-html fa-solid fa-code"></i></li>
                                <li><i class="icofont icofont-maximize full-card"></i></li>
                                <li><i class="icofont icofont-minus minimize-card"></i></li>
                                <li><i class="icofont icofont-refresh reload-card"></i></li>
                                <li><i class="icofont icofont-error close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="recent-table table-responsive custom-scrollbar">
                            <table class="table table-bordered" id="payment-history-table">
                                <thead>
                                    <tr>
                                     
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Verified By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentHistory as $tx)
                                    <tr>
                            
                                        <td>
                                            @if($tx->order)
                                                <a href="{{ route('admin.orders.show', $tx->order) }}">#{{ $tx->order->id }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $tx->order?->billing_name ?? $tx->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $tx->type === 'order_payment' ? 'info' : 'warning' }}">
                                                {{ ucfirst(str_replace('_', ' ', $tx->type)) }}
                                            </span>
                                        </td>
                                        <td><strong>₦{{ number_format($tx->amount, 2) }}</strong></td>
                                        <td>{{ $tx->currency }}</td>
                                        <td>{{ ucfirst($tx->payment_method ?? 'N/A') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $tx->status === 'accepted' || $tx->status === 'completed' ? 'success' : ($tx->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($tx->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $tx->verifier->name ?? '—' }}</td>
                                        <td>{{ $tx->created_at->format('d M, Y H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No payment history found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.autoFill.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/autoFill.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.keyTable.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/keyTable.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/fixedHeader.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/rowReorder.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/moment.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-range-btn.js') }}"></script>
    <script src="{{ asset('assets/js/modalpage/validation-modal.js') }}"></script>
    <script src="{{ asset('assets/js/select/bootstrap-select.min.js') }}"></script>
    <script>
        // Simple table - no DataTables needed for pending payments
    </script>
@endsection
