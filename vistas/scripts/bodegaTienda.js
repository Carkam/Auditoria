var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(true);
    listar();

    /*$("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })*/

    //Cargamos los items al select categoria
    $.post(
        "../ajax/tienda.php?op=selectTienda",
        function(data)
        {        
            //console.log(data);
            $("#idtienda").html(data);
            $("#idtienda").selectpicker('refresh');
        }
    );

    $.post(
        "../ajax/tienda.php?op=selectBodega",
        function(data)
        {        
            //console.log(data);
            $("#idbodega").html(data);
            $("#idbodega").selectpicker('refresh');
        }
    );

}

//funcion limpiar
function limpiar()
{
    $("#idtienda").val("");
    $("#nombre").val("");
    $("#direccion").val("");
    $("#btnAgregarArt").prop("disabled",true);
    $("#btnAgregarArt").prop("title",'Seleccione primero la bodega y la tienda');
    $("#idtienda").val(0);
    $("#idtienda").selectpicker('refresh');
    $("#idbodega").val(0);
    $("#idbodega").selectpicker('refresh');
    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html(0);
}

function bloquear()
{
    if($("#idbodega").val()!=0){
        $("#idbodega").prop("disabled",true);
    }
    combosSelected();
}

function bloquearTienda()
{
    if($("#idtienda").val()!=0){
        $("#idtienda").prop("disabled",true);
    }
    combosSelected();
}

function combosSelected(){
    if($("#idtienda").val()!=0 && $("#idbodega").val()!=0){
        listarArticulos();
        $("#btnAgregarArt").prop("title",'Agregar artículos');
        $("#btnAgregarArt").prop("disabled",false);
    }
}

function desbloquear(mensaje)
{
    $("#idbodega").prop("disabled",false);
    $("#idtienda").prop("disabled",false);
   //falta limpiar
   limpiar();
   if(mensaje){
    bootbox.alert("Datos limpiados\n Tienda y bodega desbloqueados");
   }
   
}

//funcion mostrar formulario
function mostrarform(flag)
{
    limpiar();

    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

//Funcion listar
function listar()
{
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
                    url: '../ajax/tienda.php?op=listarBodega',
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

function listarArticulos()
{
    var idbodega = $("#idbodega").val();
    var idtienda = $("#idtienda").val();
    tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/ingreso.php?op=listarArticulosBodega',
                    data:{idbodega:idbodega,idtienda:idtienda},
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

//funcion para guardar o editar
function guardaryeditar(e)
{
    var idbodega = $("#idbodega").val();
    var idtienda = $("#idtienda").val();
    var articulos = [];
    var cantidad = [];
    var stockBodega = [];
    var stockTienda = [];
    for(var i=0; i<cont;i++){
        if($('#idarticulo'+i).val()!=undefined){
            articulos.push($('#idarticulo'+i).val());
            cantidad.push($('#cantidad'+i).val());
            stockBodega.push($('#stock'+i).val());
            stockTienda.push($('#stockTienda'+i).val()); 
        }
               
    }
    bootbox.confirm("¿Estas seguro de mover los productos de la Bodega a la tienda elegida ?",function(result){
        if(result)
        {
            $.post(
                "../ajax/tienda.php?op=moverProductos",
                {idbodega:idbodega,idtienda:idtienda,articulos:articulos,cantidad:cantidad,stockBodega:stockBodega,stockTienda:stockTienda},
                function(e)
                {
                    bootbox.alert(e);
                    desbloquear(false);
                }
            );
            $.post(
                "../ajax/bitacora.php?op=insertar",
                {usuario:usuario,accion:"Productos movidos de bodega con código "+idbodega+" a tienda con código "+idtienda},
                function(f)
                {
                   
                }
            );
        }
    });
}

function mostrar(idtienda)
{
    $.post(
        "../ajax/tienda.php?op=mostrar",
        {idtienda:idtienda},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);
           
            $("#idtienda").val(data.idTienda);
            $("#idmunicipio").val(data.idMunicipio);
            $('#idmunicipio').selectpicker('refresh');
            $("#nombre").val(data.nombre);
            $("#direccion").val(data.direccion);    

        }
    );
    
}

//funcion para descativar categorias
function desactivar(idtienda)
{
    /*bootbox.confirm("¿Estas seguro de desactivar la Bodega?",function(result){
        if(result)
        {
            $.post(
                "../ajax/tienda.php?op=desactivarBodega",
                {idtienda:idtienda},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });*/
}

function activar(idarticulo)
{
    /*bootbox.confirm("¿Estas seguro de activar la bodega?",function(result){
        if(result)
        {
            $.post(
                "../ajax/tienda.php?op=activarBodega",
                {idarticulo:idarticulo},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
        
                }
            );
        }
    });*/
}

var cont = 0;

function agregarDetalle(idarticulo,articulo,stock,stocktienda)
{
    
    var cantidad = 1;
    if(!yaExiste(idarticulo)){
        if(idarticulo != "")
        {
            var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                        '<td>'+
                            '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                        '</td>'+
                        '<td>' +
                            '<input type="hidden" name="idarticulo'+cont+'" id="idarticulo'+cont+'" value="'+idarticulo+'">'+
                            articulo +
                        '</td>'+
                        '<td>' +
                                '<input type="hidden" name="stock'+cont+'" id="stock'+cont+'" value="'+stock+'">'+
                                '<input type="hidden" name="stockTienda'+cont+'" id="stockTienda'+cont+'" value="'+stocktienda+'">'+
                            '<input type="number" name="cantidad'+cont+'" id="cantidad'+cont+'" onchange="calcularTotales()" min="1" max="'+stock+'"  value="'+cantidad+'"  >'+
                        '</td>'
                    '</tr>';

            cont++;
            detalles++;
            $("#detalles").append(fila);
            calcularTotales(); 
        }
        else
        {
            alert("Error al ingresar el detalle, revisar los ddatos del articulo");
        }
    }
    
}

function yaExiste(idarticulo)
{
    for(var i=0; i<cont;i++){
        var id= $('#idarticulo'+i).val();
        if(id==idarticulo){
            bootbox.alert('Este producto ya está agregado');
            return true;
        }
    }
    return false;
}

function eliminarDetalle(indice)
{
    $("#fila" + indice).remove();
    detalles--;
    calcularTotales();
}

function calcularTotales()
{
    var total=0;
    for(var i=0; i<cont;i++){
        if($('#cantidad'+i).val()!=undefined){
            var cantidad= $('#cantidad'+i).val();
            var stock= $('#stock'+i).val();
            if(parseInt(cantidad)>parseInt(stock)){
                bootbox.alert('La cantidad no puede ser mayor a la de stock, se pondrá el valor máximo');
                $('#cantidad'+i).val(stock);
                cantidad = stock;
            }else if(parseInt(cantidad)<1){
                bootbox.alert('La cantidad no puede ser menor a 1');
                $('#cantidad'+i).val(1);
                cantidad = 1;
            }
            total += parseInt(cantidad);
        }
        
        console.log('cantidad '+i+' '+$('#cantidad'+i).val()+' '+typeof($('#cantidad'+i).val()));
        console.log('stock '+i+' '+$('#stock'+i).val()+' '+typeof($('#stock'+i).val()));
        console.log('total '+i+' '+total+' '+typeof(total));  
    }
    
    $("#total").html(total);
    $("#total_compra").val(total);

    //evaluar();
}

function generarbarcode()
{
    /*var codigo = $("#codigo").val();
    JsBarcode("#barcode",codigo);
    $("#print").show();*/
}

function imprimir()
{
    /*$("#print").printArea();*/
}

init();