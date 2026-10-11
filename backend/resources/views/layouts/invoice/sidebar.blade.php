<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean & modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>@yield('title') Cuba - Premium Admin Template</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #1e293b;
            background: #f1f5f9;
        }

        .invoice-wrapper {
            min-height: 100vh;
            display: flex;
            background: #f1f5f9;
        }

        /* Sidebar */
        .invoice-sidebar {
            width: 340px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
        }

        .invoice-sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .invoice-sidebar-header h5 {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .invoice-sidebar-header .invoice-count {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 400;
        }

        .btn-back-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #ffffff;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
            margin-top: 10px;
        }

        .btn-back-dashboard:hover {
            background: #f5f3ff;
            border-color: #c4b5fd;
            color: #7366FF;
        }

        #invoice-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px 12px;
        }

        .invoice-list-item {
            padding: 14px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
            margin-bottom: 4px;
            border: 1px solid transparent;
        }

        .invoice-list-item:hover {
            background: #faf5ff;
            border-color: #e9d5ff;
        }

        .invoice-list-item.active {
            background: #f5f3ff;
            border-color: #a78bfa;
            box-shadow: 0 0 0 1px #7366FF, 0 2px 8px rgba(115, 102, 255, 0.12);
        }

        .invoice-list-item .invoice-number {
            font-size: 14px;
            font-weight: 600;
            color: #7366FF;
            letter-spacing: -0.01em;
        }

        .invoice-list-item .customer-name {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
            font-weight: 400;
        }

        .invoice-list-item .invoice-date {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .invoice-list-item .invoice-total {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .status-badge-paid {
            background: #f0fdf4;
            color: #16a34a;
        }

        .status-badge-pending {
            background: #fffbeb;
            color: #d97706;
        }

        .status-badge-processing {
            background: #f5f3ff;
            color: #7366FF;
        }

        .status-badge-cancelled {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Main Content */
        .invoice-main {
            flex: 1;
            overflow-y: auto;
            background: #f1f5f9;
        }

        .invoice-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 32px;
            background: #ffffff;
            border-bottom: 2px solid #7366FF;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .invoice-top-bar h4 {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .invoice-top-bar-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-back-dashboard-sm {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #ffffff;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-back-dashboard-sm:hover {
            background: #f5f3ff;
            border-color: #c4b5fd;
            color: #7366FF;
        }

        .invoice-actions {
            display: flex;
            gap: 8px;
        }

        .btn-print {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            font-family: inherit;
        }

        .btn-print:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .btn-download {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            background: #7366FF;
            color: #ffffff;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-download:hover {
            background: #6355e6;
        }

        .invoice-content {
            padding: 32px;
            max-width: 960px;
            margin: 0 auto;
        }

        .invoice-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            color: #94a3b8;
        }

        .invoice-empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            opacity: 0.3;
            color: #7366FF;
        }

        .invoice-empty-state p {
            font-size: 14px;
            font-weight: 400;
        }

        /* Invoice Detail Card */
        .invoice-detail-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            border-top: 3px solid #7366FF;
            overflow: hidden;
        }

        .invoice-detail-header {
            padding: 28px 32px;
            border-bottom: 1px solid #e2e8f0;
            border-left: 4px solid #7366FF;
            background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 100%);
        }

        .invoice-detail-header .invoice-number-display {
            font-size: 22px;
            font-weight: 700;
            color: #7366FF;
            letter-spacing: -0.02em;
        }

        .invoice-detail-header .invoice-meta {
            display: flex;
            gap: 24px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .invoice-meta-item {
            font-size: 13px;
            color: #64748b;
        }

        .invoice-meta-item strong {
            color: #7366FF;
            font-weight: 500;
        }

        .invoice-detail-body {
            padding: 32px;
        }

        .invoice-address-row {
            display: flex;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .invoice-address-block {
            flex: 1;
            min-width: 200px;
        }

        .invoice-address-block .label {
            font-size: 12px;
            font-weight: 500;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .invoice-address-block .value {
            font-size: 14px;
            color: #7366FF;
            font-weight: 500;
        }

        .invoice-address-block .value-sub {
            font-size: 13px;
            color: #64748b;
            font-weight: 400;
            margin-top: 2px;
        }

        .invoice-total-section {
            text-align: right;
            min-width: 180px;
        }

        .invoice-total-section .label {
            font-size: 12px;
            font-weight: 500;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .invoice-total-section .amount {
            font-size: 28px;
            font-weight: 700;
            color: #7366FF;
            letter-spacing: -0.02em;
            margin-top: 4px;
        }

        /* Items Table */
        .invoice-items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-items-table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #7366FF;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #7366FF;
            background: #faf5ff;
        }

        .invoice-items-table th:last-child {
            text-align: right;
        }

        .invoice-items-table td {
            padding: 14px 16px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .invoice-items-table td:last-child {
            text-align: right;
            font-weight: 500;
            color: #0f172a;
        }

        .invoice-items-table .item-name {
            font-weight: 500;
            color: #7366FF;
        }

        .invoice-items-table .item-qty {
            color: #64748b;
        }

        .invoice-summary {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .invoice-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
            color: #64748b;
        }

        .invoice-summary-row.total {
            padding-top: 12px;
            margin-top: 8px;
            border-top: 1px solid #e2e8f0;
            font-size: 16px;
            font-weight: 600;
            color: #7366FF;
        }

        .invoice-summary-row .amount {
            font-weight: 500;
            color: #7366FF;
        }

        /* Footer */
        .invoice-footer {
            padding: 20px 32px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #faf5ff;
        }

        .invoice-footer .authorized {
            font-size: 13px;
            color: #94a3b8;
        }

        .invoice-footer .signature-line {
            width: 120px;
            height: 1px;
            background: #cbd5e1;
            margin: 8px 0;
        }

        .invoice-footer .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .invoice-footer .btn-back-dashboard-footer {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #ffffff;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .invoice-footer .btn-back-dashboard-footer:hover {
            background: #f5f3ff;
            border-color: #c4b5fd;
            color: #7366FF;
        }

        .btn-print-primary {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: #7366FF;
            color: #ffffff;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print-primary:hover {
            background: #6355e6;
        }

        .btn-download-secondary {
            padding: 10px 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-download-secondary:hover {
            background: #f5f3ff;
            border-color: #c4b5fd;
            color: #7366FF;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .invoice-sidebar {
                width: 100%;
                min-height: auto;
                max-height: 320px;
                position: relative;
            }

            .invoice-wrapper {
                flex-direction: column;
            }

            .invoice-content {
                padding: 20px;
            }

            .invoice-detail-body {
                padding: 20px;
            }

            .invoice-address-row {
                flex-direction: column;
                gap: 20px;
            }

            .invoice-total-section {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">
        <!-- Sidebar -->
        <div class="invoice-sidebar">
            <div class="invoice-sidebar-header">
                <h5>Invoices</h5>
                <div class="invoice-count">{{ count($invoices) }} invoices</div>
                <a href="{{ url('/admin') }}" class="btn-back-dashboard">
                    <i class="ti-arrow-left" style="font-size: 11px;"></i> Back to Dashboard
                </a>
            </div>
            <div id="invoice-list">
                @foreach($invoices as $invoice)
                <div class="invoice-list-item" data-invoice-id="{{ $invoice->id }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                            <div class="customer-name">{{ $invoice->customer_name }}</div>
                            <div class="invoice-date">{{ $invoice->date }}</div>
                        </div>
                        <div class="text-end" style="min-width: 80px;">
                            <div class="invoice-total">₦{{ number_format($invoice->total, 2) }}</div>
                            <span class="status-badge status-badge-{{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="invoice-main">
            <div class="invoice-top-bar">
                <h4>Invoice Details</h4>
                <div class="invoice-top-bar-actions">
                    <a href="{{ url('/admin/dashboard') }}" class="btn-back-dashboard-sm">
                        <i class="ti-arrow-left" style="font-size: 11px;"></i> Dashboard
                    </a>
                    <div class="invoice-actions">
                        <button class="btn-print" onclick="window.print()">Print</button>
                        <a href="{{ route('admin.invoice_1') }}" class="btn-download" download>Download</a>
                    </div>
                </div>
            </div>
            <div class="invoice-content" id="invoice-detail">
                <div class="invoice-empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>Select an invoice from the sidebar to view details.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const firstInvoice = $('#invoice-list .invoice-list-item').first();
            if (firstInvoice.length) {
                firstInvoice.addClass('active');
                loadInvoice(firstInvoice.data('invoice-id'));
            }

            $('#invoice-list').on('click', '.invoice-list-item', function() {
                $('#invoice-list .invoice-list-item').removeClass('active');
                $(this).addClass('active');
                loadInvoice($(this).data('invoice-id'));
            });

            function loadInvoice(id) {
                $.get('{{ route("admin.invoice.show", ":id") }}'.replace(':id', id), function(data) {
                    const itemsHtml = data.items.map(item => `
                        <tr>
                            <td><span class="item-name">${item.name}</span></td>
                            <td><span class="item-qty">${item.quantity}</span></td>
                            <td>₦${item.rate.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                            <td>₦${item.line_total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        </tr>
                    `).join('');

                    $('#invoice-detail').html(`
                        <div class="invoice-detail-card">
                            <div class="invoice-detail-header">
                                <div class="invoice-number-display">${data.invoice_number}</div>
                                <div class="invoice-meta">
                                    <div class="invoice-meta-item"><strong>Date:</strong> ${data.date}</div>
                                    <div class="invoice-meta-item"><strong>Status:</strong> ${data.status}</div>
                                    <div class="invoice-meta-item"><strong>Payment:</strong> ${data.payment_status}</div>
                                </div>
                            </div>
                            <div class="invoice-detail-body">
                                <div class="invoice-address-row">
                                    <div class="invoice-address-block">
                                        <div class="label">Billed To</div>
                                        <div class="value">${data.customer_name}</div>
                                        <div class="value-sub">${data.customer_address}</div>
                                        <div class="value-sub">${data.customer_email}</div>
                                        <div class="value-sub">${data.customer_phone}</div>
                                    </div>
                                    <div class="invoice-total-section">
                                        <div class="label">Amount Due</div>
                                        <div class="amount">₦${data.total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                                    </div>
                                </div>

                                <table class="invoice-items-table">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th>Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHtml}
                                    </tbody>
                                </table>

                                <div class="invoice-summary">
                                    <div class="invoice-summary-row">
                                        <span>Subtotal</span>
                                        <span class="amount">₦${data.subtotal.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    </div>
                                    <div class="invoice-summary-row">
                                        <span>Tax (5%)</span>
                                        <span class="amount">₦${data.tax.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    </div>
                                    <div class="invoice-summary-row total">
                                        <span>Amount Due</span>
                                        <span class="amount">₦${data.total.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-footer">
                                <div class="authorized">
                                    <div class="signature-line"></div>
                                    <div>Authorized Sign</div>
                                </div>
                                <div class="actions">
                                    <a href="{{ url('/admin/dashboard') }}" class="btn-back-dashboard-footer">
                                        <i class="ti-arrow-left" style="font-size: 11px;"></i> Dashboard
                                    </a>
                                    <button class="btn-print-primary" onclick="window.print()">Print Invoice</button>
                                    <a href="{{ route('admin.invoice_1') }}" class="btn-download-secondary" download>Download</a>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }
        });
    </script>
</body>

</html>
