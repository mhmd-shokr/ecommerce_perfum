<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #0a0a0a;
            padding: 32px 40px;
            margin-bottom: 32px;
        }
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .brand-name {
            font-size: 20px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #C8A96A;
        }
        .brand-tagline {
            font-size: 10px;
            color: #5a5040;
            margin-top: 4px;
            letter-spacing: 1px;
        }
        .invoice-label {
            text-align: right;
        }
        .invoice-label h1 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .invoice-label p {
            font-size: 11px;
            color: #8a7248;
            margin-top: 4px;
        }

        /* ── Gold Rule ── */
        .gold-rule {
            border: none;
            border-top: 2px solid #C8A96A;
            margin: 0 40px 28px;
            opacity: 0.4;
        }

        /* ── Info Section ── */
        .info-section {
            padding: 0 40px;
            margin-bottom: 28px;
        }
        .info-grid {
            display: flex;
            justify-content: space-between;
            gap: 24px;
        }
        .info-box {
            flex: 1;
        }
        .info-box-title {
            font-size: 9px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #8a7248;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e8dcc8;
        }
        .info-box p {
            font-size: 12px;
            color: #333;
            line-height: 1.7;
        }
        .info-box strong {
            color: #0a0a0a;
        }

        /* ── Status Badge ── */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .status-paid     { background: #e8f5e8; color: #2d7a2d; }
        .status-pending  { background: #fef8e8; color: #8a7248; }
        .status-failed   { background: #fde8e8; color: #c45040; }
        .status-refunded { background: #ede8f5; color: #6a4caf; }

        /* ── Items Table ── */
        .items-section {
            padding: 0 40px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 9px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #8a7248;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #0a0a0a;
        }
        thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #C8A96A;
            font-weight: 600;
        }
        thead th:last-child { text-align: right; }

        tbody tr {
            border-bottom: 1px solid #f0ebe0;
        }
        tbody tr:nth-child(even) {
            background: #faf8f4;
        }
        tbody td {
            padding: 12px 14px;
            font-size: 12px;
            color: #333;
            vertical-align: top;
        }
        tbody td:last-child {
            text-align: right;
            color: #0a0a0a;
            font-weight: 600;
        }
        .item-name { font-weight: 600; color: #0a0a0a; }
        .item-meta { font-size: 11px; color: #888; margin-top: 2px; }

        /* ── Totals ── */
        .totals-section {
            padding: 0 40px;
            margin-bottom: 32px;
        }
        .totals-box {
            margin-left: auto;
            width: 280px;
            border: 1px solid #e8dcc8;
            border-radius: 6px;
            overflow: hidden;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 16px;
            font-size: 12px;
            border-bottom: 1px solid #f0ebe0;
        }
        .totals-row:last-child { border-bottom: none; }
        .totals-row .t-label { color: #666; }
        .totals-row .t-val   { color: #0a0a0a; font-weight: 600; }
        .totals-row.grand {
            background: #0a0a0a;
            padding: 12px 16px;
        }
        .totals-row.grand .t-label { color: #C8A96A; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; }
        .totals-row.grand .t-val   { color: #C8A96A; font-size: 16px; font-weight: 700; }
        .discount-val { color: #2d7a2d !important; }

        /* ── Footer ── */
        .footer {
            background: #0a0a0a;
            padding: 20px 40px;
            margin-top: 20px;
        }
        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer p {
            font-size: 10px;
            color: #5a5040;
            line-height: 1.6;
        }
        .footer .thank-you {
            font-size: 12px;
            color: #C8A96A;
            letter-spacing: 1px;
        }

        /* ── Note ── */
        .note-section {
            padding: 0 40px;
            margin-bottom: 20px;
        }
        .note-box {
            background: #faf8f4;
            border-left: 3px solid #C8A96A;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            font-size: 11px;
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-inner">
            <div>
                <div class="brand-name">{{ config('app.name') }}</div>
                <div class="brand-tagline">Luxury Fragrances</div>
            </div>
            <div class="invoice-label">
                <h1>Invoice</h1>
                <p>#{{ $order->order_number }}</p>
                <p>{{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <hr class="gold-rule">

    {{-- ── Info Section ── --}}
    <div class="info-section">
        <div class="info-grid">

            {{-- Bill To --}}
            <div class="info-box">
                <div class="info-box-title">Bill To</div>
                <p>
                    <strong>{{ $order->address->full_name }}</strong><br>
                    {{ $order->address->phone }}<br>
                    {{ $order->user->email }}<br>
                    {{ $order->address->street }},
                    @if($order->address->building) Bldg {{ $order->address->building }}, @endif
                    @if($order->address->floor) Floor {{ $order->address->floor }}, @endif
                    <br>
                    {{ $order->address->city }}, {{ $order->address->governorate }}
                </p>
            </div>

            {{-- Order Info --}}
            <div class="info-box">
                <div class="info-box-title">Order Info</div>
                <p>
                    <strong>Order Date:</strong><br>
                    {{ $order->created_at->format('d M Y, h:i A') }}<br><br>
                    <strong>Payment Method:</strong><br>
                    {{ ucfirst($order->payment_method) }}<br><br>
                    <strong>Payment Status:</strong><br>
                    @php
                        $statusClass = match($order->payment_status) {
                            'paid'     => 'status-paid',
                            'pending'  => 'status-pending',
                            'failed'   => 'status-failed',
                            'refunded' => 'status-refunded',
                            default    => 'status-pending',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
            </div>

            {{-- From --}}
            <div class="info-box">
                <div class="info-box-title">From</div>
                <p>
                    <strong>{{ config('app.name') }}</strong><br>
                    support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}<br>
                    {{ config('app.url') }}
                </p>
            </div>

        </div>
    </div>

    {{-- ── Items Table ── --}}
    <div class="items-section">
        <div class="section-title">Items Ordered</div>
        <table>
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:15%;text-align:center;">Qty</th>
                    <th style="width:15%;text-align:center;">Unit Price</th>
                    <th style="width:20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="item-name">{{ $item->product_name }}</div>
                        </td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:center;">${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── Totals ── --}}
    <div class="totals-section">
        <div class="totals-box">
            <div class="totals-row">
                <span class="t-label">Subtotal</span>
                <span class="t-val">${{ number_format($order->sub_total, 2) }}</span>
            </div>
            <div class="totals-row">
                <span class="t-label">Shipping</span>
                <span class="t-val">${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="totals-row">
                    <span class="t-label">Discount</span>
                    <span class="t-val discount-val">-${{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="totals-row grand">
                <span class="t-label">Total</span>
                <span class="t-val">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- ── Note ── --}}
    <div class="note-section">
        <div class="note-box">
            Thank you for shopping with {{ config('app.name') }}.
            This invoice serves as proof of purchase.
            For any questions, please contact our support team.
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-inner">
            <p>
                © {{ date('Y') }} {{ config('app.name') }}<br>
                All rights reserved.
            </p>
            <p class="thank-you">Thank you for your purchase ✦</p>
        </div>
    </div>

</body>
</html>