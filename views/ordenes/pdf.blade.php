<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $orden->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            line-height: 1.2;
            margin: 0.5cm;
        }
        .header { margin-bottom: 5px; }
        .company-info { line-height: 1.1; }
        .bill-to { margin: 5px 0; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 3px 0; 
            font-size: 11px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 3px; 
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals-table { 
            width: 45%; 
            float: right; 
            margin-top: 5px;
            margin-left: 10px;
        }
        .signature-area { 
            margin-top: 15px;
            font-size: 11px;
        }
        .footer { 
            font-size: 10px; 
            margin-top: 10px;
        }
        hr { 
            border-top: 1px solid #000; 
            margin: 3px 0; 
        }
        .compact { margin: 2px 0; }
        .logo { height: 60px; }
        h1 { margin: 0; font-size: 14px; }
        h2 { margin: 2px 0; font-size: 12px; }
        h3 { margin: 5px 0; font-size: 11px; }
        ul { 
            padding-left: 15px; 
            margin: 5px 0;
            font-size: 11px;
        }
        li { margin-bottom: 2px; }
       .logo-img {
    filter: drop-shadow(0 0 0 transparent) !important;
    background: red;
}

    </style>
</head>
<body>
    <!-- Encabezado de la empresa -->
    <div class="header">
    
        <div style="float: left; width: 70%;">
            @if($orden->identidad == 'SO')
            <h1 style="color: #000000; font-size: 25px">#Special Order - {{$orden->prefijo}}</h1>
            @elseif($orden->identidad == 'L')
            <h1 style="color: #000000; font-size: 25px">#Layaway - {{$orden->prefijo}}</h1>
            @endif
            <br>
            <h1>{{$tienda->nombre}} | {{$tienda->website}}</h1>
            <p class="compact">{{$tienda->direccion}}</p>
            <p class="compact">Phone: {{$tienda->telefono}}</p>
            <p class="compact">{{$tienda->website}}</p>
            <p class="compact">{{$tienda->email}}</p>
            @foreach($tienda as $tienda)
            @endforeach
        </div>

        <div style="float: right; width: 30%; text-align: right;">
    @if(file_exists(public_path('images/logo.jpg')))
    <img src="{{ public_path('images/logo.jpg') }}" class="logo" style="filter: none !important;">
    @else
    <!-- Logo de respaldo o texto -->
    <div style="border: 1px solid #ccc; padding: 5px;">
        Quince Dresses NJ
    </div>
    @endif
     <div class="bill-to">
        <h2>Bill To: {{ $orden->cliente->nombres }} {{ $orden->cliente->apellidos }}</h2>
        <p class="compact">Phone: {{ $orden->cliente->telefono }}</p>
        <p class="compact">Event Date: {{ $orden->fecha_compra ? $orden->fecha_compra->format('m/d/Y') : 'N/A' }}</p>
    </div>
</div>
        <div style="clear: both;"></div>
    </div>

    <!-- Información del cliente -->
   

    <hr>

    <!-- Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Item #</th>
                <th style="width: 25%;">Item</th>
                <th style="width: 10%;">Color</th>
                <th style="width: 12%;">Accent Color</th>
                <th style="width: 5%;">Sz</th>
                <th style="width: 5%;">Qty</th>
                <th style="width: 5%;">Tx</th>
                <th style="width: 10%;">Price</th>
                <th style="width: 10%;">Adj Price</th>
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

    <table style="width: 100%;">
  <tr>
    <!-- Columna izquierda: Observaciones -->
    <td style="width: 50%; vertical-align: top; padding-right: 10px;">
      <strong>Observations:</strong><br><br>
      {{ $orden->observaciones }}
    </td>

    <!-- Columna derecha: Resumen de pagos -->
    <td style="width: 50%; vertical-align: top; padding-left: 10px; border: 0px solid red">
      <table style="width: 100%; border: 1px solid blue" class="totals-table">
        <tr>
          <td class="text-right"><strong>Subtotal</strong></td>
          <td class="text-right">${{ number_format($orden->subtotal, 2) }}</td>
        </tr>
        <tr>
          <td class="text-right">(+) Sales Tax</td>
          <td class="text-right">${{ number_format($orden->impuesto_total, 2) }}</td>
        </tr>
        <tr>
          <td class="text-right"><strong>Grand Total</strong></td>
          <td class="text-right"><strong>${{ number_format($orden->total, 2) }}</strong></td>
        </tr>

        @if($orden->adelanto > 0)
          <tr>
            <td class="text-right">Advancement</td>
            <td class="text-right">${{ number_format($orden->adelanto, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto1 > 0)
          <tr>
            <td class="text-right">Advancement 1</td>
            <td class="text-right">${{ number_format($orden->adelanto1, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto2 > 0)
          <tr>
            <td class="text-right">Advancement 2</td>
            <td class="text-right">${{ number_format($orden->adelanto2, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto3 > 0)
          <tr>
            <td class="text-right">Advancement 3</td>
            <td class="text-right">${{ number_format($orden->adelanto3, 2) }}</td>
          </tr>
        @endif

        <tr>
          <td class="text-right"><strong>Payments</strong></td>
          <td class="text-right"><strong>${{ number_format($totalAdvances, 2) }}</strong></td>
        </tr>
        <tr>
          <td class="text-right"><strong>AMOUNT DUE</strong></td>
          <td class="text-right"><strong>${{ number_format($orden->total - $totalAdvances, 2) }}</strong></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


    <div style="clear: both;"></div>

    <!-- Acuerdo de ventas -->
    <h3>Sales Agreement</h3>
    <p style="font-weight: bold; margin: 3px 0; font-size: 9px; color: #ea2205;">ALL IN STORE SALES ARE FINAL. NO REFUNDS OR EXCHANGES. SPECIAL ORDERS READ CANCELLATION POLICY.</p>
    
    <ul>
        <li>I agree with the designer, style, color and size for each item ordered. I understand that custom measurements and/or custom length may not be exact. I understand that dye lots may vary from swatches.</li>
        <li>I understand that when purchasing a floor sample item, it is sold in 'as is' condition. Fixing and cleaning will be my responsibility. CLIENT RESPONSABILITY Communicate to us any event date change, we will NOT hold gowns past original wear date.</li>
        <li>Client has 2-3 Weeks from day customer is notified of gown(s) arrival to pick up their merchandise. A $30 Monthly Storage Fee will be charged to customer(s) after 4 weeks since being notified of gown arrival if merchandise is not picked up. Alterations are not included in the price of the gown nor any accessories such as jewelry, headpieces, bracelets or any under garments/petticoats. Gown(s) must be paid in full before any alteration is performed on them.</li>
        <p style="font-weight: bold; margin: 3px 0; font-size: 9px;">NO CHECKS ACCEPTED.</p>

        <li>_________ I understand an appointment will have to be scheduled once the gown(s) arrives for a fitting. Please call before coming to pick up your gown(s)/orders. Many times all gowns are not in premises and are stored at our Storage Facility. <b>PLEASE NOTE WE DO NOT STEAM/IRON ANY DRESS.</b></li>
        <li>_________ <b>Cancelation Policy</b> - Within 24-48 Hours a $100 fitting inconvenience time fee will be deducted from deposit. Cancelations between day 3-7 after date of order, will be deducted a $250 fitting inconvenience time fee. Cancelations between Day 8-14 after date of order will be deducted 50% of deposit amount due to fees related with administrative and supplier cancelation fees. Cancelations after 2 Weeks of an order date wont be accepted and deposit will be forfeit/lost. <b>Cancelation for In-Stock Special Orders </b> - If a gown is in Stock at a designers warehouse for immediate shipping, we wont be able to cancel or return any deposits as the gown are typically shipped right away ordered and shipped right away.</li>
        <li>I further understand that I will not hold this store liable for any alteration inaccuracies or errors. I also understand I will not hold the store liable for any delays in production caused by manufacturer or delivery delays by shipping companies. All special orders can take approximately 6-8 Months to arrive, unless otherwise specified by our sales associate.</li>
        <li><span style="color:#ea2205">_________ I understand that all In Store sales are final and deposits or payments are not returnable nor exchangeable. No Exceptions. Special Order cancelations are stated above. I have read and understand all Store Policies and agree to the terms and conditions therein.</span></li>
    </ul>

    <!-- Firma del cliente -->
    <div class="signature-area">
        <p style="margin-bottom: 15px;">Customer Print Name: ___________________________</p>
        <p>X________________________ (Signature) _______________ (Date)</p>
        <p class="footer">{{ now()->format('m/d/Y h:i A') }} | Page 1</p>
    </div>
</body>
</html>