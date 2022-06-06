var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

}

//funcion limpiar
function limpiar() {
    $("#idmoneda").val("");
    $("#nombre").val("");
    $("#simbolo").val("");
    $("#tcambio").val("");
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
                    url: '../ajax/moneda.php?op=listar',
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
        { usuario: usuario, accion: "Visualizó las Monedas" },
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
        url: "../ajax/moneda.php?op=guardaryeditar",
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
        { usuario: usuario, accion: "Moneda Registrado o Actualizado" },
        function (f) {

        }
    );
    limpiar();
}

function mostrar(idmoneda) {
    $.post(
        "../ajax/moneda.php?op=mostrar",
        { idmoneda: idmoneda },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#idmoneda").val(data.idtipomoneda);
            $("#nombre").val(data.moneda);
            $("#simbolo").val(data.simbolo);
            $("#tcambio").val(data.tipoCambio);

        }
    );
}

//funcion para descativar categorias
function desactivar(idmoneda) {
    bootbox.confirm("¿Estas seguro de eliminar la moneda?", function (result) {
        if (result) {
            $.post(
                "../ajax/moneda.php?op=desactivar",
                { idmoneda: idmoneda },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Desactivo Moneda: " + idmoneda },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}
//funcion para descativar categorias
function desactivarP(idmoneda) {
    bootbox.confirm("¿Estas seguro de desactivar la moneda?", function (result) {
        if (result) {
            $.post(
                "../ajax/moneda.php?op=desactivarP",
                { idmoneda: idmoneda },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Elimino Moneda: " + idmoneda },
                        function (f) {

                        }
                    );

                }
            );
        }
    });
}

function activar(idmoneda) {
    bootbox.confirm("¿Estas seguro de activar el moneda?", function (result) {
        if (result) {
            $.post(
                "../ajax/moneda.php?op=activar",
                { idmoneda: idmoneda },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();

                }
            );
            $.post(
                "../ajax/bitacora.php?op=insertar",
                { usuario: usuario, accion: "Activo Moneda: " + idmoneda },
                function (f) {

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