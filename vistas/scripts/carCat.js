var tabla;

//Variables
var cont = 0;
var detalles= 0;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();
    listarCaracteristicas();
    $.post(
        "../ajax/carCat.php?op=selectCategoria",
        function(data)
        {
            $("#idcategoria").html(data);
            $("#idcategoria").selectpicker('refresh');
        }
    );

}

//funcion mostrar formulario
function mostrarform(flag)
{
    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();
        $("#estado").css('display',"none");
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
    mostrarform(false);
    location.reload();
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
                    url: '../ajax/carCat.php?op=listar',
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
            {usuario:usuario,accion:"Visualizo Caracteristicas de categorias"},
            function(f)
            {
               
            }
        );
}

function listarCaracteristicas()
{
    tabla = $('#tblarticulos')
        .dataTable(
            {
                "aProcessing":true, //Activamos el procesamiento del datatables
                "aServerSide":true, //Paginacion y filtrado realizados por el servidor
                dom: "Bfrtip", //Definimos los elementos del control de tabla
                buttons:[
                    
                ],
                "ajax":{
                    url: '../ajax/carCat.php?op=listarCar',
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
}

//funcion para guardar o editar
function editar(e)
{
    var idcategoria = $("#idcategoria").val();
    var caracteristicas = [];
    if(detalles!=0){
        for(var i=0; i<cont;i++){
            if($('#idcar'+i).val()!=undefined){
                caracteristicas.push($('#idcar'+i).val());
                console.log('idcar: '+$('#idcar'+i).val());
            }
            
        }
    }else{
        caracteristicas.push(-1);
    }
    
    
    $.post(
        "../ajax/carCat.php?op=editar",
        {idcategoria:idcategoria,caracteristicas:caracteristicas},
        function(e)
        {
            $.post(
                "../ajax/bitacora.php?op=insertar",
                {usuario:usuario,accion:"Caracteristicas Registradas"},
                function(f)
                {
                    bootbox.alert(e, function(){
                        cancelarform();
                    })
                }
            );
        }
    );       
}

function mostrar(idcategoria)
{
    $.post(
        "../ajax/carCat.php?op=mostrar",{idcategoria:idcategoria},function(data,status)
        {
            
            data = JSON.parse(data);   
            mostrarform(true);
            //colocar valores en los campos
            $("#idcategoria").val(data.idcategoria);
            $("#idcategoria").selectpicker('refresh');
            $("#descripcion").val(data.descripcion);   
            $("#cantcaracteristicas").val(data.cantidadcar);          
            cont=$('#cantcaracteristicas').val();
            detalles=$('#cantcaracteristicas').val();
            //Ocultar y mostrar botones
            $("#btnGuardar").show();
            $("#btnCancelar").show();

            $.post(
                "../ajax/carCat.php?op=listarDetalle&id="+idcategoria,function(r)
                {
                    // console.log(r);
                    $("#detalles").html("");
                    $("#detalles").html(r);
                    
                }
            );

        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Visualizo detalle de caracteristicas de la categoria con código "+idcategoria}
    );
}

function agregarDetalle(idcar,car,desplegable,opciones)
{
    if(!yaExiste(idcar)){
        if(idcar != "")
        {
            var fila = '<tr class="filas" id="fila'+cont+'"> ' +
                        '<td>'+
                            '<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button>'+
                        '</td>'+
                        '<td>' +
                            '<input type="hidden" name="idcar'+cont+'" id="idcar'+cont+'" value="'+idcar+'">'+
                            car +
                        '</td>'+
                        '<td>' +
                            '<span>'+desplegable+'</span>'+
                        '</td>'+
                        '<td>' +
                            '<span>'+opciones+'</span>'+
                        '</td>'+
                    '</tr>';

            cont++;
            detalles++;
            $("#detalles").append(fila);
        }
        else
        {
            alert("Error al ingresar el detalle, revisar los ddatos del articulo");
        }
    }
}

function yaExiste(idcar)
{
    for(var i=0; i<cont;i++){
        var id= $('#idcar'+i).val();
        if(id==idcar){
            bootbox.alert('Esta caracteristica ya está agregada');
            return true;
        }
    }
    return false;
}

function eliminarDetalle(indice)
{
    $("#fila" + indice).remove();
    detalles --;
}

init();