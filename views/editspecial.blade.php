@extends('LayoutDresses.layout')

@section('ContenidoSite-01')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Orden #{{ $orden->id }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos personalizados adicionales */
        #suggestions, #contactSuggestions {
            border: 1px solid #ccc;
            max-width: 300px;
            display: none;
            position: absolute;
            background: white;
            z-index: 1000;
        }
        .suggestion, .contactSuggestion {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }
        .suggestion:hover, .contactSuggestion:hover {
            background-color: #f0f0f0;
        }
        .card {
            border-radius: 2px;
            box-shadow: 0 0 0 1px #e2e5e8;
            border: none;
            margin-bottom: 30px;
            transition: all 0.5s ease-in-out;
            --bs-body-color: #686c71;
            height: 260px !important;
        }
    </style>
</head>
<body class="container mt-5">
    <!-- Modal para creación de cliente (igual que en create) -->
   <div class="card-body">
        <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Client Creation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name:</label>
                                    <input type="text" id="contactName" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name:</label>
                                    <input type="text" id="contactLastName" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email:</label>
                                    <input type="email" id="contactEmail" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone:</label>
                                    <input type="text" id="contactPhone" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>City:</label>
                                    <input type="text" id="contactCity" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Address:</label>
                                    <input type="text" id="contactAddress" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Store:</label>
                                    <select id="contactStore" class="form-control">
                                        @foreach($tienda as $tienda)
                                            <option value="{{$tienda->id}}">{{$tienda->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Event Type:</label>
                                    <input type="text" id="contactEventType" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Event Date:</label>
                                    <input type="date" id="contactEventDate" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="saveContactBtn" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="exampleModalLivec" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">Create Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Name:</label>
                                        <input type="text" id="productName" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Color:</label>
                                        <input type="text" id="productColor" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Size:</label>
                                        <input type="text" id="productSize" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Price:</label>
                                        <input type="number" id="productPrice" class="form-control" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveProductBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>

    <div class="container">  
        <div class="row">  
            <!-- Espacio para visualizar el contacto seleccionado -->
            <div id="contactDisplay" class="p-2 col-lg-4">
                <div class="card card-body">
                    <p><strong><b>Selected Client:</b></strong></p>
                    <p id="selectedContact" style="color:red">
                        @if($orden->cliente)
                            {{ $orden->cliente->nombres }} {{ $orden->cliente->apellidos }} - {{ $orden->cliente->telefono }}
                        @else
                            No client selected.
                        @endif
                    </p>
                    <label><strong>Search Client:</strong></label>
                    <input type="text" id="searchClient" class="form-control" placeholder="Buscar cliente..." autocomplete="off">
                    <div id="contactSuggestions" style="color:green;"></div>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModalLive">Add Contact Manually</button>
                    <input type="hidden" id="cliente_id" value="{{ $orden->cliente_id ?? '' }}">
                </div>
            </div>

            <!-- Información de la compra -->
            <div id="contactDisplay" class="p-1 col-lg-4">
                <div class="card card-body">
                    <div class="form-group mt-4">
                        <label><strong>Event Date:</strong></label>
                        <input type="date" id="purchaseDate" class="form-control" value="{{ $orden->fecha_compra->format('Y-m-d') }}">
                        <label><strong>Seller:</strong></label>
                        <select name="vendedor" id="purchaseVendedor" class="form-control">
    @foreach($vendedores as $vendedor)
        <option value="{{ $vendedor->id }}" {{ $orden->vendedor == $vendedor->id ? 'selected' : '' }}>
            {{ $vendedor->name }} {{ $vendedor->last_name }}
        </option>
    @endforeach
</select>
                    </div>
                </div>
            </div>

            <!-- Búsqueda de productos -->
            <div id="contactDisplay" class="p-2 col-lg-4">
                <div class="card card-body">
                    <div class="form-group mt-4">
                        <input type="text" id="search" class="form-control" placeholder="Buscar producto..." autocomplete="off">
                        <div id="suggestions"></div>
                        <button type="button" id="addProductBtn" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModalLivec">Add Product Manually</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de productos -->
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Size</th>
                <th>Color</th>
                <th>Discount (%)</th>
                <th>Tax (%)</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTable">
            @foreach($orden->productos as $producto)
                <tr data-index="{{ $loop->index }}">
                    <td>{{ $producto->nombre }}</td>
                    <td><input type="number" class="quantity" id="quantity" value="{{ $producto->pivot->cantidad }}" min="1" data-index="{{ $loop->index }}"></td>
                    <td><input type="text" class="size" id="size" value="{{ $producto->pivot->size }}" data-index="{{ $loop->index }}">
                    </td>
                    <td><input type="text" class="color" id="color" value="{{ $producto->pivot->color }}" data-index="{{ $loop->index }}"></td>
                    <td><input type="number" class="discount" id="discount" value="{{ $producto->pivot->descuento }}" min="0" data-index="{{ $loop->index }}"></td>
                    <td>
                         <select class="form-control tax" data-index="{{ $loop->index }}">
                        <option value="0" {{ $producto->pivot->impuesto_total == 0 ? 'selected' : '' }}>Sin Taxes (0%)</option>
                        @foreach($impuestos as $impuesto)
                            <option value="{{ $impuesto->id }}" {{ $producto->pivot->impuesto_total == $impuesto->id ? 'selected' : '' }}>
                                {{ $impuesto->ciudad }} {{ $impuesto->sufijo }} ({{ $impuesto->valor }}%)
                            </option>
                        @endforeach
                    </select>

                    </td>
                    <td>{{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                    <td class="total">{{ number_format($producto->pivot->total, 2) }}</td>
                    <td><button class="delete" data-index="{{ $loop->index }}">❌</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="container">  
        <div class="row">  
            <!-- Observaciones -->
            <div id="contactDisplay" class="p-2 mt-4 col-lg-6">
                <div class="card card-body">
                    <label><strong>Observations:</strong></label>
                    <textarea id="observations" class="form-control" rows="3" placeholder="Write any observations here..">{{ $orden->observaciones }}</textarea>
                </div>
            </div>

            <!-- Resumen de la compra -->
            <div id="summary" class="p-2 mt-4 col-lg-6">
                <div class="card card-body">
                    <p><strong>Subtotal:</strong> $<span id="subtotal">{{ number_format($orden->subtotal, 2) }}</span></p>
                    <p><strong>Total Tax:</strong> $<span id="taxTotal">{{ number_format($orden->impuesto_total, 2) }}</span></p>
                    <p><strong>Total:</strong> $<span id="grandTotal">{{ number_format($orden->total, 2) }}</span></p>
                    <label><strong>Advancement:</strong></label>
                    <input type="number" id="advancePayment" class="form-control" step="0.01" value="{{ $orden->adelanto }}">
                    <p><strong>Amount Owed:</strong> $<span id="amountDue">{{ number_format($orden->monto_adeudado, 2) }}</span></p>
                </div>
            </div>


            <div id="summary" class="p-2 mt-4 col-lg-12">
                <div class="card card-body">
                    <div class="row">
                   

                    <div class="form-group col-md-4">
               
                    <label><strong>Advancement1:</strong></label>
                    <input type="number" id="advancePayment1" class="form-control" step="0.01" value="{{ $orden->adelanto1  ?? '0'}}">
                    
                    <label>Date:</label>
                    <input type="date" id="advanceDate1" class="form-control" value="{{ $orden->date1 ?? '0000-00-00' }}">

                    <label>Received by:</label>
                    <select name="vendedor" id="advanceReceivedBy1" class="form-control">
                     @foreach($vendedores as $vendedor)
                      <option value="{{ $vendedor->id }}" {{ $orden->user1 == $vendedor->id ? 'selected' : '' }}>
                      {{ $vendedor->name }} {{ $vendedor->last_name }}
                      </option>
                     @endforeach
                    </select>
               
                    </div>

                     <div class="form-group col-md-4">
                    <label><strong>Advancement2</strong></label>
                    <input type="number" id="advancePayment2" class="form-control" step="0.01" value="{{ $orden->adelanto2 ?? '0' }}">
                    <label>Date:</label>
                    <input type="date" id="advanceDate2" class="form-control" value="{{ $orden->date2 ?? '0000-00-00' }}">
                     <label>Received by:</label>
                    <select name="vendedor" id="advanceReceivedBy2" class="form-control">
                     @foreach($vendedores as $vendedor)
                      <option value="{{ $vendedor->id }}" {{ $orden->user2 == $vendedor->id ? 'selected' : '' }}>
                      {{ $vendedor->name }} {{ $vendedor->last_name }}
                      </option>
                     @endforeach
                    </select>
                    </div>

                     <div class="form-group col-md-4">
                    <label><strong>Advancement3:</strong></label>
                    <input type="number" id="advancePayment3" class="form-control" step="0.01" value="{{ $orden->adelanto3 ?? '0'}}">
                    <label>Date:</label>
                    <input type="date" id="advanceDate3" class="form-control" value="{{ $orden->date3 ?? '0000-00-00' }}">
                     <label>Received by:</label>
                    <select name="vendedor" id="advanceReceivedBy3" class="form-control">
                     @foreach($vendedores as $vendedor)
                      <option value="{{ $vendedor->id }}" {{ $orden->user3 == $vendedor->id ? 'selected' : '' }}>
                      {{ $vendedor->name }} {{ $vendedor->last_name }}
                      </option>
                     @endforeach
                    </select>
                </div>
                   </div>
                 
                </div>
            </div>
        </div>
    </div>


    <!-- Botón para actualizar la venta -->
    <button id="guardarVentaBtn" class="btn btn-success mt-0 w-100">Update Sale</button>
    <div class="d-flex gap-2 mt-3">
    <a href="{{ route('orders.view', $orden->id) }}" class="btn btn-info flex-grow-1" target="_blank">
        <i class="fas fa-eye"></i> Ver Factura
    </a>
    <a href="{{ route('orders.download', $orden->id) }}" class="btn btn-primary flex-grow-1">
        <i class="fas fa-download"></i> Descargar PDF
    </a>
</div>

  <script>
$(document).ready(function () {

 // AUTOCOMPLETE SEARCH PARA PRODUCTOS
            $("#search").on("keyup", function () {
                let query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('dresses.search') }}", // Ruta para buscar productos
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            let suggestions = $("#suggestions");
                            suggestions.empty().show();
                            data.forEach(product => {
                                suggestions.append("<div class='suggestion' data-id='" + product.id + "' data-name='" + product.nombre + "' data-price='" + product.precio + "'>" + product.nombre + "</div>");
                            });
                        }
                    });
                } else {
                    $("#suggestions").hide();
                }
            });

            // SELECCIONAR PRODUCTO DESDE AUTOCOMPLETE
            $(document).on("click", ".suggestion", function () {
                let id = $(this).data("id");
                let name = $(this).data("name");
                let price = $(this).data("price");
                addProductToTable(name, price, id); // Pasar el ID del producto
                $("#suggestions").hide();
            });

            // MOSTRAR POPUP PARA NUEVO PRODUCTO
            $("#addProductBtn").click(function () {
                $("#overlay, #popup").show();
            });

            // OCULTAR POPUP DE PRODUCTO
            $("#closePopupBtn").click(function () {
                $("#overlay, #popup").hide();
            });

            $("#saveProductBtn").click(function () {
    let name = $("#productName").val();
    let color = $("#productColor").val();
    let size = $("#productSize").val();
    let price = parseFloat($("#productPrice").val()) || 0;
    let tax = parseFloat($("#productTax").val()) || 0;

    // Enviar el producto al servidor para crearlo
    $.ajax({
        url: "{{ route('dresses.venta') }}", // Ajusta esta ruta según tu API
        type: "POST",
        data: {
            nombre: name,
            precio: price,
            color: color,
            talla: size
        },
        success: function (response) {
            // Agregar el producto con el ID real de la base de datos
            addProductToTable(name, price, response.id, color, size, tax);
            
            // Ocultar el modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalLivec'));
            modal.hide();

            // Limpiar los campos
            $("#productName, #productColor, #productSize, #productPrice").val("");
        },
        error: function (xhr) {
            alert("Error al crear el producto: " + xhr.responseJSON.message);
        }
    });
});



            // FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA
