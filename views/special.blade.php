<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autocomplete Search con Popup</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        #popup, #overlay, #contactPopup, #contactOverlay {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        #overlay, #contactOverlay { width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); top: 0; left: 0; }
        #suggestions, #contactSuggestions {
            border: 1px solid #ccc;
            max-width: 300px;
            display: none;
            position: absolute;
            background: white;
            z-index: 1000;
        }
        .suggestion, .contactSuggestion { padding: 10px; cursor: pointer; border-bottom: 1px solid #ddd; }
        .suggestion:hover, .contactSuggestion:hover { background-color: #f0f0f0; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        input { width: 100px; text-align: center; }
        #summary { margin-top: 20px; padding: 10px; border: 1px solid #ddd; }
        #contactDisplay { margin-top: 20px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h1>Laravel Autocomplete Search</h1>

    <!-- Campo de búsqueda de cliente -->
    <div>
        <label><strong>Buscar Cliente:</strong></label>
        <input type="text" id="searchClient" placeholder="Buscar cliente..." autocomplete="off">
        <div id="contactSuggestions"></div>
        <button id="addContactBtn">Agregar Contacto Manualmente</button>
    </div>

    <!-- Espacio para visualizar el contacto seleccionado o creado -->
    <div id="contactDisplay">
        <p><strong>Cliente Seleccionado:</strong></p>
        <p id="selectedContact">Ningún cliente seleccionado.</p>
    </div>

    <!-- Campo de búsqueda de productos -->
    <input type="text" id="search" placeholder="Buscar producto..." autocomplete="off">
    <div id="suggestions"></div>

    <button id="addProductBtn">Agregar Producto Manualmente</button>

    <div>
        <label><strong>Fecha de Compra:</strong></label>
        <input type="date" id="purchaseDate">
        <br><br>
        <label><strong>Observaciones:</strong></label>
        <textarea id="observations" rows="3" cols="50" placeholder="Escribe aquí cualquier observación..."></textarea>
    </div>

    <!-- Tabla de productos -->
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Talla</th>
                <th>Color</th>
                <th>Descuento (%)</th>
                <th>Impuesto (%)</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productTable"></tbody>
    </table>

    <!-- Resumen de la compra -->
    <div id="summary">
        <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
        <p><strong>Impuesto Total:</strong> $<span id="taxTotal">0.00</span></p>
        <p><strong>Total:</strong> $<span id="grandTotal">0.00</span></p>
        <label><strong>Adelanto:</strong> </label>
        <input type="number" id="advancePayment" step="0.01" value="0">
        <p><strong>Monto Adeudado:</strong> $<span id="amountDue">0.00</span></p>
    </div>

    <!-- Botón para guardar la venta -->
    <button id="guardarVentaBtn">Guardar Venta</button>

    <!-- Pop-up para agregar un producto -->
    <div id="overlay"></div>
    <div id="popup">
        <h2>Agregar Producto Manualmente</h2>
        <label>Nombre:</label>
        <input type="text" id="productName">
        <br><br>
        <label>Precio:</label>
        <input type="number" id="productPrice" step="0.01">
        <br><br>
        <button id="saveProductBtn">Guardar</button>
        <button id="closePopupBtn">Cancelar</button>
    </div>

    <!-- Pop-up para agregar un contacto -->
    <div id="contactOverlay"></div>
    <div id="contactPopup">
        <h2>Agregar Contacto Manualmente</h2>
        <label>Nombre:</label>
        <input type="text" id="contactName">
        <br><br>
        <label>Email:</label>
        <input type="email" id="contactEmail">
        <br><br>
        <label>Teléfono:</label>
        <input type="text" id="contactPhone">
        <br><br>
        <button id="saveContactBtn">Guardar</button>
        <button id="closeContactPopupBtn">Cancelar</button>
    </div>



  <script>
  

    </script>
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
                        suggestions.append("<div class='contactSuggestion' data-id='" + client.id + "' data-name='" + client.nombre + "' data-email='" + client.email + "' data-phone='" + client.telefono + "'>" + client.nombre + "</div>");
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
    let email = $("#contactEmail").val();
    let phone = $("#contactPhone").val();

    // Enviar los datos del cliente al backend
    $.ajax({
        url: "{{ route('clientes.store') }}", // Ruta para guardar clientes
        type: "POST",
        data: {
            nombre: name,
            email: email,
            telefono: phone
        },
        success: function (response) {
            // Asignar el cliente seleccionado con el ID generado
            selectedContact = {
                id: response.id, // ID del cliente guardado
                name: response.nombre,
                email: response.email,
                phone: response.telefono
            };
            // Mostrar el cliente seleccionado en la interfaz
            $("#selectedContact").text(`${name} - ${email} - ${phone}`);
            // Ocultar el popup de contacto
            $("#contactOverlay, #contactPopup").hide();
            // Limpiar los campos del popup
            $("#contactName").val("");
            $("#contactEmail").val("");
            $("#contactPhone").val("");
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
        let email = $(this).data("email");
        let phone = $(this).data("phone");
        selectedContact = { id, name, email, phone };
        $("#selectedContact").text(`${name} - ${email} - ${phone}`);
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

    // GUARDAR CONTACTO MANUALMENTE
    $("#saveContactBtn").click(function () {
        let name = $("#contactName").val();
        let email = $("#contactEmail").val();
        let phone = $("#contactPhone").val();
        selectedContact = { id: null, name, email, phone };
        $("#selectedContact").text(`${name} - ${email} - ${phone}`);
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
    let price = parseFloat($("#productPrice").val()) || 0;

    // Agregar el producto manual a la lista
    addProductToTable(name, price);

    // Ocultar el popup de producto
    $("#overlay, #popup").hide();

    // Limpiar los campos del popup
    $("#productName").val("");
    $("#productPrice").val("");
});

// FUNCIÓN PARA AGREGAR PRODUCTO A LA TABLA
function addProductToTable(name, price, id = null) {
    productList.push({
        id: id || Date.now(), // Usar un ID temporal si no existe
        name,
        price,
        quantity: 1,
        size: "M",
        color: "#000000",
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

    function guardarVenta() {
    console.log("selectedContact:", selectedContact); // Depuración: Verificar el valor de selectedContact

    if (!selectedContact || !selectedContact.id) {
        alert("Por favor, selecciona o crea un cliente antes de guardar la venta.");
        return;
    }

    let ventaData = {
        cliente_id: selectedContact.id,
        fecha_compra: $("#purchaseDate").val(),
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

    console.log("ventaData:", ventaData); // Depuración: Verificar los datos que se enviarán al backend

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
}

    // EVENTO PARA GUARDAR LA VENTA
    $("#guardarVentaBtn").click(guardarVenta);
});
    </script>




</body>
</html>