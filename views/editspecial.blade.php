@extends('LayoutDresses.layout')

@section('ContenidoSite-01')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Orden #{{ $orden->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            height: 340px !important;
        }
           .suggestion.bloqueado {
        opacity: 0.6;
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    
    .suggestion.bloqueado:hover {
        background-color: #f8f9fa !important;
    }
    
    .fa-check-circle {
        font-size: 14px;
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

<!-- En el formulario de producto -->
<div class="invalid-feedback product-error" id="productNameError"></div>
<div class="invalid-feedback product-error" id="productPriceError"></div>
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
                    <h3>#Invoice - {{ $orden->prefijo }}</h3>
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
                        <label><strong>Order Date:</strong></label>
                        <input type="date" id="purchaseDate" class="form-control" value="{{ $orden->created_at->format('Y-m-d') }}" disabled>
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
                <th>Discount ($)</th>
                <th>Tax (%)</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Pickup</th>
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
                           <option value="{{ $impuesto->valor }}" {{ $producto->pivot->impuesto_total == $impuesto->valor ? 'selected' : '' }}>
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

    {{-- Form oculto para enviar los IDs de productos al backend y descargar el PDF --}}
<form id="pdfForm" method="POST" action="{{ route('productos.pdf') }}" class="d-none">
    @csrf
</form>

<div class="d-flex gap-2 mt-2">
    <button type="button" id="btnGenerarFichas" class="btn btn-primary">
        Generar Pickup PDF
    </button>
    <button type="button" id="btnSelectAllFichas" class="btn btn-outline-secondary">
        Seleccionar/Deseleccionar todo
    </button>
</div>

    <div class="container">  
        <div class="row">  
            <!-- Observaciones -->
            <div id="contactDisplay" class="p-2 mt-4 col-lg-6">
                <div class="card card-body">
                    <label><strong>Observations:</strong></label>
                    <textarea id="observations" class="form-control" rows="3" placeholder="Write any observations here..">{{ $orden->observaciones }}</textarea>

                    <label>Status</label>
                    <select name="payment_status" id="paymentStatus" class="form-control">
                     <option value="open" {{ $orden->status == 'open' ? 'selected' : '' }}>Open</option>
                     <option value="ordered" {{ $orden->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                     <option value="storage" {{ $orden->status == 'storage' ? 'selected' : '' }}>Storage</option>
                     <option value="closed" {{ $orden->status == 'closed' ? 'selected' : '' }}>Closed</option>
                     <option value="cancel" {{ $orden->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                    </select>
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
                    <label>Method Payment:</label>
                    <select name="payment_method" id="paymentMethod" class="form-control">
                     <option value="cash" {{ $orden->method == 'cash' ? 'selected' : '' }}>Cash</option>
                     <option value="credit" {{ $orden->method == 'credit' ? 'selected' : '' }}>Credit</option>
                     <option value="debit" {{ $orden->method == 'debit' ? 'selected' : '' }}>Debit</option>
                     <option value="zelle" {{ $orden->method == 'zelle' ? 'selected' : '' }}>Zelle</option>
                    </select>
                    <br>
                    <h3><strong>Amount Owed:</strong> $<span id="amountDue">{{ number_format($orden->monto_adeudado, 2) }}</span></h3>
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

                    <label>Method Payment1:</label>
                    <select name="payment_method" id="paymentMethod1" class="form-control">
                      <option value="cash" {{ $orden->method1 == 'cash' ? 'selected' : '' }}>Cash</option>
                     <option value="credit" {{ $orden->method1 == 'credit' ? 'selected' : '' }}>Credit</option>
                     <option value="debit" {{ $orden->method1 == 'debit' ? 'selected' : '' }}>Debit</option>
                     <option value="zelle" {{ $orden->method1 == 'zelle' ? 'selected' : '' }}>Zelle</option>
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

                    <label>Method Payment2:</label>
                    <select name="payment_method" id="paymentMethod2" class="form-control">
                      <option value="cash" {{ $orden->method2 == 'cash' ? 'selected' : '' }}>Cash</option>
                     <option value="credit" {{ $orden->method2 == 'credit' ? 'selected' : '' }}>Credit</option>
                     <option value="debit" {{ $orden->method2 == 'debit' ? 'selected' : '' }}>Debit</option>
                     <option value="zelle" {{ $orden->method2 == 'zelle' ? 'selected' : '' }}>Zelle</option>
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

                    <label>Method Payment3:</label>
                    <select name="payment_method" id="paymentMethod3" class="form-control">
                     <option value="cash" {{ $orden->method3 == 'cash' ? 'selected' : '' }}>Cash</option>
                     <option value="credit" {{ $orden->method3 == 'credit' ? 'selected' : '' }}>Credit</option>
                     <option value="debit" {{ $orden->method3 == 'debit' ? 'selected' : '' }}>Debit</option>
                     <option value="zelle" {{ $orden->method3 == 'zelle' ? 'selected' : '' }}>Zelle</option>
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

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Función para mostrar notificación
    function showNotification(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }

    // AUTOCOMPLETE SEARCH PARA PRODUCTOS
    // AUTOCOMPLETE SEARCH PARA PRODUCTOS (MODIFICADO)
    $("#search").on("keyup", function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('dresses.search') }}",
                type: "GET",
                data: { query: query },
                success: function (data) {
                    let suggestions = $("#suggestions");
                    suggestions.empty().show();
                    
                    if (data.length === 0) {
                        suggestions.append("<div class='suggestion'>No se encontraron productos</div>");
                    } else {
                        data.forEach(product => {
                            // Verificar si el producto ya está en la orden
                            const yaAgregado = productList.some(p => p.id === product.id);
                            const bloqueadoClass = yaAgregado ? 'bloqueado' : '';
                            const iconoBloqueado = yaAgregado ? '<i class="fas fa-check-circle ms-2 text-success"></i>' : '';
                            
                            suggestions.append(`
                                <div class='suggestion ${bloqueadoClass}' 
                                     data-id='${product.id}' 
                                     data-name='${product.nombre}' 
                                     data-price='${product.precio}'
                                     ${yaAgregado ? 'title="Este producto ya está en la orden"' : ''}>
                                    ${product.nombre} - $${product.precio} ${iconoBloqueado}
                                </div>
                            `);
                        });
                    }
                }
            });
        } else {
            $("#suggestions").hide();
        }
    });

    // SELECCIONAR PRODUCTO DESDE AUTOCOMPLETE (MODIFICADO)
    $(document).on("click", ".suggestion:not(.bloqueado)", function () {
        let id = $(this).data("id");
        let name = $(this).data("name");
        let price = $(this).data("price");
        addProductToTable(name, price, id);
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

    // Validar campos del producto
    function validateProductFields() {
        let isValid = true;
        let missingFields = [];
        let name = $("#productName").val().trim();
        let price = $("#productPrice").val().trim();
        
        // Resetear mensajes de error
        $(".product-error").text("").hide();
        
        // Validar nombre
        if (name.length < 2) {
            missingFields.push("Nombre del producto (mínimo 2 caracteres)");
            $("#productNameError").text("El nombre del producto debe tener al menos 2 caracteres").show();
            isValid = false;
        }
        
        // Validar precio
        if (!price || isNaN(price) || parseFloat(price) <= 0) {
            missingFields.push("Precio (debe ser mayor que 0)");
            $("#productPriceError").text("Ingrese un precio válido mayor que 0").show();
            isValid = false;
        }
        
        if (!isValid) {
            showNotification('Faltan datos', 'Por favor complete: ' + missingFields.join(', '), 'warning');
        }
        
        return isValid;
    }

    $("#saveProductBtn").click(function () {
        if (!validateProductFields()) {
            return;
        }

        let name = $("#productName").val();
        let color = $("#productColor").val();
        let size = $("#productSize").val();
        let price = parseFloat($("#productPrice").val()) || 0;
        let tax = parseFloat($("#productTax").val()) || 0;

        $.ajax({
            url: "{{ route('dresses.venta') }}",
            type: "POST",
            data: {
                nombre: name,
                precio: price,
                color: color,
                talla: size
            },
            success: function (response) {
                addProductToTable(name, price, response.id, color, size, tax);
                $("#overlay, #popup").hide();
                $("#productName, #productColor, #productSize, #productPrice").val("");
                
                showNotification('Éxito', 'Producto creado correctamente', 'success');
            },
            error: function (xhr) {
                let errorMessage = "Error al crear el producto";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ": " + xhr.responseJSON.message;
                }
                showNotification('Error', errorMessage, 'error');
            }
        });
    });

    // FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA
    // FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA (MODIFICADA)
    function addProductToTable(name, price, id = null, color = "#000000", size = "0", tax = 0) {
        // Verificar si el producto ya existe en la orden
        if (id !== null) {
            const productoExistente = productList.find(p => p.id === id);
            if (productoExistente) {
                showNotification('Producto duplicado', `${name} ya está en la orden. Modifica la cantidad si necesitas más.`, 'warning');
                return;
            }
        }

        let existingProduct = productList.find(p => 
            p.id === id || (p.name === name && p.size === size && p.color === color)
        );
        
        if (existingProduct) {
            existingProduct.quantity += 1;
            calculateTotals();
            showNotification('Cantidad actualizada', `${name} - Cantidad aumentada a ${existingProduct.quantity}`, 'info');
        } else {
            productList.push({
                id: id || Date.now(),
                name,
                price,
                quantity: 1,
                size,
                color,
                discount: 0,
                tax: tax,
                total: 0
            });
            showNotification('Producto agregado', `${name} - $${price}`, 'success');
        }
        
        calculateTotals();
        renderProductTable();
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

    let productList = @json($productosArray);
    let selectedContact = @json($contactoArray);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Función para calcular totales con descuentos e impuestos
    function calculateTotals() {
        let subtotal = 0;
        let taxTotal = 0;
        
        productList.forEach(product => {
            const price = parseFloat(product.price) || 0;
            const quantity = parseInt(product.quantity) || 0;
            const discount = parseFloat(product.discount) || 0;
            const tax = parseFloat(product.tax) || 0;
            
            // Calcular precio con descuento
            const priceAfterDiscount = price - discount;
            
            // Calcular subtotal (precio con descuento * cantidad)
            const productSubtotal = quantity * priceAfterDiscount;
            
            // Calcular impuestos sobre el subtotal con descuento
            const productTax = productSubtotal * (tax / 100);
            
            subtotal += productSubtotal;
            taxTotal += productTax;
            
            // Actualizar total del producto (subtotal + impuestos)
            product.total = (productSubtotal + productTax).toFixed(2);
        });
        
        const grandTotal = subtotal + taxTotal;
        const advance = parseFloat($("#advancePayment").val()) || 0;
        const advance1 = parseFloat($("#advancePayment1").val()) || 0;
        const advance2 = parseFloat($("#advancePayment2").val()) || 0;
        const advance3 = parseFloat($("#advancePayment3").val()) || 0;
        const amountDue = grandTotal - advance - advance1 - advance2 - advance3;
        
        $("#subtotal").text(subtotal.toFixed(2));
        $("#taxTotal").text(taxTotal.toFixed(2));
        $("#grandTotal").text(grandTotal.toFixed(2));
        $("#amountDue").text(amountDue.toFixed(2));
        
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
        <td><input type="number" class="form-control discount" value="${product.discount}" min="0" step="0.01" placeholder="$" data-index="${index}"></td>
        <td>
            <select class="form-control tax" data-index="${index}">
                ${taxOptions}
            </select>
        </td>
        <td>$${parseFloat(product.price).toFixed(2)}</td>
        <td class="total">$${product.total}</td>
        <td>
            <input type="checkbox" class="pdf-check" value="${product.id}">
        </td>
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
        const productName = productList[index].name;
        productList.splice(index, 1);
        renderProductTable();
        calculateTotals();
        
        showNotification('Eliminado', `${productName} fue removido`, 'warning');
    });

    // Inicializar la tabla y los totales
    renderProductTable();
    calculateTotals();

    // Evento para guardar la venta
    $("#guardarVentaBtn").click(function () {
        const vendedorId = $("#purchaseVendedor").val();
        const vendedorId1 = $("#advanceReceivedBy1").val();

        
        if (!vendedorId || isNaN(vendedorId)) {
            showNotification('Error', 'Por favor selecciona un vendedor válido', 'error');
            return;
        }

        if (!vendedorId1 || isNaN(vendedorId1)) {
            showNotification('Error', 'Por favor selecciona un vendedor válido para el primer pago', 'error');
            return;
        }

        if (!selectedContact || !selectedContact.id) {
            showNotification('Error', 'Por favor, selecciona o crea un cliente antes de guardar la venta.', 'error');
            return;
        }

        if (productList.length === 0) {
            showNotification('Error', 'Por favor, agrega al menos un producto a la venta.', 'error');
            return;
        }

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
            method: $("#paymentMethod").val() || 0,
            meth: $("#paymentMethod1").val() || 0,
            method1: $("#paymentMethod1").val() || 0,
            method2: $("#paymentMethod2").val() || 0,
            method3: $("#paymentMethod3").val() || 0,
            status: $("#paymentStatus").val() || 0,
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

        Swal.fire({
            title: 'Confirmar actualización',
            html: `¿Estás seguro de actualizar esta orden?<br><br>
                  <b>Cliente:</b> ${selectedContact.name}<br>
                  <b>Total:</b> $${ventaData.total.toFixed(2)}<br>
                  <b>Productos:</b> ${productosData.length}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        Swal.fire({
                            title: '¡Actualización exitosa!',
                            html: `Orden #${response.id} actualizada correctamente<br>
                                  <b>Total:</b> $${ventaData.total.toFixed(2)}`,
                            icon: 'success'
                        }).then(() => {
                            window.location.href = "/orders/" + {{ $orden->id }} + "/edit/";
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = "Error al actualizar la orden";
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMessage += ": " + xhr.responseJSON.message;
                            } else if (xhr.responseJSON.error) {
                                errorMessage += ": " + xhr.responseJSON.error;
                            }
                        }
                        showNotification('Error', errorMessage, 'error');
                    }
                });
            }
        });
    });

// Seleccionar/deseleccionar todos los checkboxes de fichas
$("#btnSelectAllFichas").on("click", function () {
    const checks = $(".pdf-check");
    const allChecked = checks.length && checks.filter(":checked").length === checks.length;
    checks.prop("checked", !allChecked);
});

// Enviar seleccionados al backend (POST normal -> descarga de archivo)
$("#btnGenerarFichas").on("click", function () {
    const selected = $(".pdf-check:checked").map(function(){ return $(this).val(); }).get();

    if (selected.length === 0) {
        return Swal.fire({ icon: 'warning', title: 'Sin selección', text: 'Selecciona al menos un producto.' });
    }
    if (selected.length > 3) {
        return Swal.fire({ icon: 'warning', title: 'Límite excedido', text: 'Solo puedes generar hasta 3 fichas a la vez.' });
    }

    // Limpia y arma el form oculto
    const $form = $("#pdfForm");
    $form.find("input[name='products[]']").remove();
    selected.forEach(id => {
        $form.append(`<input type="hidden" name="products[]" value="${id}">`);
    });

    // Envío normal (no AJAX) para que el navegador descargue el PDF
    $form.trigger("submit");
});

});
</script>


</body>
</html>
@endsection