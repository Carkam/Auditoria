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
    $("#idcliente").val("");
    $("#apellido").val("");
    $("#fechan").val("");
    $("#email").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#nit").val("");
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
                    url: '../ajax/cliente.php?op=listarp',
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
        { usuario: usuario, accion: "Visualizó los clientes" },
        function (f) {

        }
    );
}

//funcion para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    /** */
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
                url: "../ajax/cliente.php?op=guardaryeditar",
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
                { usuario: usuario, accion: "Cliente Registrado o Actualizado" },
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

function mostrar(idcliente) {
    $.post(
        "../ajax/cliente.php?op=mostrar",
        { idcliente: idcliente },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.Nombre);
            $("#apellido").val(data.Apellido);
            $("#fechan").val(data.FechaNacimiento);
            $("#direccion").val(data.Direccion);
            $("#telefono").val(data.Telefono);
            $("#email").val(data.Correo);
            $("#nit").val(data.NIT);
            $("#idcliente").val(data.idCliente);

        }
    );
}


function eliminar(idcliente) {
    bootbox.confirm("¿Estas seguro de eliminar el Cliente?", function (result) {
        if (result) {
            $.post(
                "../ajax/cliente.php?op=eliminar",
                { idcliente: idcliente },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Elimino Cliente: " + idcliente },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function desactivar(idcliente) {
    bootbox.confirm("¿Estas seguro de desactivar el Cliente?", function (result) {
        if (result) {
            $.post(
                "../ajax/cliente.php?op=desactivar",
                { idcliente: idcliente },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Desactivo Cliente: " + idcliente },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function activar(idcliente) {
    bootbox.confirm("¿Estas seguro de activar el Cliente?", function (result) {
        if (result) {
            $.post(
                "../ajax/cliente.php?op=activar",
                { idcliente: idcliente },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Activo Cliente: " + idcliente },
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