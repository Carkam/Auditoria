var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    //Cargamos los items al select categoria
    $.post(
        "../ajax/promocion.php?op=selectCategoria",
        function (data) {

            //console.log(data);
            $("#idproducto").html(data);
            $("#idproducto").selectpicker('refresh');
        }
    );
}

//funcion limpiar
function limpiar() {
    $("#idpromocion").val("");
    $("#fechai").val("");
    $("#fechaf").val("");
    $("#descuento").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
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
                    url: '../ajax/promocion.php?op=listar',
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
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizó las promociones" },
        function (f) {

        }
    );
}



//funcion para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/promocion.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Promoción Registrado o Actualizado" },
        function (f) {

        }
    );
    limpiar();
}

function mostrar(idpromocion) {
    $.post(
        "../ajax/promocion.php?op=mostrar",
        { idpromocion: idpromocion },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#idproducto").val(data.idproducto);
            $('#idproducto').selectpicker('refresh');

            $("#fechai").val(data.fechaInicio);
            $("#fechaf").val(data.fechaFinal);
            $("#descuento").val(data.descuento);

            $("#idpromocion").val(data.idPromocion);

        }
    );
}

//funcion para descativar categorias
function desactivar(idpromocion) {
    bootbox.confirm("¿Estas seguro de eliminar la promocion?", function (result) {
        if (result) {
            $.post(
                "../ajax/promocion.php?op=desactivar",
                { idpromocion: idpromocion },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Desactivo Promoción: " + idpromocion },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}
//funcion para descativar categorias
function desactivarP(idpromocion) {
    bootbox.confirm("¿Estas seguro de desactivar la promocion?", function (result) {
        if (result) {
            $.post(
                "../ajax/promocion.php?op=desactivarP",
                { idpromocion: idpromocion },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Elimino Promoción: " + idpromocion },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function activar(idpromocion) {
    bootbox.confirm("¿Estas seguro de activar el Articulo?", function (result) {
        if (result) {
            $.post(
                "../ajax/promocion.php?op=activar",
                { idpromocion: idpromocion },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Activo Promoción: " + idpromocion },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function generarbarcode() {
    var codigo = $("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
}

function imprimir() {
    $("#print").printArea();
}



init();