function addProductToTable(name, price, id = null, color = "#000000", size = "0") {
    let tax = 0; // Valor predeterminado

     // Si es un producto nuevo, obtener el tax del modal
    if (id === null) {
        tax = parseFloat($("#productTax").val()) || 0;
    }
    
    productList.push({
        id: id || Date.now(), // Usar un ID temporal si no existe
        name,
        price,
        quantity: 1,
        size,
        color,
        discount: 0,
        tax: tax,
        total: 0 // Inicializar el total
    });
    calculateTotals(); // Recalcular todos los totales
    renderProductTable(); // Renderizar la tabla de productos
}

    // Preparar los datos en PHP primero
    <?php
    $productosArray = [];
    foreach ($orden->productos as $producto) {
        $productosArray[] = [
            'id' => $producto->id,
            'name' => $producto->nombre,
            'price' => $producto->pivot->precio_unitario,
            'quantity' => $producto->pivot->cantidad,
            'size' => $producto->pivot->talla,
            'color' => $producto->pivot->color,
            'discount' => $producto->pivot->descuento,
            'tax' => $producto->pivot->impuesto,
            'total' => $producto->pivot->total
        ];
    }
    
    $contactoArray = $orden->cliente ? [
        'id' => $orden->cliente->id,
        'name' => $orden->cliente->nombres.' '.$orden->cliente->apellidos,
        'phone' => $orden->cliente->telefono
    ] : null;
    ?>

    // Usar los datos preparados
    let productList = @json($productosArray);
    let selectedContact = @json($contactoArray);

    // Configurar el token CSRF en las solicitudes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Función para calcular totales
    function calculateTotals() {
        let subtotal = 0;
        let taxTotal = 0;
        
        // Recalcular todos los productos
        productList.forEach(product => {
            const price = parseFloat(product.price) || 0;
            const quantity = parseInt(product.quantity) || 0;
            const discount = parseFloat(product.discount) || 0;
            const tax = parseFloat(product.tax) || 0;
            
            // Calcular precio con descuento
            const priceAfterDiscount = price * (1 - discount / 100);
            
            // Calcular subtotal y tax
            const productSubtotal = quantity * priceAfterDiscount;
            const productTax = productSubtotal * (tax / 100);
            
            subtotal += productSubtotal;
            taxTotal += productTax;
            
            // Actualizar total del producto
            product.total = (productSubtotal + productTax).toFixed(2);
        });
        
        const grandTotal = subtotal + taxTotal;
        const advance = parseFloat($("#advancePayment").val()) || 0;
        const advance1 = parseFloat($("#advancePayment1").val()) || 0;
        const advance2 = parseFloat($("#advancePayment2").val()) || 0;
        const advance3 = parseFloat($("#advancePayment3").val()) || 0;
        const amountDue = grandTotal - advance - advance1 - advance2 - advance3;
        
        // Actualizar la UI
        $("#subtotal").text(subtotal.toFixed(2));
        $("#taxTotal").text(taxTotal.toFixed(2));
        $("#grandTotal").text(grandTotal.toFixed(2));
        $("#amountDue").text(amountDue.toFixed(2));
        
        // Actualizar los totales en la tabla
        $(".total").each(function(index) {
            $(this).text(productList[index].total);
        });
    }

    // Función para renderizar la tabla de productos
    function renderProductTable() {
    let tableBody = $("#productTable");
    tableBody.empty();
    
    productList.forEach((product, index) => {
        let taxOptions = `
            <option value="0" ${product.tax == 0 ? 'selected' : ''}>Sin Taxes (0%)</option>
            ${@json($impuestos).map(imp => `
                <option value="${imp.valor}" ${product.tax == imp.valor ? 'selected' : ''}>
                    ${imp.ciudad} ${imp.sufijo} (${imp.valor}%)
                </option>
            `).join('')}
        `;
        
        let row = `
            <tr data-index="${index}">
                <td>${product.name}</td>
                <td><input type="number" class="form-control quantity" value="${product.quantity}" min="1" data-index="${index}"></td>
                <td><input type="text" class="form-control size" value="${product.size}" data-index="${index}"></td>
                <td><input type="text" class="form-control color" value="${product.color}" data-index="${index}"></td>
                <td><input type="number" class="form-control discount" value="${product.discount}" min="0" max="100" step="0.01" data-index="${index}"></td>
                <td>
                    <select class="form-control tax" data-index="${index}">
                        ${taxOptions}
                    </select>
                </td>
                <td>${parseFloat(product.price).toFixed(2)}</td>
                <td class="total">${product.total}</td>
                <td><button class="btn btn-danger delete" data-index="${index}">Eliminar</button></td>
            </tr>`;
        tableBody.append(row);
    });
}

    // Eventos para actualización automática
    $(document).on('input', '.quantity, .discount, .tax, #advancePayment, #advancePayment1, #advancePayment2, #advancePayment3', function() {
        const index = $(this).data('index');
        const value = $(this).val();
        
        if ($(this).hasClass('quantity')) {
            productList[index].quantity = parseInt(value) || 0;
        } else if ($(this).hasClass('discount')) {
            productList[index].discount = parseFloat(value) || 0;
        } else if ($(this).hasClass('tax')) {
            productList[index].tax = parseFloat(value) || 0;
        }
        
        calculateTotals();
    });

    $(document).on('change', '.size, .color', function() {
        const index = $(this).data('index');
        const value = $(this).val();
        
        if ($(this).hasClass('size')) {
            productList[index].size = value;
        } else {
            productList[index].color = value;
        }
    });

    $(document).on('click', '.delete', function() {
        const index = $(this).data('index');
        productList.splice(index, 1);
        renderProductTable();
        calculateTotals();
    });

    // Inicializar la tabla y los totales
    renderProductTable();
    calculateTotals();

    // Evento para guardar la venta
    $("#guardarVentaBtn").click(function () {
        const vendedorId = $("#purchaseVendedor").val();
        const vendedorId1 = $("#advanceReceivedBy1").val();
        
        if (!vendedorId || isNaN(vendedorId)) {
            alert('Por favor selecciona un vendedor válido');
            return;
        }

         if (!vendedorId1 || isNaN(vendedorId1)) {
            alert('Por favor selecciona un vendedor válido');
            return;
        }

        if (!selectedContact || !selectedContact.id) {
            alert("Por favor, selecciona o crea un cliente antes de guardar la venta.");
            return;
        }

        // Preparar los datos de productos
        let productosData = productList.map(p => ({
            id: p.id || null,
            name: p.name,
            price: parseFloat(p.price),
            quantity: parseInt(p.quantity),
            size: p.size,
            color: p.color,
            discount: parseFloat(p.discount),
            tax: parseFloat(p.tax),
            total: parseFloat(p.total)
        }));

        // Crear objeto de datos para enviar
        let ventaData = {
            cliente_id: selectedContact.id,
            fecha_compra: $("#purchaseDate").val(),
            vendedor: $("#purchaseVendedor").val(),
            observaciones: $("#observations").val(),
            date1: $("#advanceDate1").val() || '0000-00-00',
            date2: $("#advanceDate2").val() || '0000-00-00',
            date3: $("#advanceDate3").val() || '0000-00-00',
            user1: $("#advanceReceivedBy1").val() || 0,
            user2: $("#advanceReceivedBy2").val() || 0,
            user3: $("#advanceReceivedBy3").val() || 0,
            productos: productosData,
            subtotal: parseFloat($("#subtotal").text()),
            impuesto_total: parseFloat($("#taxTotal").text()),
            total: parseFloat($("#grandTotal").text()),
            adelanto: parseFloat($("#advancePayment").val()) || 0,
            adelanto1: parseFloat($("#advancePayment1").val()) || 0,
            adelanto2: parseFloat($("#advancePayment2").val()) || 0,
            adelanto3: parseFloat($("#advancePayment3").val()) || 0,
            monto_adeudado: parseFloat($("#amountDue").text())
        };

        // Configurar AJAX correctamente
        $.ajax({
            url: "/orders/" + {{ $orden->id }},
            type: "PUT",
            data: JSON.stringify(ventaData),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (response) {
                alert("Venta actualizada correctamente");
                window.location.href = "/orders/" + {{ $orden->id }};
            },
            error: function (xhr) {
                console.error(xhr.responseJSON);
                alert("Error al actualizar: " + 
                    (xhr.responseJSON.message || xhr.responseJSON.error || 'Error desconocido'));
            }
        });
    });
});
</script>


</body>
</html>
@endsection