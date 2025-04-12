@extends ('LayoutDresses.layout')
 @section('ContenidoSite-01')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autocomplete Search con Popup</title>
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
                   
                                  
   <div class="card-body">
    <div id="exampleModalLive" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
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
                        <select name="select" id="contactStore" class="form-control">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="saveContactBtn" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                 
                            <!-- [ demo-modal ] end -->



    <!-- [ Main Content ] start -->
                      
                                    <div class="card-body">
                        
                                        <div id="exampleModalLivec" class="modal fade"  tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLiveLabel">Create Product
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="saveProductBtn" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                 
                            <!-- [ demo-modal ] end -->

    <div class="container">  
     <div class="row">  

    <!-- Espacio para visualizar el contacto seleccionado o creado -->
    <div id="contactDisplay" class="p-2 col-lg-4">
     <div class="card card-body">
      <p><strong><b>Selected Client:</b></strong></p>
      <p id="selectedContact" style="color:red">No client selected.</p>
       <label><strong>Search Client:</strong></label>
        <input type="text" id="searchClient" class="form-control" placeholder="Buscar cliente..." autocomplete="off">
         <div id="contactSuggestions" style="color:green;"></div>
        <button  class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModalLive">Add Contact Manually</button>
     </div>

    </div> 
    <!-- Campo de búsqueda de cliente -->

    <!-- Información de la compra -->
    <div id="contactDisplay" class="p-1 col-lg-4">
     <div class="card card-body">
      <div class="form-group  mt-4">
       <label><strong>Purchase Date:</strong></label>
       <input type="date" id="purchaseDate" class="form-control">
       <label><strong>Seller:</strong></label>
       <select name="select" id="purchaseVendedor" class="form-control">
        @foreach($user as $user)
    <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
        @endforeach
        </select>
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
        <tbody id="productTable"></tbody>
    </table>
    <div class="container">  
     <div class="row">  

    <div id="contactDisplay" class="p-2 mt-4 col-lg-6">
     <div class="card card-body">
    <label><strong>Observations:</strong></label>
        <textarea id="observations" class="form-control" rows="3" placeholder="Write any observations here.."></textarea>
     </div>
    </div>
    <!-- Resumen de la compra -->
    <div id="summary" class=" p-2 mt-4 col-lg-6">
        <div class="card card-body">
            <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
            <p><strong>Total Tax:</strong> $<span id="taxTotal">0.00</span></p>
            <p><strong>Total:</strong> $<span id="grandTotal">0.00</span></p>
            <label><strong>Advancement:</strong></label>
            <input type="number" id="advancePayment" class="form-control" step="0.01" value="0">
            <p><strong>Amount Owed:</strong> $<span id="amountDue">0.00</span></p>
        </div>
    </div>

    

     </div>
    </div>

    <!-- Botón para guardar la venta -->
    <button id="guardarVentaBtn" class="btn btn-success mt-0 w-100">Save Sale</button>

    <!-- Modal para agregar un producto -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Add Product Manually</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="saveProductBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar un contacto -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Add Contact Manually</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="saveContactBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
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

            // AUTOCOMPLETE SEARCH PARA CLIENTES
            $("#searchClient").on("keyup", function () {
                let query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('dresses.client') }}", // Ruta para buscar clientes
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            let suggestions = $("#contactSuggestions");
                            suggestions.empty().show();
                            data.forEach(client => {
                                suggestions.append("<div class='contactSuggestion' style='color:green' data-id='" + client.id + "' data-name='" + client.nombres + "' data-email='" + client.email + "' data-phone='" + client.telefono + "'>" + client.nombres + "</div>");
                            });
                        }
                    });
                } else {
                    $("#contactSuggestions").hide();
                }
            });

            // GUARDAR CONTACTO MANUALMENTE
            $("#saveContactBtn").click(function () {
                let name = $("#contactName").val();
                let lastName = $("#contactLastName").val();
                let phone = $("#contactPhone").val();
                let email = $("#contactEmail").val(); // Nuevo campo: email
                let city = $("#contactCity").val();
                let address = $("#contactAddress").val();
                let store = $("#contactStore").val();
                let eventType = $("#contactEventType").val();
                let eventDate = $("#contactEventDate").val();

                // Enviar los datos del cliente al backend
                $.ajax({
                    url: "{{ route('clientes.store') }}", // Ruta para guardar clientes
                    type: "POST",
                    data: {
                        nombres: name,
                        apellidos: lastName,
                        telefono: phone,
                        ciudad: city,
                        email: email, // Nuevo campo: email
                        direccion: address,
                        tienda: store,
                        tipo_evento: eventType,
                        fecha_evento: eventDate
                    },
                    success: function (response) {
                        // Asignar el cliente seleccionado con el ID generado
                        selectedContact = {
                            id: response.id, // ID del cliente guardado
                            name: response.nombres + " " + response.apellidos,
                            phone: response.telefono
                        };
                        // Mostrar el cliente seleccionado en la interfaz
                        $("#selectedContact").text(`${selectedContact.name} - ${selectedContact.phone}`);
                        // Ocultar el popup de contacto
                         var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalLive'));
                modal.hide();
                        $("#contactOverlay, #contactPopup").hide();
                        // Limpiar los campos del popup
                        $("#contactName, #contactLastName, #contactPhone, #contactCity, #contactAddress, #contactStore, #contactEventType, #contactEventDate").val("");
                    },
                    error: function (xhr) {
                        alert("Error al guardar el cliente: " + xhr.responseJSON.message);
                    }
                });
            });

            // SELECCIONAR CLIENTE DESDE AUTOCOMPLETE
            $(document).on("click", ".contactSuggestion", function () {
                let id = $(this).data("id");
                let name = $(this).data("name");
                let phone = $(this).data("phone");
                selectedContact = { id, name, phone };
                $("#selectedContact").text(`${name} - ${phone}`);
                $("#contactSuggestions").hide();
            });

            // MOSTRAR POPUP PARA NUEVO CONTACTO
            $("#addContactBtn").click(function () {
                $("#contactOverlay, #contactPopup").show();
            });

            // OCULTAR POPUP DE CONTACTO
            $("#closeContactPopupBtn").click(function () {
                $("#contactOverlay, #contactPopup").hide();
            });

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

            // GUARDAR PRODUCTO MANUALMENTE
            $("#saveProductBtn").click(function () {
                let name = $("#productName").val();
                let color = $("#productColor").val();
                let size = $("#productSize").val();
                let price = parseFloat($("#productPrice").val()) || 0;

                // Agregar el producto manual a la lista
                addProductToTable(name, price, null, color, size);

                // Ocultar el popup de producto
                $("#overlay, #popup").hide();

                  var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalLivec'));
                modal.hide();

                // Limpiar los campos del popup
                $("#productName, #productColor, #productSize, #productPrice").val("");
            });

            // FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA
            function addProductToTable(name, price, id = null, color = "#000000", size = "M") {
                productList.push({
                    id: id || Date.now(), // Usar un ID temporal si no existe
                    name,
                    price,
                    quantity: 1,
                    size,
                    color,
                    discount: 0,
                    tax: 0,
                    total: 0 // Inicializar el total
                });
                calculateTotal(productList[productList.length - 1]); // Calcular el total del nuevo producto
                renderTable();
            }

            // FUNCIÓN PARA CALCULAR EL TOTAL DE UN PRODUCTO
            function calculateTotal(product) {
                let priceAfterDiscount = product.price * (1 - product.discount / 100);
                let total = (product.quantity * priceAfterDiscount * (1 + product.tax / 100)).toFixed(2);
                product.total = parseFloat(total); // Guardar el total en el objeto producto
                return total;
            }

            // FUNCIÓN PARA RENDERIZAR LA TABLA DE PRODUCTOS
            function renderTable() {
                let tableBody = $("#productTable");
                tableBody.empty();
                productList.forEach((product, index) => {
                    let total = calculateTotal(product);
                    tableBody.append(`
                        <tr data-index="${index}">
                            <td>${product.name}</td>
                            <td><input type="number" class="quantity" value="${product.quantity}" min="1" data-index="${index}"></td>
                            <td><select class="size"><option value="S">S</option><option value="M">M</option><option value="L">L</option></select></td>
                            <td><input type="color" class="color" value="${product.color}" data-index="${index}"></td>
                            <td><input type="number" class="discount" value="${product.discount}" min="0" data-index="${index}"></td>
                            <td><input type="number" class="tax" value="${product.tax}" min="0" data-index="${index}"></td>
                            <td>${product.price.toFixed(2)}</td>
                            <td class="total">${total}</td>
                            <td><button class="delete" data-index="${index}">❌</button></td>
                        </tr>
                    `);
                });

                attachEventListeners();
                updateSummary();
            }

            // FUNCIÓN PARA ACTUALIZAR EL RESUMEN
            function updateSummary() {
                let subtotal = productList.reduce((sum, p) => sum + (p.quantity * p.price * (1 - p.discount / 100)), 0);
                let taxTotal = productList.reduce((sum, p) => sum + (p.quantity * p.price * (p.tax / 100)), 0);
                let grandTotal = subtotal + taxTotal;
                let advance = parseFloat($("#advancePayment").val()) || 0;
                let amountDue = grandTotal - advance;

                $("#subtotal").text(subtotal.toFixed(2));
                $("#taxTotal").text(taxTotal.toFixed(2));
                $("#grandTotal").text(grandTotal.toFixed(2));
                $("#amountDue").text(amountDue.toFixed(2));
            }

            // FUNCIÓN PARA VINCULAR EVENTOS
            function attachEventListeners() {
                // Actualizar cantidad, descuento e impuesto
                $(".quantity, .discount, .tax").on("input", function () {
                    let index = $(this).data("index");
                    let field = $(this).hasClass("quantity") ? "quantity" :
                                $(this).hasClass("discount") ? "discount" : "tax";
                    let value = parseFloat($(this).val()) || 0;

                    if (field === "quantity" && value < 1) value = 1; // Asegurar que la cantidad sea al menos 1

                    productList[index][field] = value;
                    calculateTotal(productList[index]); // Recalcular el total
                    renderTable();
                });

                // Eliminar producto
                $(".delete").on("click", function () {
                    let index = $(this).data("index");
                    productList.splice(index, 1);
                    renderTable();
                });

                // Actualizar resumen cuando cambia el adelanto
                $("#advancePayment").on("input", function () {
                    updateSummary();
                });
            }

            // EVENTO PARA GUARDAR LA VENTA
            $("#guardarVentaBtn").click(function () {
                if (!selectedContact || !selectedContact.id) {
                    alert("Por favor, selecciona o crea un cliente antes de guardar la venta.");
                    return;
                }

                let ventaData = {
                    cliente_id: selectedContact.id,
                    fecha_compra: $("#purchaseDate").val(),
                    vendedor: $("#purchaseVendedor").val(),
                    observaciones: $("#observations").val(),
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

                $.ajax({
                    url: "{{ route('dresses.venta') }}",
                    type: "POST",
                    data: JSON.stringify(ventaData),
                    contentType: "application/json",
                    success: function (response) {
                        alert("Venta guardada correctamente");
                        // Limpiar el formulario
                        productList = [];
                        selectedContact = null;
                        $("#selectedContact").text("Ningún cliente seleccionado.");
                        $("#purchaseDate").val("");
                        $("#observations").val("");
                        $("#advancePayment").val(0);
                        renderTable();
                        updateSummary();
                    },
                    error: function (xhr) {
                        alert("Error al guardar la venta: " + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>
</html>
  @stop
