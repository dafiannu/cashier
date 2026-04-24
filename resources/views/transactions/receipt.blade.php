<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $transaction->id }}</title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background: #f5f5f5;
            font-family: "Courier New", monospace;
            color: #111827;
        }
        .receipt-wrapper {
            max-width: 300px;
            margin: 0 auto;
        }
        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 16px;
        }
        .actions a,
        .actions button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            padding: 8px 12px;
            font-family: inherit;
            font-size: 12px;
            cursor: pointer;
        }
        .receipt {
            background: #ffffff;
            border: 1px solid #d1d5db;
            padding: 16px;
        }
        .center {
            text-align: center;
        }
        .separator {
            margin: 12px 0;
            border-top: 1px dashed #6b7280;
        }
        .meta,
        .totals,
        .items {
            font-size: 12px;
            line-height: 1.6;
        }
        .item {
            margin-bottom: 10px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .item-name {
            font-weight: 700;
        }
        @media print {
            body {
                padding: 0;
                background: #ffffff;
            }
            .actions {
                display: none;
            }
            .receipt {
                border: none;
            }
        }
    </style>
</head>
<body>
    @php($rupiah = fn ($amount) => 'Rp '.number_format((float) $amount, 0, ',', '.'))

    <div class="receipt-wrapper">
        <div class="actions">
            <a href="{{ route('cart.index') }}">Back to Cart</a>
            <button type="button" onclick="window.print()">Print</button>
        </div>

        <div class="receipt">
            <div class="center">
                <div style="font-size: 18px; font-weight: 700;">Dafian's Store</div>
                <div style="font-size: 12px;">Simple Sales Receipt</div>
            </div>

            <div class="separator"></div>

            <div class="meta">
                <div>Transaction ID : #{{ $transaction->id }}</div>
                <div>Date : {{ $transaction->date->format('d/m/Y H:i:s') }}</div>
                <div>Cashier : {{ $transaction->user->name }}</div>
            </div>

            <div class="separator"></div>

            <div class="items">
                @foreach ($transaction->transactionDetails as $detail)
                    <div class="item">
                        <div class="item-name">{{ $detail->item->name }}</div>
                        <div class="row">
                            <span>{{ $rupiah($detail->item->price) }} x {{ $detail->qty }}</span>
                            <span>{{ $rupiah($detail->subtotal) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="separator"></div>

            <div class="totals">
                <div class="row">
                    <span>Total</span>
                    <span>{{ $rupiah($transaction->total) }}</span>
                </div>
                <div class="row">
                    <span>Pay Total</span>
                    <span>{{ $rupiah($transaction->pay_total) }}</span>
                </div>
                <div class="row">
                    <span>Change</span>
                    <span>{{ $rupiah($transaction->pay_total - $transaction->total) }}</span>
                </div>
            </div>

            <div class="separator"></div>

            <div class="center" style="font-size: 12px;">
                Thank you for shopping
            </div>
        </div>
    </div>
</body>
</html>
