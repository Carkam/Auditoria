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
        "../ajax/articulo.php?op=selectCategoria",
        function (data) {

            //console.log(data);
            $("#idcategoria").html(data);
            $("#idcategoria").selectpicker('refresh');
        }
    );

    $.post(
        "../ajax/articulo.php?op=listarCatP&categoriaID=1",
        function (data) {
            $("#caractcategoria").html("");
            $("#caractcategoria").html(data);
        }
    );
    //Cargamos los items al select categoria
    $.post(
        "../ajax/articulo.php?op=selectProveedor",
        function (data) {

            //console.log(data);
            $("#idproveedor").html(data);
            $("#idproveedor").selectpicker('refresh');
        }
    );

    $("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar() {
    $("#idarticulo").val("");
    $("#nombre").val("");
    $("#ganancia").val("");


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
                    url: '../ajax/ganancia.php?op=listar',
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
        { usuario: usuario, accion: "Visualizó los articulos" },
        function (f) {

        }
    );
}



//funcion para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/ganancia.php?op=guardaryeditar",
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


    limpiar();

}

function mostrar(idarticulo) {
    $.post(
        "../ajax/ganancia.php?op=mostrar",
        { idarticulo: idarticulo },
        function (data, status) {
            
            data = JSON.parse(data);
            console.log(data);
            mostrarform(true);

            $("#idarticulo").val(data.idproducto);
            $("#nombre").val(data.nombre);
            $("#ganancia").val(data.ganancia);
            $("#conf").val(data.conf);
            $("#conf").refresh();

        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        { usuario: usuario, accion: "Visualizó detalle del Articulo" + idarticulo },
        function (f) {

        }
    );
}

//funcion para descativar categorias
function desactivar(idarticulo) {
    bootbox.confirm("¿Estas seguro de Eliminar el Articulo?", function (result) {
        if (result) {
            $.post(
                "../ajax/articulo.php?op=desactivar",
                { idarticulo: idarticulo },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Eliminar Articulo: " + idarticulo },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function desactivarP(idarticulo) {
    bootbox.confirm("¿Estas seguro de Desactivo el Articulo?", function (result) {
        if (result) {
            $.post(
                "../ajax/articulo.php?op=desactivarP",
                { idarticulo: idarticulo },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Desactivo articulo: " + idarticulo },
                        function (f) {

                        }
                    );
                }
            );
        }
    });
}

function activar(idarticulo) {
    bootbox.confirm("¿Estas seguro de activar el Articulo?", function (result) {
        if (result) {
            $.post(
                "../ajax/articulo.php?op=activar",
                { idarticulo: idarticulo },
                function (e) {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        { usuario: usuario, accion: "Activo Articulo: " + idarticulo },
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

$("#idcategoria").on('change', function (e) {

    let variable = $("#idcategoria").val();
    $.post(
        "../ajax/articulo.php?op=listarCatP&categoriaID=" + variable,
        function (data) {
            // console.log(data)
            $("#caractcategoria").html("");
            $("#caractcategoria").html(data);
        }
    );

});



init();