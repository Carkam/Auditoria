var tabla;
var usuario = $("#idusuario").val();
var cambio = 1;
var simbolo = 'Q';
var agergarCliente = 0;
//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    listar();

    //Cargamos los items al select proveedor
    $.post("../ajax/venta.php?op=selectCliente", function (r) {
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });

    $.post(
        "../ajax/ingreso.php?op=selectTienda",
        function (data) {
            $("#idtienda").html(data);
            $("#idtienda").selectpicker('refresh');
        }
    );

    $.post(
        "../ajax/ingreso.php?op=selectMoneda",
        function (data) {
            $("#idmoneda").html(data);
            $("#idmoneda").selectpicker('refresh');
        }
    );

    $.post(
        "../ajax/venta.php?op=selectPago",
        function (data) {
            $("#idtipodepago").html(data);
            $("#idtipodepago").selectpicker('refresh');
        }
    );
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_hora").val(today);
    $("#mTienda").text(obtenerNombreTienda());
    listarArticulos();
}

//Función limpiar
function limpiar() {

    $("#idtienda").val(0);
    $("#idtienda").selectpicker('refresh');
    $("#fecha_hora").val("");
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_hora").val(today);
    $("#nit").val("");
    $("#idcliente").val(0);
    $("#idcliente").selectpicker('refresh');
    $("#idmoneda").val(1);
    $("#idmoneda").selectpicker('refresh');
    $("#idtipodepago").val(0);
    $("#idtipodepago").selectpicker('refresh');
    $("#total").val("");
    $("#btnAgregarArt").prop("disabled", false);
    $("#nombre").prop("disabled", true);
    $("#apellido").prop("disabled", true);
    $("#direccion").prop("disabled", true);
    $("#correo").prop("disabled", true);
    $("#btnAgregarArt").prop("title", 'Seleccione primero el proveedor y la tienda');
    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html(0);
    $("#idcompraencabezado").html('');
    detalles = 0;
    evaluar();

}

//Función mostrar formulario
function mostrarform(flag) {
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();
        $("#btnLimpiar").show();
        $("#estado").css('display', "none");
        $("#referencia").css('display', "none");
        $("#idcompraencabezado").css('display', "none");
        $("#idtienda").prop("disabled", false);
        $("#fecha_hora").prop("disabled", true);
        $("#nit").prop("disabled", false);
        $("#idcliente").prop("disabled", false);
        $("#idmoneda").prop("disabled", false);
        $("#idtipodepago").prop("disabled", false);
        guardar = 1;
        //$("#btnAgregarArt").prop("disabled",true);
        //$("#btnAgregarArt").prop("title",'Seleccione primero el proveedor y la tienda');
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#referencia").css('display', "none");
        $("#idcompraencabezado").css('display', "none");
    }
    limpiar();
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
    location.reload();
}

function bloquearTienda() {
    if ($("#idtienda").val() != 0) {
        $("#idtienda").prop("disabled", true);
        listarArticulos();
        $("#btnAgregarArt").prop("title", 'Agregar artículos');
        $("#btnAgregarArt").prop("disabled", false);
    }
}

function desbloquear(mensaje) {
    $("#idtienda").prop("disabled", false);
    //falta limpiar
    limpiar();
    if (mensaje) {
        bootbox.alert("Datos limpiados\n Tienda desbloqueados");
    }
}


//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
            {
                url: '../ajax/venta.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizo ventas" },
        function (f) {

        }
    );
}


