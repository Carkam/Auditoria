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
    $("#nombre").val("");
    $("#nit").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#idpersona").val("");
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
                    url: '../ajax/proveedor.php?op=listarp',
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
        { usuario: usuario, accion: "Visualizo Proveedores" },
        function (f) {

        }
    );
}

//funcion para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento


    /** */
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
            $("#btnGuardar").prop("disabled", true);
            var formData = new FormData($("#formulario")[0]);

            $.ajax({
                url: "../ajax/proveedor.php?op=guardaryeditar",
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
                { usuario: usuario, accion: "Proveedor Registrado" },
                function (f) {

                }
            );
            limpiar();
        } else {
            bootbox.alert('El NIT no debe de contener letras');
        }
    }
    /** */




}

function mostrar(idpersona) {
    $.post(
        "../ajax/proveedor.php?op=mostrar",
        { idpersona: idpersona },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.nombre);

            $("#direccion").val(data.direccion);
            $("#telefono").val(data.telefono);
            $("#nit").val(data.nit);
            $("#email").val(data.correo);
            $("#idpersona").val(data.idProveedor);

        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizo detalle de proveedor con código " + idpersona },
        function (f) {

        }
    );
}


function eliminar(idpersona) {
    bootbox.confirm("¿Estas seguro de eliminar el Proveedor?", function (result) {
        if (result) {
            $.post(
                "../ajax/proveedor.php?op=eliminar",
                { idpersona: idpersona },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Eliminó proveedor con código " + idpersona },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function desactivarP(idpersona) {
    bootbox.confirm("¿Estas seguro de desactivar el Proveedor?", function (result) {
        if (result) {
            $.post(
                "../ajax/proveedor.php?op=desactivarP",
                { idpersona: idpersona },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Elimino Proveedor: " + idpersona },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function activar(idpersona) {
    bootbox.confirm("¿Estas seguro de activar el Proveedor?", function (result) {
        if (result) {
            $.post(
                "../ajax/proveedor.php?op=activar",
                { idpersona: idpersona },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Activo Proveedor: " + idpersona },
                        function (f) {

                        }
                    );

                }
            );
        }
    });
}


function isNumeric(str) {
    return /^\d+$/.test(str);
}
init();