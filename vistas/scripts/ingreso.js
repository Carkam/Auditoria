var tabla;
var guardar = 0;
//Variables
var impuesto = 16;
var cont = 0;
var detalles = 0;
var usuario = $("#idusuario").val();
var cambio = 1;
var simbolo = 'Q';
//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    $.post(
        "../ajax/ingreso.php?op=selectProveedor",
        function (data) {
            $("#idproveedor").html(data);
            $("#idproveedor").selectpicker('refresh');

        }
    );

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
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_hora").val(today);
    $("#mTienda").text(obtenerNombreTienda());
}

//funcion limpiar
function limpiar() {
    $("#idproveedor").val(0);
    $("#idproveedor").selectpicker('refresh');
    $("#idtienda").val(0);
    $("#idtienda").selectpicker('refresh');
    $("#fecha_hora").val("");
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_hora").val(today);
    $("#impuestos").val("");
    $("#idmoneda").val(1);
    $("#idmoneda").selectpicker('refresh');
    $("#idestado").val(0);
    $("#idestado").selectpicker('refresh');
    $("#total").val("");
    $("#btnAgregarArt").prop("disabled", true);
    $("#btnAgregarArt").prop("title", 'Seleccione primero el proveedor y la tienda');
    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html(0);
    $("#idcompraencabezado").html('');
    detalles = 0;
    evaluar();
}

//funcion mostrar formulario
function mostrarform(flag) {


    if (flag) {
        $("#fecha_hora").prop("disabled", true);
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();
        $("#btnLimpiar").show();
        $("#estado").css('display', "none");
        $("#referencia").css('display', "none");
        $("#idcompraencabezado").css('display', "none");
        $("#idproveedor").prop("disabled", false);
        $("#idtienda").prop("disabled", false);
        $("#idmoneda").prop("disabled", false);
        $("#impuestos").prop("disabled", false);
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

//Funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
    location.reload();
}

//Funcion bloquear
function bloquear() {
    if ($("#idproveedor").val() != 0) {
        $("#idproveedor").prop("disabled", true);
    }
    combosSelected();
}

function bloquearTienda() {
    if ($("#idtienda").val() != 0) {
        $("#idtienda").prop("disabled", true);
    }
    combosSelected();
}

function cambioMoneda() {
    if ($("#idmoneda").val() != 0) {
        cambio = parseFloat($("#idmoneda option:selected").data('cambio'));
        simbolo = $("#idmoneda option:selected").data('simbolo');
        for (var i = 0; i < cont; i++) {
            $('#precio' + i).val(trunc($('#precio' + i).attr('data-precio')/cambio,2));
        }
        modificarSubtotales();
    }
}

function cambioPrecio(){
    for (var i = 0; i < cont; i++) {
        $('#precio' + i).attr('data-precio',$('#precio' + i).val())
    }
    modificarSubtotales();
}

function combosSelected() {
    if ($("#idtienda").val() != 0 && $("#idproveedor").val() != 0) {
        listarArticulos();
        $("#btnAgregarArt").prop("title", 'Agregar artículos');
        $("#btnAgregarArt").prop("disabled", false);
    }
}

function desbloquear(mensaje) {
    $("#idproveedor").prop("disabled", false);
    $("#idtienda").prop("disabled", false);
    //falta limpiar
    limpiar();
    if (mensaje) {
        bootbox.alert("Datos limpiados\n Proveedor y tienda desbloqueados");
    }
}

//Funcion listar
function listar() {
    tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing": true, //Activamos el procesamiento del datatables
                "aServerSide": true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax": {
                    url: '../ajax/ingreso.php?op=listar',
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 10, //Paginacion
                "order": [[0, "desc"]] //Ordenar (Columna, orden)

            })
        .DataTable();
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizo Compras" },
        function (f) {

        }
    );
}


function listarArticulos() {
    var idproveedor = $("#idproveedor").val();
    tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing": true, //Activamos el procesamiento del datatables
                "aServerSide": true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons: [

                ],
                "ajax": {
                    url: '../ajax/ingreso.php?op=listarArticulos',
                    data: { idproveedor: idproveedor },
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0, "desc"]] //Ordenar (Columna, orden)

            })
        .DataTable();
}

