<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo de Venta - {{ $sale->folio }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }

        /* Header con logo a la izquierda */
        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo {
            width: 80px;
            vertical-align: middle;
        }

        .header-logo img {
            width: 70px;
            height: 70px;
        }

        .header-content {
            vertical-align: middle;
            padding-left: 15px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }

        .receipt-title {
            font-size: 14px;
            color: #444;
            font-weight: normal;
        }

        .folio-badge {
            text-align: right;
            vertical-align: middle;
        }

        .folio-text {
            font-size: 14px;
            font-weight: bold;
            color: #0d6efd;
        }

        /* Sección de información */
        .info-section {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 10px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 30%;
            color: #000;
        }

        .info-value {
            color: #000;
        }

        /* Badges de estado */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 12px;
            text-transform: uppercase;
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

        .status-transferida {
            background-color: #cce5ff;
            color: #004085;
        }

        .payment-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 12px;
        }

        .payment-efectivo {
            background-color: #d4edda;
            color: #155724;
        }

        .payment-tarjeta {
            background-color: #cce5ff;
            color: #004085;
        }

        .payment-transferencia {
            background-color: #e2d4f0;
            color: #6f42c1;
        }

        .payment-mixto {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        /* Tabla de productos */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th {
            background-color: #1f2937;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .products-table td {
            border-bottom: 1px solid #dee2e6;
            padding: 10px 8px;
            vertical-align: top;
        }

        .products-table .text-right {
            text-align: right;
        }

        .products-table .text-center {
            text-align: center;
        }

        .product-name {
            font-weight: bold;
            color: #000;
        }

        .product-sku {
            font-size: 9px;
            color: #555;
        }

        /* Sección de totales */
        .totals-section {
            margin-top: 20px;
            border-top: 2px solid #000;
            padding-top: 15px;
        }

        .totals-table {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px 10px;
        }

        .totals-table .label {
            text-align: right;
            color: #000;
            font-weight: bold;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
            width: 120px;
            color: #000;
        }

        .totals-table .total-row td {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
            color: #0d6efd;
        }

        .totals-table .discount {
            color: #28a745;
        }

        .totals-table .change-row td {
            font-size: 12px;
            color: #28a745;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #444;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .footer p {
            margin: 3px 0;
        }

        .thank-you {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Header con logo a la izquierda -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo EBC">
                    @endif
                </td>
                <td class="header-content">
                    <div class="company-name">EBC - Elise Beauty Center</div>
                    <div class="receipt-title">RECIBO DE VENTA</div>
                </td>
                <td class="folio-badge">
                    <div class="folio-text">{{ $sale->folio }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Información de la venta -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Fecha:</td>
                <td class="info-value">{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                <td class="info-label">Cajero:</td>
                <td class="info-value">{{ $sale->user->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Cliente:</td>
                <td class="info-value">{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</td>
                <td class="info-label">Estado:</td>
                <td class="info-value">
                    <span class="status-badge status-{{ $sale->estatus }}">
                        {{ ucfirst($sale->estatus) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="info-label">Método de Pago:</td>
                <td class="info-value">
                    <span class="payment-badge payment-{{ $sale->payment_method }}">
                        {{ ucfirst($sale->payment_method) }}
                        @if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto')
                            ({{ ucfirst($sale->card_type ?? 'N/A') }})
                        @endif
                    </span>
                </td>
                @if($sale->discount_coupon)
                    <td class="info-label">Cupón:</td>
                    <td class="info-value">{{ $sale->discount_coupon }}</td>
                @else
                    <td colspan="2"></td>
                @endif
            </tr>
        </table>
    </div>

    <!-- Tabla de productos -->
    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 50%;">Producto</th>
                <th style="width: 12%;" class="text-center">Cantidad</th>
                <th style="width: 19%;" class="text-right">Precio Unit.</th>
                <th style="width: 19%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->details as $detail)
                <tr>
                    <td>
                        <div class="product-name">{{ $detail->item ? $detail->item->name : 'Producto no encontrado' }}</div>
                        <div class="product-sku">SKU: {{ $detail->item ? $detail->item->sku : 'N/A' }}</div>
                    </td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">${{ number_format($detail->price, 2) }}</td>
                    <td class="text-right">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="value">${{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            @if($sale->discount_amount > 0)
                <tr>
                    <td class="label">Descuento:</td>
                    <td class="value discount">-${{ number_format($sale->discount_amount, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td class="label">TOTAL:</td>
                <td class="value">${{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            @if($sale->payment_method === 'efectivo' || $sale->payment_method === 'mixto')
                <tr>
                    <td class="label">Efectivo entregado:</td>
                    <td class="value">${{ number_format($sale->cash_amount, 2) }}</td>
                </tr>
            @endif
            @if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto')
                <tr>
                    <td class="label">Monto tarjeta:</td>
                    <td class="value">${{ number_format($sale->card_amount, 2) }}</td>
                </tr>
            @endif
            @if($change > 0)
                <tr class="change-row">
                    <td class="label">CAMBIO:</td>
                    <td class="value">${{ number_format($change, 2) }}</td>
                </tr>
            @endif
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="thank-you">¡Gracias por su compra!</p>
        <p>Este recibo es generado automáticamente por el sistema POS.</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
