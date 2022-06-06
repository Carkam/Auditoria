var tabla;
var usuario = $("#idusuario").val();
//Funcion que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    });
}

//funcion limpiar
function limpiar()
{
    $("#nombre").val("");
    $("#fechanac").val("");
    $("#fechaing").val("");
    $("#correo").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#idempleado").val("");
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
                    url: '../ajax/trabajador.php?op=listarp',
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
        $.post(
            "../ajax/bitacora.php?op=insertar",
            {usuario:usuario,accion:"Visualizo Trabajadores"},
            function(f)
            {
               
            }
        );
}

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url: "../ajax/trabajador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            //console.log("succes");
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        },
        error: function(error)
        {
            console.log("error: " + error);
        } 
    });
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Registró trabajadores"},
        function(f)
        {
           
        }
    );
    limpiar();
}

function mostrar(idempleado)
{
    $.post("../ajax/trabajador.php?op=mostrar",{idempleado:idempleado},
        function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);

            $("#nombre").val(data.nombre);
            $("#apellido").val(data.apellido);
            $("#fechanac").val(data.fechanacimiento);
            $("#fechaing").val(data.fechaingreso);
            $("#correo").val(data.correo);
            $("#telefono").val(data.telefono);
            $("#direccion").val(data.direccion);
            $("#idempleado").val(data.idempleado);
        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Visualizo detalle de trabajador con código "+idempleado},
        function(f)
        {
           
        }
    );
}

function desactivar(idempleado)
{
    bootbox.confirm("¿Estas seguro de inactivar el trabajador?",function(result){
        if(result)
        {
            $.post(
                "../ajax/trabajador.php?op=desactivar",
                {idempleado:idempleado},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Desactivó empleado con código "+idempleado},
                        function(f)
                        {
                           
                        }
                    );
                }
            );
        }
    });
}

function activar(idempleado)
{
    bootbox.confirm("¿Estas seguro de activar el trabajador?",function(result){
        if(result)
        {
            $.post(
                "../ajax/trabajador.php?op=activar",
                {idempleado:idempleado},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Activó empleado con código "+idempleado},
                        function(f)
                        {
                           
                        }
                    );
                }
            );
        }
    });
}

function eliminar(idempleado)
{
    bootbox.confirm("¿Estas seguro de eliminar el Trabajador? ",function(result){
        if(result)
        {
            $.post(
                "../ajax/trabajador.php?op=eliminar",
                {idempleado:idempleado},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Eliminó empleado con código "+idempleado},
                        function(f)
                        {
                           
                        }
                    );
                }
            );
        }
    });
}

init();