<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte General de Control de Caja</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }

        /* Header */
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

        .report-title {
            font-size: 14px;
            color: #444;
            font-weight: normal;
        }

        .report-date {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        /* Títulos de sección */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            color: #000;
            page-break-after: avoid;
        }

        /* Tablas de datos */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .data-table th {
            background-color: #1f2937 !important;
            color: #ffffff !important;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .data-table td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 6px;
            font-size: 9px;
            color: #000;
        }

        .data-table .text-right {
            text-align: right;
        }

        .data-table .text-center {
            text-align: center;
        }

        /* Totales */
        .totals-section {
            margin-top: 10px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            page-break-inside: avoid;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px;
        }

        .totals-label {
            font-weight: bold;
            color: #000;
            width: 60%;
        }

        .totals-value {
            font-weight: bold;
            text-align: right;
            color: #000;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #444;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
    </style>
</head>
<body>

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
                    <div class="report-title">REPORTE GENERAL DE CONTROL DE CAJA</div>
                    <div class="report-date">Generado el {{ now()->format('d/m/Y H:i:s') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Resumen Financiero</div>
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="totals-label">Total de Ventas:</td>
                <td class="totals-value">{{ $sales->count() }}</td>
            </tr>
            <tr>
                <td class="totals-label">Ingresos Totales:</td>
                <td class="totals-value">${{ number_format($totals['total_amount'], 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Efectivo:</td>
                <td class="totals-value">${{ number_format($totals['cash_amount'], 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Tarjeta:</td>
                <td class="totals-value">${{ number_format($totals['card_amount'], 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Transferencia:</td>
                <td class="totals-value">${{ number_format($totals['transfer_amount'], 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">Mixto:</td>
                <td class="totals-value">${{ number_format($totals['mixed_amount'] ?? 0, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Arqueos de Caja Realizados</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Folio</th>
                <th style="width: 20%;">Fecha</th>
                <th style="width: 20%;">Usuario</th>
                <th style="width: 15%;" class="text-right">Esperado</th>
                <th style="width: 15%;" class="text-right">Real</th>
                <th style="width: 15%;" class="text-right">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashCounts as $count)
                <tr>
                    <td>{{ $count->folio }}</td>
                    <td>{{ $count->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $count->user->name ?? 'N/A' }}</td>
                    <td class="text-right">${{ number_format($count->expected_cash, 2) }}</td>
                    <td class="text-right">${{ number_format($count->actual_cash, 2) }}</td>
                    <td class="text-right" style="color: {{ $count->difference < 0 ? 'red' : ($count->difference > 0 ? 'green' : 'black') }}">
                        ${{ number_format($count->difference, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay arqueos registrados en este periodo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Cortes de Caja Realizados</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">Folio</th>
                <th style="width: 20%;">Fecha</th>
                <th style="width: 20%;">Usuario</th>
                <th style="width: 15%;" class="text-right">Esperado</th>
                <th style="width: 15%;" class="text-right">Real</th>
                <th style="width: 15%;" class="text-right">Diferencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashCuts as $cut)
                <tr>
                    <td>{{ $cut->folio }}</td>
                    <td>{{ $cut->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $cut->user->name ?? 'N/A' }}</td>
                    <td class="text-right">${{ number_format($cut->expected_cash, 2) }}</td>
                    <td class="text-right">${{ number_format($cut->actual_cash, 2) }}</td>
                    <td class="text-right" style="color: {{ $cut->difference < 0 ? 'red' : ($cut->difference > 0 ? 'green' : 'black') }}">
                        ${{ number_format($cut->difference, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay cortes registrados en este periodo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el sistema.</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
