var tabla;

//Variables
var cont = 0;
var detalles = 0;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        editar(e);
    })


}

//funcion mostrar formulario
function mostrarform(flag) {
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();
        $("#estado").css('display', "none");
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform() {
    mostrarform(false);
    location.reload();
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
                    url: '../ajax/minimo.php?op=listar',
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
        { usuario: usuario, accion: "Visualizo Caracteristicas de categorias" },
        function (f) {

        }
    );
}

function listarCaracteristicas() {
    tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing": true, //Activamos el procesamiento del datatables
                "aServerSide": true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons: [

                ],
                "ajax": {
                    url: '../ajax/carCat.php?op=listarCar',
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
}

//funcion para guardar o editar
function editar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    var formData = new FormData($("#formulario")[0]);
    // console.log(formData)
    $.ajax({
        url: "../ajax/minimo.php?op=editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function (error) {
            console.log("error: " + error);
        }
    });

}

function mostrar(idcategoria, idTienda) {
    $.post(
        "../ajax/minimo.php?op=mostrar", { idcategoria: idcategoria, idTienda: idTienda }, function (data, status) {
            console.log(data)
            data = JSON.parse(data);
            mostrarform(true);
            $("#producto").val(data.producto);
            $("#idTienda").val(data.idtienda);
            $("#idcategoria").val(data.idproducto);
            $("#minimo").val(data.cantidadminima);
            $("#tiendatienda").val(data.tiendatienda);

            $("#btnGuardar").show();
            $("#btnCancelar").show();
        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizo detalle de caracteristicas de la categoria con código " + idcategoria }
    );
}

function agregarDetalle(idcar, car, desplegable, opciones) {
    if (!yaExiste(idcar)) {
        if (idcar != "") {
            var fila = '<tr class="filas" id="fila' + cont + '"> ' +
                '<td>' +
                '<button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button>' +
                '</td>' +
                '<td>' +
                '<input type="hidden" name="idcar' + cont + '" id="idcar' + cont + '" value="' + idcar + '">' +
                car +
                '</td>' +
                '<td>' +
                '<span>' + desplegable + '</span>' +
                '</td>' +
                '<td>' +
                '<span>' + opciones + '</span>' +
                '</td>' +
                '</tr>';

            cont++;
            detalles++;
            $("#detalles").append(fila);
        }
        else {
            alert("Error al ingresar el detalle, revisar los ddatos del articulo");
        }
    }
}

function yaExiste(idcar) {
    for (var i = 0; i < cont; i++) {
        var id = $('#idcar' + i).val();
        if (id == idcar) {
            bootbox.alert('Esta caracteristica ya está agregada');
            return true;
        }
    }
    return false;
}

function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    detalles--;
}

init();