//Función ListarArticulos
function listarArticulos() {
    var idtienda = localStorage.getItem('Tienda');
    tabla = $('#tblarticulos').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
            {
                url: '../ajax/venta.php?op=listarArticulosVenta',
                data: { idtienda: idtienda },
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
    //var idventaencabezado = $("#idcompraencabezado").html();
    var fecha = $("#fecha_hora").val();
    var nit = $("#nit").val();
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var correo = $("#correo").val();
    var direccion = $("#direccion").val();
    var usuario = $("#idusuario").val();
    var moneda = $("#idmoneda").val();
    var pago = $("#idtipodepago").val();
    var idtienda = $("#idtienda").val();
    var total = $("#total_compra").val();
    var descuentocompra = $("#descuento_compra").val();
    var iva = $("#iva_compra").val();
    var articulos = [];
    var cantidad = [];
    var descuento = [];
    if ($('#confin').prop('checked')) {
        nit = 'C/F';
    }
    //alert('se va a guardar');
    for (var i = 0; i < cont; i++) {
        if($('#idarticulo' + i).val()!=undefined){
            articulos.push($('#idarticulo' + i).val());
            cantidad.push($('#cantidad' + i).val());
            descuento.push($('#descuento' + i).html());
        }
        
    }
    var bien = false;
    if (pago == 0 || pago == null || pago == '') {
        bootbox.alert('Debe de seleccionar la forma de pago');
    } else if (pago == 1) {
        if ($("#cantrec").val() == '') {
            bootbox.alert('Debe de ingresar la cantidad recibida');
        } else {
            bien = true;
        }
    } else {
        bien = true;
    }

    if (bien) {
        if (agergarCliente == 1) {
            $.post(
                "../ajax/cliente.php?op=insertarEnVenta",
                { nombre: nombre, apellido: apellido, email: correo, direccion: direccion, nit: nit }
            );
        }
        $.post(
            "../ajax/venta.php?op=guardaryeditar",
            { nit: nit, fecha: fecha, total: total, descuentocompra: descuentocompra, iva: iva, usuario: usuario, idtienda: localStorage.getItem('Tienda'), pago: pago, moneda: moneda, articulos: articulos, cantidad: cantidad, descuento: descuento, correo: correo },
            function (e) {
                $.post(
                    "../ajax/bitacora.php?op=insertar",
                    { usuario: usuario, accion: "Venta Registrada" },
                    function (f) {
                        bootbox.alert(e, function () {
                            cancelarform();
                        })

                    }
                );
            }
        );
    }
}

function metodoPago() {
    var moneda = $("#idmoneda").val();
    var bien = false;

    if (moneda == 0 || moneda == null || moneda == '') {
        bootbox.alert('Debe de seleccionar la moneda');
    } else if (!$('#confin').prop('checked')) {
        if ($("#nombre").val() == '') {
            bootbox.alert('Debe de ingresar el nombre del cliente');
        } else if ($("#apellido").val() == '') {
            bootbox.alert('Debe de ingresar el apellido del cliente');
        } else if ($("#direccion").val() == '') {
            bootbox.alert('Debe de ingresar la direccion del cliente');
        } else if ($("#correo").val() == '') {
            bootbox.alert('Debe de ingresar el correo del cliente');
        } else if ($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
            bootbox.alert('El correo electrónico introducido no es correcto.');
        } else {
            bien = true;
        }
    } else {
        bien = true;
    }

    if (bien) {
        $("#myModal2").modal("show");
        $(".pagoEfectivo").hide();
        $('#cantCambio').html(simbolo + ' 0.00');
    }

}

function cambioPago() {
    if ($('#idtipodepago').val() != 0) {
        if ($('#idtipodepago').val() == 1) {
            $(".pagoEfectivo").show();
        } else {
            $(".pagoEfectivo").hide();
        }
    } else {
        $(".pagoEfectivo").hide();
    }
}

function calcularCambio() {
    var totalVenta = parseFloat($("#total_compra").val());
    if ($('#cantrec').val() != '') {
        var recibido = parseFloat($('#cantrec').val());
        if (recibido < totalVenta) {
            bootbox.alert('La cantidad recibida no puede ser menor al total de la venta');
            $('#cantrec').val('');
        } else {
            var cambio = recibido - totalVenta;
            $('#cantcambio').html(simbolo + ' ' + cambio);
        }
    }
}

function consumidorFinal() {
    if ($('#confin').prop('checked')) {
        $('#nit').prop('disabled', true);
        $('#idcliente').prop('disabled', true);
        $('#nit').val('');
        $('#nombre').val('');
        $('#apellido').val('');
        $('#correo').val('');
        $('#direccion').val('');
        $('#idcliente').val(0);
        $("#idcliente").selectpicker('refresh');
    } else {
        $('#nit').prop('disabled', false);
        $('#idcliente').prop('disabled', false);
    }
}

function mostrar(idventaencabezado) {

    $.post("../ajax/venta.php?op=mostrar", { idventaencabezado: idventaencabezado }, function (data, status) {
        data = JSON.parse(data);

        mostrarform(true);

        $("#idcliente").val(data.nit);
        $("#idcliente").selectpicker('refresh');
        $("#idtienda").val(data.idtienda);
        $("#idtienda").selectpicker('refresh');
        let tiendaCompra = data.idtienda;

        $.post(
            "../ajax/ingreso.php?op=mostrarTiendaCompra&idTiendaCompra=" + tiendaCompra, function (r) {
                console.log(r);
                $("#mTienda").text(r);
            }
        );
        $("#idmoneda").val(data.idtipomoneda);
        $("#idmoneda").selectpicker('refresh');
        $("#idtipodepago").val(data.idtipodepago);
        $("#idtipodepago").selectpicker('refresh');

        $("#nit").val(data.nit);
        $("#usuario").val(data.usuario);
        $("#fecha_hora").val(data.fecha);
        //$("#total").html('Q '+data.total);            
        $("#idcompraencabezado").html(data.idventaencabezado);

        //Ocultar y mostrar botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnLimpiar").hide();
        $("#btnAgregarArt").hide();
        $("#estado").css('display', "block");
        $("#referencia").css('display', "inline");
        $("#idcompraencabezado").css('display', "inline");
        $("#idproveedor").prop("disabled", true);
        $("#idtienda").prop("disabled", true);
        $("#fecha_hora").prop("disabled", true);
        $("#usuario").prop("disabled", true);
        $("#usuario").prop("disabled", true);
        $("#idmoneda").prop("disabled", true);
        $("#impuestos").prop("disabled", true);
    });

    $.post("../ajax/venta.php?op=listarDetalle&id=" + idventaencabezado, function (r) {
        $("#detalles").html(r);
    });
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizó detalle de venta con código " + idventaencabezado },
        function (f) {

        }
    );

    $.post(
        "../ajax/ingreso.php?op=mostrar", { idcompraencabezado: idcompraencabezado }, function (data, status) {

            data = JSON.parse(data);
            mostrarform(true);
            //colocar valores en los campos
            $("#idproveedor").val(data.idproveedor);
            $("#idproveedor").selectpicker('refresh');
            $("#idtienda").val(data.idtienda);
            $("#idtienda").selectpicker('refresh');
            $("#fecha_hora").val(data.fecha);
            $("#usuario").val(data.usuario);
            $("#impuestos").val(data.impuesto);
            $("#idmoneda").val(data.idtipomoneda);
            $("#idmoneda").selectpicker('refresh');
            $("#idestado").val(parseInt(data.estado) + 1);
            $("#idestado").selectpicker('refresh');
            $("#idcompraencabezado").html(data.idcompraencabezado);

            //Ocultar y mostrar botones
            $("#btnGuardar").show();
            $("#btnCancelar").show();
            $("#btnLimpiar").hide();
            $("#btnAgregarArt").hide();
            $("#estado").css('display', "block");
            $("#referencia").css('display', "inline");
            $("#idcompraencabezado").css('display', "inline");
            //Bloquear campos
            $("#idproveedor").prop("disabled", true);
            $("#idtienda").prop("disabled", true);
            $("#fecha_hora").prop("disabled", true);
            $("#impuestos").prop("disabled", true);
            $("#idmoneda").prop("disabled", true);
            guardar = 0;

            $.post(
                "../ajax/ingreso.php?op=listarDetalle&id=" + idcompraencabezado, function (r) {
                    //console.log(r);
                    $("#detalles").html("");
                    $("#detalles").html(r);
                }
            );

        }
    );

}

