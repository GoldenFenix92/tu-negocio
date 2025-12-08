<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo de Venta - {{ $sale->folio }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .receipt-title {
            font-size: 16px;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        .products-table td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        .products-table .text-right {
            text-align: right;
        }

        .products-table .text-center {
            text-align: center;
        }

        .totals-section {
            margin-top: 20px;
            border-top: 2px solid #eee;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 12px;
            text-transform: uppercase;
            margin-left: 5px;
        }

        .status-completada {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-cancelada {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">EBC - Elise Beauty Center</div>
            <div class="receipt-title">RECIBO DE VENTA</div>
            <p>¡Hola {{ $sale->client ? $sale->client->name : 'Cliente' }}!</p>
            <p>Gracias por tu compra. Aquí tienes una copia de tu recibo.</p>
        </div>

        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Folio:</div>
                <div class="info-value">{{ $sale->folio }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha:</div>
                <div class="info-value">{{ $sale->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Cajero:</div>
                <div class="info-value">{{ $sale->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Método de Pago:</div>
                <div class="info-value">
                    {{ ucfirst($sale->payment_method) }}
                    @if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto')
                        ({{ ucfirst($sale->card_type) }})
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $sale->status }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                </div>
            </div>
            @if($sale->discount_coupon)
                <div class="info-row">
                    <div class="info-label">Cupón:</div>
                    <div class="info-value">{{ $sale->discount_coupon }}</div>
                </div>
            @endif
        </div>

        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Producto</th>
                    <th style="width: 15%;">Cant.</th>
                    <th style="width: 17.5%;">Precio</th>
                    <th style="width: 17.5%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->details as $detail)
                    <tr>
                        <td>
                            @if($detail->item)
                                <strong>{{ $detail->item->name }}</strong><br>
                                <small>SKU: {{ $detail->item->sku }}</small>
                            @else
                                <strong>Producto no encontrado</strong><br>
                                <small>SKU: N/A</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-right">${{ number_format($detail->price, 2) }}</td>
                        <td class="text-right">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($sale->subtotal, 2) }}</span>
            </div>

            @if($sale->discount_amount > 0)
                <div class="total-row">
                    <span>Descuento:</span>
                    <span>-${{ number_format($sale->discount_amount, 2) }}</span>
                </div>
            @endif

            <div class="total-row final">
                <span>TOTAL:</span>
                <span>${{ number_format($sale->total_amount, 2) }}</span>
            </div>

            <div class="total-row" style="margin-top: 15px;">
                <span>Monto Pagado:</span>
                <span>${{ number_format($sale->cash_amount + $sale->card_amount, 2) }}</span>
            </div>
            @if($sale->payment_method === 'efectivo' || $sale->payment_method === 'mixto')
                <div class="total-row">
                    <span>Efectivo:</span>
                    <span>${{ number_format($sale->cash_amount, 2) }}</span>
                </div>
            @endif
            @if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto')
                <div class="total-row">
                    <span>Tarjeta:</span>
                    <span>${{ number_format($sale->card_amount, 2) }}</span>
                </div>
            @endif
            @php
                $amountPaid = $sale->cash_amount + $sale->card_amount;
                $change = $amountPaid - $sale->total_amount;
                if ($change < 0) {
                    $change = 0;
                }
            @endphp
            @if($change > 0)
                <div class="total-row final">
                    <span>CAMBIO:</span>
                    <span>${{ number_format($change, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="footer">
            <p>¡Gracias por su compra!</p>
            <p>Este recibo es generado automáticamente por el sistema POS.</p>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
