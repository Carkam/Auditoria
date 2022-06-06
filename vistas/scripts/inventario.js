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

}

function listar()
{
    var idtienda = $("#idtienda").val();
    console.log(idtienda);
    if(idtienda==null || idtienda=='' || idtienda=='null' || idtienda==0){
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
                    url: '../ajax/consultas.php?op=inventario',
                    /*data:{idtienda:idtienda},*/
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
    }else{
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
                    url: '../ajax/consultas.php?op=inventarioxtienda',
                    data:{idtienda:idtienda},
                    type: "get",
                    dataType:"json",
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5, //Paginacion
                "order": [[0,"desc"]] //Ordenar (Columna, orden)
            
            })
        .DataTable();
    }
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Visualizo Inventarios"},
        function(f)
        {
           
        }
    );
    $.post("../ajax/consultas.php?op=totalInventario", { idtienda:idtienda}, function (data, status) {
        data = JSON.parse(data);
        console.log('si entro');
        console.log(data);
        if(data.total==null){
            $("#tventas").text('Q'+0);
        }else{
            $("#tventas").text('Q'+trunc(data.total,2));
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