function ponerCliente() {
    var nit = $("#nit").val();
    if (nit.length != 7) {
        bootbox.alert('El NIT debe de contener 7 caracteres');
    } else {
        var numeros = true;
        for (var i = 0; i < nit.length; i++) {
            if (!isNumeric(nit[i])) {
                if (i == nit.length - 1 && (nit[i] == 'k' || nit[i] == 'K')) {

                } else {
                    numeros = false;
                    break;
                }
            }
        }
        if (numeros) {
            $("#idcliente").val(nit);
            $('#idcliente').selectpicker('refresh');

            var nombre = ($("#idcliente option:selected").data('nombre'));
            var apellido = ($("#idcliente option:selected").data('apellido'));
            var direccion = ($("#idcliente option:selected").data('dir'));
            var correo = ($("#idcliente option:selected").data('correo'));

            $("#nombre").val(nombre);
            $("#apellido").val(apellido);
            $("#direccion").val(direccion);
            $("#correo").val(correo);

            if ($("#idcliente").val() == 0) {
                bootbox.confirm("NIT no encontrado ¿Desea agregarlo?", function (result) {
                    if (result) {
                        $("#nombre").prop("disabled", false);
                        $("#apellido").prop("disabled", false);
                        $("#direccion").prop("disabled", false);
                        $("#correo").prop("disabled", false);
                        agergarCliente = 1;
                    }
                })
            } else {
                $("#nombre").prop("disabled", true);
                $("#apellido").prop("disabled", true);
                $("#direccion").prop("disabled", true);
                $("#correo").prop("disabled", true);
                agergarCliente = 0;
            }
        } else {
            bootbox.alert('El NIT no debe de contener letras');
        }
    }
}

