@extends ('LayoutDresses.layout')
@section('ContenidoSite-01')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autocomplete Search con Popup</title>
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
        /* Estilo para productos bloqueados */
    .suggestion.bloqueado {
        opacity: 0.6;
        background-color: #f8f9fa;
        cursor: not-allowed;
        pointer-events: none;
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
    @if(Request::path() == 'dresses/layaway')
    <h1>Layaway</h1>
    @elseif(Request::path() == 'dresses/specialorders')
    <h1>Especial Order</h1>
    @endif
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
                                    <input type="text" id="contactLastName" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email:</label>
                                    <input type="email" id="contactEmail" class="form-control" re>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone:</label>
                                    <input type="text" id="contactPhone" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone 2:</label>
                                    <input type="text" id="contactPhone2" class="form-control">
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
                                <!--
                                <div class="form-group col-md-6">
                                    <label>Event Date:</label>
                                    <input type="date" id="contactEventDate" class="form-control">
                                </div>
                                -->
                                <div class="invalid-feedback client-error" id="contactNameError"></div>
                                <div class="invalid-feedback client-error" id="contactPhoneError"></div>
                                <div class="invalid-feedback client-error" id="contactEmailError"></div>
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
                    <div id="contactDisplay" class="p-2 col-lg-4">
                        <div class="card card-body">
                            <p><strong><b>Selected Client:</b></strong></p>
                            <p id="selectedContact" style="color:red">No client selected.</p>
                            <label><strong>Search Client:</strong></label>
                            <input type="text" id="searchClient" class="form-control" placeholder="Buscar cliente..." autocomplete="off">
                            <div id="contactSuggestions" style="color:green;"></div>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModalLive">Add Contact Manually</button>
                        </div>
                    </div>
                    <div id="contactDisplay" class="p-1 col-lg-4">
                        <div class="card card-body">
                            <div class="form-group  mt-4">
                                <label><strong>Event Date:</strong></label>
                                <input type="date" id="purchaseDate" class="form-control">
                            </div>
                            <div class="form-group  mt-4">
                                <label><strong>Order Date:</strong></label>
                                <input type="date" id="purchaseDateO" class="form-control">
                                <input type="hidden" id="currentPath" value="{{ Request::path() }}">
                            </div>
                        </div>
                    </div>

                    <div id="contactDisplay" class="p-2 col-lg-4">
                        <div class="card card-body">
                            <div class="form-group mt-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar producto..." autocomplete="off">
                                <div id="suggestions"></div>
                                <button type="button" id="addProductBtn" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModalLivec">Add Product Manually</button>
                            </div>
                            <label><strong>Seller:</strong></label>
                                <select id="purchaseVendedor" class="form-control">
                                    @foreach($user as $user)
                                        <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
            </div>

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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTable"></tbody>
            </table>
            <div class="container">
             <div class="row">
              <div id="contactDisplay" class="p-2 mt-4 col-lg-6">
               <div class="card card-body">
                <div class="row">
                <div class="col-lg-6">
                             <label><strong>Pick Up Date:</strong></label>
                             <input type="date" id="pickDate" class="form-control">
                            </div>
                            <div class="col-lg-6">
                             <label><strong>Return Date:</strong></label>
                             <input type="date" id="returnDate" class="form-control">
                            </div>
                        </div>
                            <br><br>
                            <label><strong>Observations:</strong></label>
                            <textarea id="observations" class="form-control" rows="3" placeholder="Write any observations here.."></textarea>
                             <label>Status</label>
                    <select name="payment_status" id="paymentStatus" class="form-control">
                     <option value="open">Open</option>
                     <option value="ordered">Ordered</option>
                     <option value="storage">Storage</option>
                     <option value="closed">Closed</option>
                     <option value="cancel">Cancel</option>
                    </select>
                        </div>


                    </div>
                    <div id="summary" class=" p-2 mt-4 col-lg-6">
                        <div class="card card-body">
                            <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
                            <p><strong>Total Tax:</strong> $<span id="taxTotal">0.00</span></p>
                            <p><strong>Total:</strong> $<span id="grandTotal">0.00</span></p>
                            <label><strong>Deposit:</strong></label>
                            <input type="number" id="advancePayment" class="form-control" step="0.01" value="0">
                            <label>Method Payment:</label>
                    <select name="payment_method" id="paymentMethod" class="form-control">
                     <option value="cash">Cash</option>
                     <option value="credit">Credit</option>
                     <option value="debit">Debit</option>
                      <option value="zelle">Zelle</option>
                    </select>
                    <br>
                            <h3><strong>Amount Owed:</strong> $<span id="amountDue">0.00</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <button id="guardarVentaBtn" class="btn btn-success mt-0 w-100">Save Sale</button>

            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Add Product Manually</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" id="productName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Color:</label>
                                <input type="text" id="productColor" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Size:</label>
                                <input type="text" id="productSize" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Price:</label>
                                <input type="number" id="productPrice" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="saveProductBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="contactModalLabel">Add Contact Manually</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" id="contactName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" id="contactLastName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" id="contactEmail" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="text" id="contactPhone" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                    <label>Phone 2:</label>
                                    <input type="text" id="contactPhone2" class="form-control">
                                </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" id="contactCity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <input type="text" id="contactAddress" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Store:</label>
                                <input type="text" id="contactStore" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Event Type:</label>
                                <input type="text" id="contactEventType" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Evento Date:</label>
                                <input type="date" id="contactEventDate" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="saveContactBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        let productList = [];
        let selectedContact = null;

        // Configurar el token CSRF en las solicitudes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        // AUTOCOMPLETE SEARCH PARA CLIENTES
        $("#searchClient").on("keyup", function () {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('dresses.client') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let suggestions = $("#contactSuggestions");
                        suggestions.empty().show();
                        data.forEach(client => {
                            suggestions.append("<div class='contactSuggestion' data-id='" + client.id + "' data-name='" + client.nombres + "' data-email='" + client.email + "' data-phone='" + client.telefono + "'>" + client.nombres + "</div>");
                        });
                    }
                });
            } else {
                $("#contactSuggestions").hide();
            }
        });

        // Validar campos del cliente
        function validateClientFields() {
            let isValid = true;
            let missingFields = [];
            let name = $("#contactName").val().trim();
            let phone = $("#contactPhone").val().trim();
            let email = $("#contactEmail").val().trim();
            
            // Resetear mensajes de error
            $(".client-error").text("").hide();
            
            // Validar nombre
            if (name.length < 2) {
                missingFields.push("Nombre (mínimo 2 caracteres)");
                $("#contactNameError").text("El nombre debe tener al menos 2 caracteres").show();
                isValid = false;
            }
            
            // Validar teléfono
            if (phone.length < 7 || !/^[0-9]+$/.test(phone)) {
                missingFields.push("Teléfono (mínimo 7 dígitos)");
                $("#contactPhoneError").text("Ingrese un número de teléfono válido").show();
                isValid = false;
            }
            
            // Validar email si se proporciona
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                missingFields.push("Email (formato válido)");
                $("#contactEmailError").text("Ingrese un email válido").show();
                isValid = false;
            }
            
            if (!isValid) {
                showNotification('Faltan datos', 'Por favor complete: ' + missingFields.join(', '), 'warning');
            }
            
            return isValid;
        }

        // GUARDAR CONTACTO MANUALMENTE
        $("#saveContactBtn").click(function () {
            if (!validateClientFields()) {
                return;
            }

            let name = $("#contactName").val().trim();
            let lastName = $("#contactLastName").val().trim();
            let phone = $("#contactPhone").val().trim();
            let phone2 = $("#contactPhone2").val().trim();
            let email = $("#contactEmail").val().trim();
            let city = $("#contactCity").val().trim();
            let address = $("#contactAddress").val().trim();
            let store = $("#contactStore").val().trim();
            let eventType = $("#contactEventType").val().trim();
            let eventDate = $("#contactEventDate").val().trim();

            $.ajax({
                url: "{{ route('clientes.store') }}",
                type: "POST",
                data: {
                    nombres: name,
                    apellidos: lastName,
                    telefono: phone,
                    telefono2: phone2,
                    ciudad: city,
                    email: email,
                    direccion: address,
                    tienda: store,
                    tipo_evento: eventType,
                    fecha_evento: eventDate
                },
                success: function (response) {
                    selectedContact = {
                        id: response.id,
                        name: response.nombres + " " + response.apellidos,
                        phone: response.telefono,
                        phone2: response.telefono2
                    };
                    $("#selectedContact").text(`${selectedContact.name} - ${selectedContact.phone}`);
                    var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalLive'));
                    modal.hide();
                    $("#contactName, #contactLastName, #contactPhone, #contactPhone2, #contactCity, #contactAddress, #contactStore, #contactEventType, #contactEventDate").val("");
                    
                    showNotification('Éxito', 'Cliente creado correctamente', 'success');
                },
                error: function (xhr) {
                    let errorMessage = "Error al guardar el cliente";
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage += ": " + Object.values(xhr.responseJSON.errors).join(", ");
                    }
                    showNotification('Error', errorMessage, 'error');
                }
            });
        });

        // SELECCIONAR CLIENTE DESDE AUTOCOMPLETE
        $(document).on("click", ".contactSuggestion", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let phone = $(this).data("phone");
            let phone2 = $(this).data("phone2");
            selectedContact = { id, name, phone, phone2 };
            $("#selectedContact").text(`${name} - ${phone} - ${phone2}`);
            $("#contactSuggestions").hide();
            
            showNotification('Cliente seleccionado', `Se ha seleccionado a ${name}`, 'info');
        });

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

        // GUARDAR PRODUCTO MANUALMENTE
        $("#saveProductBtn").click(function () {
            if (!validateProductFields()) {
                return;
            }

            let name = $("#productName").val().trim();
            let color = $("#productColor").val().trim();
            let size = $("#productSize").val().trim();
            let price = parseFloat($("#productPrice").val()) || 0;

            addProductToTable(name, price, null, color, size);

            var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalLivec'));
            modal.hide();

            $("#productName, #productColor, #productSize, #productPrice").val("");
            
            showNotification('Éxito', 'Producto creado correctamente', 'success');
        });

        // FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA (MODIFICADA)
    function addProductToTable(name, price, id = null, color = "#000000", size = "0") {
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
            calculateTotal(existingProduct);
            showNotification('Cantidad actualizada', `${name} - Cantidad aumentada a ${existingProduct.quantity}`, 'info');
        } else {
            let tax = 0;
            if (id === null) {
                tax = parseFloat($("#productTax").val()) || 0;
            }

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
            calculateTotal(productList[productList.length - 1]);
            showNotification('Producto agregado', `${name} - $${price}`, 'success');
        }
        
        renderTable();
    }

        function calculateTotal(product) {
            let priceAfterDiscount = product.price - product.discount;
            let subtotal = product.quantity * priceAfterDiscount;
            let taxAmount = subtotal * (product.tax / 100);
            let total = (subtotal + taxAmount).toFixed(2);
            product.total = parseFloat(total);
            return total;
        }

        function renderTable() {
            let tableBody = $("#productTable");
            tableBody.empty();
            
            $.get("{{ route('dresses.impuestos') }}", function(impuestos) {
                productList.forEach((product, index) => {
                    let total = calculateTotal(product);
                    let selectOptions = 
                        `<option value="0" ${product.tax == 0 ? 'selected' : ''}>Sin Taxes (0%)</option>
                        ${impuestos.map(imp => 
                            `<option value="${imp.valor}" ${product.tax == imp.valor ? 'selected' : ''}>
                                ${imp.ciudad} ${imp.sufijo} (${imp.valor}%)
                            </option>`
                        ).join('')}
                    `;
                    
                    tableBody.append(
                        `<tr data-index="${index}">
                            <td>${product.name}</td>
                            <td><input type="number" class="quantity form-control" value="${product.quantity}" min="1" data-index="${index}"></td>
                            <td><input type="text" class="size form-control" value="${product.size}" data-index="${index}"></td>
                            <td><input type="text" class="color form-control" value="${product.color}" data-index="${index}"></td>
                            <td><input type="number" class="discount form-control" value="${product.discount}" min="0" step="0.01" placeholder="$" data-index="${index}"></td>

                            <td>
                                <select class="tax form-control" data-index="${index}">
                                    ${selectOptions}
                                </select>
                            </td>
                            <td>$${product.price.toFixed(2)}</td>
                            <td class="total">$${total}</td>
                            <td><button class="btn btn-danger delete" data-index="${index}">Eliminar</button></td>
                        </tr>`
                    );
                });
                attachEventListeners();
                updateSummary();
            });
        }

        function updateSummary() {
            let subtotal = productList.reduce((sum, p) => {
            let priceAfterDiscount = p.price - p.discount;
            return sum + (p.quantity * priceAfterDiscount);
            }, 0);

            let taxTotal = productList.reduce((sum, p) => {
            let priceAfterDiscount = p.price - p.discount;
            return sum + (p.quantity * priceAfterDiscount * (p.tax / 100));
            }, 0);
            
            let grandTotal = subtotal + taxTotal;
            let advance = parseFloat($("#advancePayment").val()) || 0;
            let amountDue = grandTotal - advance;

            $("#subtotal").text(subtotal.toFixed(2));
            $("#taxTotal").text(taxTotal.toFixed(2));
            $("#grandTotal").text(grandTotal.toFixed(2));
            $("#amountDue").text(amountDue.toFixed(2));
        }

        function attachEventListeners() {
            $(".quantity, .discount, .tax, .size, .color").on("change", function () {
                let index = $(this).data("index");
                let field = $(this).hasClass("quantity") ? "quantity" :
                    $(this).hasClass("discount") ? "discount" :
                    $(this).hasClass("tax") ? "tax" :
                    $(this).hasClass("size") ? "size" : "color";
                let value = $(this).val();

                if (field === "quantity") {
                    value = parseInt(value) || 1;
                    if (value < 1) value = 1;
                } else if (field === "discount" || field === "tax") {
                    value = parseFloat(value) || 0;
                }
                productList[index][field] = value;
                calculateTotal(productList[index]);
                renderTable();
                
                // Notificación para cambios importantes
                if (field === "quantity" || field === "discount") {
                    showNotification('Actualizado', `${productList[index].name} modificado`, 'info');
                }
            });

            $(".delete").on("click", function () {
                let index = $(this).data("index");
                let productName = productList[index].name;
                productList.splice(index, 1);
                renderTable();
                
                showNotification('Eliminado', `${productName} fue removido`, 'warning');
            });

            $("#advancePayment").on("input", function () {
                updateSummary();
            });
        }

        $("#guardarVentaBtn").click(function () {

    if (!selectedContact || !selectedContact.id) {
        showNotification(
            'Falta cliente',
            'Por favor, selecciona o crea un cliente antes de guardar la venta.',
            'error'
        );
        return;
    }

    if (productList.length === 0) {
        showNotification(
            'Faltan productos',
            'Por favor, agrega al menos un producto a la venta.',
            'error'
        );
        return;
    }

    let ventaData = {
        cliente_id: selectedContact.id,
        fecha_compra: $("#purchaseDate").val(),
        fecha_compraO: $("#purchaseDateO").val(),
        pickDate: $("#pickDate").val(),
        returnDate: $("#returnDate").val(),
        vendedor: $("#purchaseVendedor").val(),
        observaciones: $("#observations").val(),
        paymentStatus: $("#paymentStatus").val(),
        paymentMethod: $("#paymentMethod").val(),
        url_path: $("#currentPath").val(),
        productos: productList.map(p => ({
            id: p.id || null,
            name: p.name,
            price: p.price,
            quantity: p.quantity,
            size: p.size,
            color: p.color,
            discount: p.discount,
            tax: p.tax,
            total: p.total
        })),
        subtotal: parseFloat($("#subtotal").text()),
        impuesto_total: parseFloat($("#taxTotal").text()),
        total: parseFloat($("#grandTotal").text()),
        adelanto: parseFloat($("#advancePayment").val()),
        monto_adeudado: parseFloat($("#amountDue").text()),
    };

    Swal.fire({
        title: 'Confirmar venta',
        html: `¿Estás seguro de guardar esta venta para 
               <b>${selectedContact.name}</b> 
               por un total de 
               <b>$${ventaData.total.toFixed(2)}</b>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('dresses.venta') }}",
                type: "POST",
                data: JSON.stringify(ventaData),
                contentType: "application/json",

                success: function (response) {

                    Swal.fire({
                        title: '¡Venta guardada!',
                        html: `Venta #${response.id} registrada exitosamente<br>
                               Total: $${ventaData.total.toFixed(2)}`,
                        icon: 'success',
                        confirmButtonText: 'Ir a la orden'
                    }).then(() => {

                        // 🔁 REDIRECCIÓN FINAL
                        window.location.href = `/orders/${response.id}/edit`;

                    });
                },

                error: function (xhr) {
                    let errorMessage = "Error al guardar la venta";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ": " + xhr.responseJSON.message;
                    }
                    showNotification('Error', errorMessage, 'error');
                }
            });
        }
    });
});

renderTable();

    });
</script>
</body>
</html>
@stop
