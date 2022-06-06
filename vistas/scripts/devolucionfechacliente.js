var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init()
{
    listar();

    //Cargamos los items al select proveedor
    $.post("../ajax/venta.php?op=selectCliente2", function (r) {
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });	
    $("#fecha_inicio").change(listar);
    $("#fecha_fin").change(listar);
    $("#idcliente").change(listar);

}

function listar()
{
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var idcliente = $("#idcliente").val();

    tabla = $('#tblistado')
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
        .DataTable();
        $.post(
            "../ajax/bitacora.php?op=insertar",
            {usuario:usuario,accion:"Visualizó reporte de devoluciones"},
            function(f)
            {
                               
            }
        );
        $.post("../ajax/consultas.php?op=totalDevoluciones", { fecha_inicio:fecha_inicio, fecha_fin:fecha_fin,idcliente:idcliente }, function (data, status) {
            data = JSON.parse(data);
            console.log('si entro');
            console.log(data);
            if(data.total==null){
                $("#tventas").text(0);
            }else{
                $("#tventas").text(trunc(data.total,2));
            }
            
            
        });
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

init();