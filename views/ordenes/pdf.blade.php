<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $orden->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; }
        .header { margin-bottom: 15px; }
        .company-info { line-height: 1.3; }
        .bill-to { margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 5px 0; }
        th, td { border: 1px solid #ddd; padding: 5px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals-table { width: 50%; float: right; margin-top: 10px; }
        .signature-area { margin-top: 30px; }
        .footer { font-size: 10px; margin-top: 20px; }
        .page-break { page-break-after: always; }
        hr { border-top: 1px solid #000; margin: 5px 0; }
    </style>
</head>
<body>
    <!-- Encabezado de la empresa -->
    <div class="header">
        <div style="float: left; width: 70%;">
            <h1 style="margin: 0; font-size: 18px;">Quince Dresses NJ | QuinceDresses.com</h1>
            <p style="margin: 2px 0;">727 Franklin Blvd. Ste #9</p>
            <p style="margin: 2px 0;">Somerset, NJ 08873</p>
            <p style="margin: 2px 0;">Phone: 732-485-4886</p>
            <p style="margin: 2px 0;">www.QuinceDresses.com</p>
            <p style="margin: 2px 0;">info@quincedresses.com</p>
        </div>
        <div style="float: right; width: 30%; text-align: right;">
            @if(file_exists(public_path('images/logo.png')))
            <img src="{{ public_path('images/logo.png') }}" style="height: 80px;">
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Información del cliente -->
    <div class="bill-to">
        <h2 style="margin: 3px 0; font-size: 16px;">Bill To: {{ $orden->cliente->nombres }} {{ $orden->cliente->apellidos }}</h2>
        <p style="margin: 2px 0;">Phone: {{ $orden->cliente->telefono }}</p>
        <p style="margin: 2px 0;">Event Date: {{ $orden->fecha_evento ? $orden->fecha_evento->format('m/d/Y') : 'N/A' }}</p>
    </div>

    <hr>

    <!-- Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th>Item #</th>
                <th>Item</th>
                <th>Color</th>
                <th>Accent Color</th>
                <th>Sz</th>
                <th>Qty</th>
                <th>Tx</th>
                <th>Price</th>
                <th>Adj Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->pivot->color ?? '' }}</td>
                <td>{{ $producto->pivot->color_secundario ?? '' }}</td>
                <td>{{ $producto->pivot->talla ?? '' }}</td>
                <td class="text-center">{{ $producto->pivot->cantidad }}</td>
                <td class="text-center">{{ $producto->pivot->impuesto }}%</td>
                <td class="text-right">${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($producto->pivot->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen de pagos -->
    <table class="totals-table">
        <tr>
            <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
            <td class="text-right">${{ number_format($orden->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right">(+) Sales Tax</td>
            <td class="text-right">${{ number_format($orden->impuesto_total, 2) }}</td>
        </tr>
      
        <tr>
            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong>${{ number_format($orden->total, 2) }}</strong></td>
        </tr>
        
        <!-- Anticipos -->
        @if($orden->adelanto1 > 0)
        <tr>
            <td>Receipt #</td>
            <td>Method</td>
            <td>Date</td>
            <td>Amount</td>
            <td class="text-right">${{ number_format($orden->adelanto1, 2) }}</td>
        </tr>
        @endif
        
        @if($orden->adelanto2 > 0)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">${{ number_format($orden->adelanto2, 2) }}</td>
        </tr>
        @endif
        
        @if($orden->adelanto3 > 0)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">${{ number_format($orden->adelanto3, 2) }}</td>
        </tr>
        @endif
        
        <tr>
            <td colspan="4" class="text-right"><strong>Payments</strong></td>
            <td class="text-right"><strong>${{ number_format($totalAdvances, 2) }}</strong></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"><strong>AMOUNT DUE</strong></td>
            <td class="text-right"><strong>${{ number_format($orden->total - $totalAdvances, 2) }}</strong></td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <!-- Acuerdo de ventas -->
    <div class="page-break"></div>
    <h3 style="margin-top: 20px; font-size: 14px;">Sales Agreement</h3>
    <p style="font-weight: bold; margin: 5px 0;">ALL IN STORE SALES ARE FINAL. NO REFUNDS OR EXCHANGES. SPECIAL ORDERS READ CANCELLATION POLICY.</p>
    
    <ul style="padding-left: 15px; font-size: 11px;">
        <li>I agree with the designer, style, color and size for each item ordered. I understand that custom measurements and/or custom length may not be exact.</li>
        <li>I understand that when purchasing a box sample item, it is sold in its current condition.</li>
        <li>Client has 2-3 Weeks from day customer is notified of garment arrival to store to pick up their merchandise.</li>
        <li>I understand an appointment will have to be scheduled once the gown(s) arrives for a fitting.</li>
        <li><strong>Cancellation Policy:</strong> Within 24-48 Hours a $100 fee will be deducted from deposit.</li>
        <li>I further understand that I will not hold the store liable for any delays in production.</li>
        <li>I understand that all in Store sales are final and deposits or payments are not refundable nor exchangeable.</li>
    </ul>

    <!-- Firma del cliente -->
    <div class="signature-area">
        <p style="margin-bottom: 30px;">Customer Print Name: ___________________________</p>
        <p>X________________________ (Signature) _______________ (Date)</p>
        <p class="footer">{{ now()->format('m/d/Y h:i A') }} | Page 1</p>
    </div>
</body>
</html>