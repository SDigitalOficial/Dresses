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
        p{
            font-size: 10px;
        }
        .compact { margin: 2px 0; }
        .logo { height: 60px; }
        h1 { margin: 0; font-size: 14px; }
        h2 { margin: 2px 0; font-size: 12px; }
        h3 { margin: 5px 0; font-size: 11px}
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
            <h1 style="color: #000000; font-size: 18px">#Special Order - {{$orden->prefijo}}</h1>
            @elseif($orden->identidad == 'L')
            <h1 style="color: #000000; font-size: 18px">#Layaway - {{$orden->prefijo}}</h1>
            @elseif($orden->identidad == 'RENTAL')
            <h1 style="color: #000000; font-size: 18px">#RENTAL ORDER - R{{$orden->prefijo}}</h1>
            @endif
            <br>
            <h1>{{$tienda->nombre}} | {{$tienda->website}}</h1>
            <p class="compact">{{$tienda->direccion}}</p>
            <p class="compact">Phone: {{$tienda->telefono}}</p>
            <p class="compact">{{$tienda->website}}</p>
            <p class="compact">{{$tienda->email}}</p>
            @foreach($tienda as $tienda)
            @endforeach
            @if($orden->identidad == 'RENTAL')
            <p style="color:#ff7410"><b>Pick up Date:</b>{{ $orden->pickDate ? $orden->pickDate->format('m/d/Y') : 'N/A' }}<br>
            <b>Return Date:</b>{{ $orden->returnDate ? $orden->returnDate->format('m/d/Y') : 'N/A' }} </p>
            @ENDIF
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
        <p class="compact">Order Date: {{ $orden->fecha_compraO ? $orden->fecha_compraO->format('m/d/Y') : 'N/A' }}</p>
        <p class="compact">Sales Associate: {{ $orden->vendedorRelacion->name }} {{ $orden->vendedorRelacion->last_name }}</p>
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
            <td class="text-right">Deposit</td>
            <td class="text-right">${{ number_format($orden->adelanto, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto1 > 0)
          <tr>
            <td class="text-right">Deposit 2</td>
            <td class="text-right">${{ number_format($orden->adelanto1, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto2 > 0)
          <tr>
            <td class="text-right">Deposit 3</td>
            <td class="text-right">${{ number_format($orden->adelanto2, 2) }}</td>
          </tr>
        @endif

        @if($orden->adelanto3 > 0)
          <tr>
            <td class="text-right">Deposit 4</td>
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
    @if($orden->identidad == 'RENTAL')

     <h3 style="text-align: center;">RENTAL AGREEMENT / CONTRATO DE RENTA DE VESTIDO</h3>

<p>1. Gowns will be returned in the same condition that it was given to the customer, with the exception of slight wear (dust/dirt on underside of hem/train and slight perspiration only.) Tears/Rips/Cuts or Missing pieces such as sleeves, shawls, capes, will be deducted from the deposit of gown. If the condition of a ripped gown can't be repaired due to location, large size of rip/cut the entire deposit will be forfeit and the gown will be declared unusable.</p>

<p>2. Gown stains (like motor oil, grease, blood, food, chemicals etc) and any bodice stains inside or outside of the gown will result in a hold of deposit until the garment is returned from a professional dry cleaner/vendor. Costs associated with the repair or stain removal would be charged or deducted from customers' deposit. Should the damage be so severe that the gown can not be cleaned or repaired to its original state, the full retail price of the gown will be charged to the customer.</p>

<p>3. <span style="color:red">The rental period is from ______ to ______ and, ______ (Client Name)</span> understands the responsibility for the return of the gown within this period. Any changes the client must notify "Quince Dresses" if they need to extend the rental time period.</p>

<p>4. f a customer fails to return the gown within the allotted time period. A charge of $80 per late day will be charged until the gown is returned.</p>

<p>5. Should the gown fail to be returned after 4 days of its due date, the deposit will be forfeit and we will charge the full retail price of the gown. These charges will be applied to clients credit card if the retail amount exceeds more than the deposit amount left at the store. At this point the gown will be written off as a theft and not returnable.</p>

<p>6. I understand that all deposits and payments for this transaction are to be paid in <span style="color:red">CASH ONLY.</span> Due to credit card fees, and risk of gowns not returning on time, we will only work rentals on a Cash Only basis. No Checks or Credit Cards are allowed as a form of payment for the rental or deposit of the gown.</p>

<p>7. Please note we will need proof of identification, a <span style="color:red">VALID ID</span> is required in order to rent any gown from our premises.</p>

<p>8. Please NOTE we are not responsible for any issues with gown that could happen from previous rentals. For example: If the gown was rented a few weeks prior and it's now in an unusable state, we will not be able to find or purchase another identical gown in the same style, color and size in order to fulfill your rental. If this situation ever happens we will only be held liable to return your entire deposit and rental fee paid until that point and not be held responsible for anything else caused by this issue. We are also not responsible for any slight changes/repairs or alterations in the gown being rented due to repairs from previous rentals. Please NOTE you are renting a gown, and not Buying a brand New one. Chances are it has been rented before or will be rented again after you use it.</p>

<p style="margin-bottom: 30px; margin-top: 30px; ">Gown inspected by: _________________
Comments: ____________________

Client Print Name: ______________________</p>
<p>Signature: __________________
Date: ________________</p>   

    @else
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
        <p style="margin-bottom: 15px; ">Customer Print Name: ___________________________</p>
        <p>X________________________ (Signature) _______________ (Date)</p>
        <p class="footer">{{ now()->format('m/d/Y h:i A') }} | Page 1</p>
    </div>
        @endif
</body>
</html>