function isNumeric(str) {
    return /^\d+$/.test(str);
}

function ponerNit() {
    var nit = $("#idcliente").val();
    $("#nit").val(nit);
}

//Función para anular registros
function anular(idventaencabezado) {
    bootbox.confirm("¿Está Seguro de anular la venta?", function (result) {
        if (result) {
            $.post("../ajax/venta.php?op=anular", { idventaencabezado: idventaencabezado }, function (e) {
                console.log(e);
                bootbox.alert(e);
                tabla.ajax.reload();
                $.post(
                    "../ajax/bitacora.php?op=insertar",
                    { usuario: usuario, accion: "Venta Anulada con código " + idventaencabezado },
                    function (f) {

                    }
                );
            });
        }
    })
}

function activar(idventaencabezado) {
    bootbox.confirm("¿Está Seguro de activar la venta?", function (result) {
        if (result) {
            $.post("../ajax/venta.php?op=activar", { idventaencabezado: idventaencabezado }, function (e) {
                console.log(e);
                bootbox.alert(e);
                tabla.ajax.reload();
                $.post(
                    "../ajax/bitacora.php?op=insertar",
                    { usuario: usuario, accion: "Venta Activada con código " + idventaencabezado },
                    function (f) {

                    }
                );
            });
        }
    })
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
/*var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);*/

function marcarImpuesto() {
    /*var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura')
{
    $("#impuesto").val(impuesto); 
}
else
{
    $("#impuesto").val("0"); 
}*/
}
var impuesto = 16;
var cont = 0;
var detalles = 0;
function agregarDetalle(idarticulo, articulo, precio, stock) {

    if (!yaExiste(idarticulo)) {
        if (idarticulo != "") {
            var subtotal = 1 * (precio / cambio);
            console.log(subtotal);
            var iva = (precio / cambio) * 0.12;
            console.log(iva);
            var fila = '<tr class="filas" id="fila' + cont + '"> ' +
                '<td>' +
                '<button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button>' +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="idarticulo' + cont + '" id="idarticulo' + cont + '" value="' + idarticulo + '">' +
                articulo +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="stock' + cont + '" id="stock' + cont + '"value="' + stock + '">' +
                '<input type="number" name="cantidad' + cont + '" id="cantidad' + cont + '" onchange="modificarSubtotales()" min="1" max="' + stock + '" value=1>' +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="precio' + cont + '" id="precio' + cont + '" value="' + (precio / cambio) + '" data-precio="' + (precio / cambio) + '">' +
                (precio / cambio) +
                '</td>' +
                '<td>' +
                '<span name="descuento' + cont + '" id="descuento' + cont + '">' + '0' + '</span>' +
                '</td>' +
                '<td>' +
                '<span name="iva' + cont + '" id="iva' + cont + '">' + iva + '</span>' +
                '</td>' +
                '<td>' +
                '<span name="subtotal' + cont + '" id="subtotal' + cont + '">' + subtotal + '</span>' +
                '</td>' +
                '</tr>';

            cont++;
            detalles++;
            $("#detalles").append(fila);
            modificarSubtotales();
        }
        else {
            alert("Error al ingresar el detalle, revisar los datos del articulo");
        }
    }
}

function yaExiste(idarticulo) {
    for (var i = 0; i < cont; i++) {
        var id = $('#idarticulo' + i).val();
        if (id == idarticulo) {
            bootbox.alert('Este producto ya está agregado');
            return true;
        }
    }
    return false;
}

function dosDecimales(n) {
    let t = n.toString();
    let regex = /(\d*.\d{0,2})/;
    return t.match(regex)[0];
}

function cambioMoneda() {
    if ($("#idmoneda").val() != 0) {
        cambio = parseFloat($("#idmoneda option:selected").data('cambio'));
        simbolo = $("#idmoneda option:selected").data('simbolo');
        $('#detalles tbody tr').each(function () {
            precioc = $(this).find("td:eq(3)").find("input").attr('data-precio');
            $(this).find("td:eq(3)").find("input").val(precioc / cambio);
            html1 = $(this).find("td:eq(3)").html();
            html1 = $(this).find("td:eq(3)").html();
            $(this).find("td:eq(3)").html($(this).find("td:eq(3)").html().substring(0, html1.search('>') + 1) + (precioc / cambio));
        });
        modificarSubtotales();
    }
}

function modificarSubtotales() {
    var subtotal = 0;
    for (var i = 0; i < cont; i++) {
        var cantidad = $('#cantidad' + i).val();
        var stock = $('#stock' + i).val();
        if (parseInt(cantidad) > parseInt(stock)) {
            bootbox.alert('La cantidad no puede ser mayor a la de stock, se pondrá el valor máximo');
            $('#cantidad' + i).val(stock);
            cantidad = stock;
        } else if (parseInt(cantidad) < 1) {
            bootbox.alert('La cantidad no puede ser menor a 1');
            $('#cantidad' + i).val(1);
            cantidad = 1;
        }
        var precio = $('#precio' + i).val();
        var iva = $('#iva' + i).val();
        subtotal = parseInt(cantidad) * parseFloat(precio);
        iva = parseFloat(subtotal) * 0.12;
        $('#subtotal' + i).html(dosDecimales(subtotal));
        $('#iva' + i).html(dosDecimales(iva));

    }
    calcularTotales();

}
function calcularTotales() {
    var total = 0;
    var descuento = 0;
    var iva = 0;
    if (cont > 0) {
        for (var i = 0; i < cont; i++) {
            if ($('#subtotal' + i).html() != undefined) {
                var subtotal = $('#subtotal' + i).html();
                descuento += parseFloat($('#descuento' + i).html());
                iva += parseFloat($('#iva' + i).html());
                total += parseFloat(subtotal);
                console.log('subtotal ' + i + ' ' + $('#subtotal' + i).html() + ' ' + typeof ($('#subtotal' + i).html()));
                console.log('descuento ' + i + ' ' + $('#descuento' + i).html() + ' ' + typeof ($('#descuento' + i).html()));
                console.log('iva ' + i + ' ' + $('#iva' + i).html() + ' ' + typeof ($('#iva' + i).html()));
            }
        }
    }
    console.log('descuento ' + descuento + ' ' + typeof (descuento));
    console.log('iva ' + iva + ' ' + typeof (iva));
    console.log('total ' + total + ' ' + typeof (total));
    $("#descuento").html(simbolo + ' ' + dosDecimales(descuento));
    $("#descuento_compra").val(dosDecimales(descuento));
    $("#iva").html(simbolo + ' ' + dosDecimales(iva));
    $("#iva_compra").val(dosDecimales(iva));
    $("#total").html(simbolo + ' ' + dosDecimales(total));
    $("#total_compra").val(dosDecimales(total));

    evaluar();
}

function evaluar() {
    if (detalles > 0) {
        $("#btnGuardar").show();
    }
    else {
        $("#btnGuardar").hide();
        cont = 0;
    }
}

function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    detalles--;
    calcularTotales();
}

init();