var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select proveedor
    $.post("../ajax/tienda.php?op=selectTiendas", function (r) {
        $("#idtienda").html(r);
        $('#idtienda').selectpicker('refresh');
    });	
    $.post("../ajax/articulo.php?op=selectArticulo", function (r) {
        $("#idproducto").html(r);
        $('#idproducto').selectpicker('refresh');
    });	
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $("#fecha_inicio").val(today);
    $("#fecha_fin").val(today);
    $("#fecha_inicio").attr('max',today);
    $("#fecha_fin").attr('max',today);
    $("#fecha_inicio").change(listar);
    $("#fecha_fin").change(listar);
    $("#idcliente").change(listar);

}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var idcliente = $("#idcliente").val();

    /*tabla = $('#tblistado')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":{
                    url: '../ajax/consultas.php?op=devolucionfechacliente',
                    data:{fecha_inicio:fecha_inicio, fecha_fin:fecha_fin,idcliente:idcliente},
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 10, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();*/
        $.post(
            "../ajax/bitacora.php?op=insertar",
            {usuario:usuario,accion:"Visualizó reporte de devoluciones"},
            function(f)
            {
                               
            }
        );
}


init();