//funcion para guardar o editar
function guardaryeditar(e) {
    var idcompraencabezado = $("#idcompraencabezado").html();
    var fecha = $("#fecha_hora").val();
    var idproveedor = $("#idproveedor").val();
    var idtienda = $("#idtienda").val();
    var impuesto = $("#total_iva").val();
    var moneda = $("#idmoneda").val();
    var total = $("#total_compra").val();
    var estado = $("#idestado").val() - 1;
    var articulos = [];
    var cantidad = [];
    var precios = [];
    var configuraciones = [];
    var ganancias = [];
    var correo = ($("#idproveedor option:selected").data('correo'));
    console.log('cant art: ' + cont);
    for (var i = 0; i < cont; i++) {
        if($('#idarticulo' + i).val()!=undefined){
            articulos.push($('#idarticulo' + i).val());
            cantidad.push($('#cantidad' + i).val());
            precios.push($('#precio' + i).val());
            configuraciones.push($('#conf' + i).val());
            ganancias.push($('#ganancia' + i).val());
        }
        console.log('art: ' + $('#idarticulo' + i).val());
        console.log('cant: ' + $('#cantidad' + i).val());
        console.log('precios: ' + $('#precio' + i).val());
    }

    if (impuesto == '') {
        bootbox.alert('Debe de llenar el impuesto');
    } else if (moneda == 0 || moneda == null || moneda == '') {
        bootbox.alert('Debe de seleccionar la moneda');
    } else {
        $.post(
            "../ajax/ingreso.php?op=guardaryeditar",
            { idcompraencabezado: idcompraencabezado, fecha: fecha, idproveedor: idproveedor, idtienda: localStorage.getItem('Tienda'), articulos: articulos, cantidad: cantidad, precios: precios, impuesto: impuesto, usuario: usuario, moneda: moneda, total: total, estado: estado, correo: correo, configuraciones: configuraciones, ganancias: ganancias },
            function (e) {
                $.post(
                    "../ajax/bitacora.php?op=insertar",
                    { usuario: usuario, accion: "Compra Registrada" },
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

function mostrar(idcompraencabezado) {
    $.post(
        "../ajax/ingreso.php?op=mostrar", { idcompraencabezado: idcompraencabezado }, function (data, status) {

            data = JSON.parse(data);
            mostrarform(true);
            //colocar valores en los campos
            $("#idproveedor").val(data.idproveedor);
            $("#idproveedor").selectpicker('refresh');
            $("#idtienda").val(data.idtienda);
            $("#idtienda").selectpicker('refresh');
            let tiendaCompra = data.idtienda;
            $.post(
                "../ajax/ingreso.php?op=mostrarTiendaCompra&idTiendaCompra=" + tiendaCompra, function (r) {
                    console.log(r);
                    $("#mTienda").text(r);
                }
            );
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
                    // console.log(r);
                    $("#detalles").html("");
                    $("#detalles").html(r);
                    cont = $('#articulos').val();
                }
            );

        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizo detalle de compra con código " + idcompraencabezado },
        function (f)            {
           
        }
    );
}


function anular(idcompraencabezado) {
    /*bootbox.confirm("¿Estas seguro de anular el Ingreso?",function(result){
        if(result)
        {
            $.post(
                "../ajax/ingreso.php?op=anular",{idcompraencabezado:idcompraencabezado}, function(e)
                {
                    console.log(e);
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });*/
}



function marcarImpuesto() {
    /*var tipo_comprobante = $("#tipo_comprobante option:selected").text();
    if(tipo_comprobante == 'Factura')
    {
        $("#impuesto").val(impuesto);
    }
    else
    {
        $("#impuesto").val('0');
    }*/
}

function agregarDetalle(idarticulo, articulo, preciocompra, conf, ganancia) {
    if (!yaExiste(idarticulo)) {
        if (idarticulo != "") {
            var subtotal = 1 * (preciocompra / cambio);
            var fila = '<tr class="filas" id="fila' + cont + '"> ' +
                '<td>' +
                '<button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button>' +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="idarticulo' + cont + '" id="idarticulo' + cont + '" value="' + idarticulo + '">' +
                '<input type="hidden" name="conf' + cont + '" id="conf' + cont + '" value="' + conf + '">' +
                '<input type="hidden" name="ganancia' + cont + '" id="ganancia' + cont + '" value="' + ganancia + '">' +
                articulo +
                '</td>' +
                '<td>' +
                '<input type="number" name="cantidad' + cont + '" id="cantidad' + cont + '" onchange="modificarSubtotales()" min="1" value=1>' +
                '</td>' +
                '<td>' +
                '<input type="number" name="precio' + cont + '" id="precio' + cont + '" value="' + (preciocompra / cambio) + '" data-precio="' + preciocompra  + '" min="1" onchange="cambioPrecio()">' +
                '</td>' +
                '<td>' +
                '<span name="iva' + cont + '" id="iva' + cont + '"></span>' +
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
            alert("Error al ingresar el detalle, revisar los ddatos del articulo");
        }
    }
}

function modificarSubtotales() {
    var subtotal = 0;
    var iva = 0;
    for (var i = 0; i < cont; i++) {
        var cantidad = $('#cantidad' + i).val();
        var precio = $('#precio' + i).val();
        subtotal = parseInt(cantidad) * parseFloat(precio);
        iva = parseInt(cantidad) * parseFloat(precio) * 0.12;
        $('#subtotal' + i).html(trunc(subtotal,2));
        $('#iva' + i).html(trunc(iva,2));
    }
    calcularTotales();
}

function trunc (x, posiciones = 0) {
    var s = x.toString()
    var l = s.length
    var numStr='';
    if(s.indexOf('.')>=0){
        var decimalLength = s.indexOf('.') + 1
        numStr = s.substr(0, decimalLength + posiciones)
    }else{
        numStr=s;
    }
    
    return Number(numStr)
  }

function calcularTotales() {
    var total = 0;
    var totaliva = 0;
    if (cont > 0) {
        for (var i = 0; i < cont; i++) {
            if ($('#subtotal' + i).html() != undefined) {
                console.log('subtotal ' + i + ': ' + $('#subtotal' + i).html());
                var subtotal = $('#subtotal' + i).html();
                var subtotaliva = $('#iva' + i).html();
                total += parseFloat(subtotal);
                totaliva += parseFloat(subtotaliva);
            }
        }
    }
    console.log('total' + total);
    $("#total").html(simbolo + ' ' + trunc(total,2));
    $("#total_compra").val(trunc(total,2));
    $("#totaliva").html(simbolo + ' ' + trunc(totaliva,2));
    $("#total_iva").val(trunc(totaliva,2));

    evaluar();
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
    evaluar();
}

init();