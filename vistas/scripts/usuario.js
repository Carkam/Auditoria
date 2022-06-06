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
    })

    $("#imagenmuestra").hide();

    $.post(
        "../ajax/usuario.php?op=selectEmpleado",
        function(data)
        {
            $("#Empleado").html(data);
            $("#Empleado").selectpicker('refresh');
        }
    );

    //Mostramos los permisos
    $.post(
        "../ajax/usuario.php?op=permisos&id=",
        function(data)
        {
            $("#permisos").html(data);
        }
    );
}

//funcion limpiar
function limpiar()
{
    $("#email").val("");
    $("#clave").val("");
    $("#idusuario").val("");
    $("#secretclave").val("");
    $("#usuario").val("");
    $("#Empleado").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
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
                    url: '../ajax/usuario.php?op=listar',
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
            {usuario:usuario,accion:"Visualizo los usuarios de personal"},
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
        url: "../ajax/usuario.php?op=guardaryeditar",
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
        {usuario:usuario,accion:"Registró usuario"},
        function(f)
        {
           
        }
    );
    limpiar();
}

function mostrar(idusuario)
{
    $.post("../ajax/usuario.php?op=mostrar",{idusuario:idusuario},function(data,status)
        {
            console.log(data);
            data = JSON.parse(data);
            mostrarform(true);
            console.log(data);
            $("#usuario").val(data.usuario);
            $("#clave").val(data.clave)
            $("#secretclave").val(data.clave)
            $("#Empleado").val(data.nombre);
            $("#Empleado").selectpicker('refresh');
            $("#clave").val(data.clave);
            $("#imagenmuestra").show(); 
            $("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen); //agregamos el atributo src para mostrar la imagen
            $("#imagenactual").val(data.imagen);
            $("#idusuario").val(data.idusuario);
        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Visualizo detalle de usuario con código "+idusuario},
        function(f)
        {
           
        }
    );
    $.post("../ajax/usuario.php?op=permisos&id="+idusuario,function(data)
        {
            $("#permisos").html(data);
        }
    );
}

//funcion para descativar categorias
function desactivar(idusuario)
{
    bootbox.confirm("¿Estas seguro de desactivar el Usuario?",function(result){
        if(result)
        {
            $.post(
                "../ajax/usuario.php?op=desactivar",
                {idusuario:idusuario},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Desactivó usuario con código "+idusuario},
                        function(f)
                        {
                           
                        }
                    );
                }
            );
        }
    });
}

function activar(idusuario)
{
    bootbox.confirm("¿Estas seguro de activar el Usuario?",function(result){
        if(result)
        {
            $.post(
                "../ajax/usuario.php?op=activar",
                {idusuario:idusuario},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Activó usuario con código "+idusuario},
                        function(f)
                        {
                           
                        }
                    );
                }
            );
        }
    });
}

function eliminar(idusuario)
{
    bootbox.confirm("¿Estas seguro de eliminar el Usuario?",function(result){
        if(result)
        {
            $.post(
                "../ajax/usuario.php?op=eliminar",
                {idusuario:idusuario},
                function(e)
                {
                    bootbox.alert(e);
                    tabla.ajax.reload();
                    $.post(
                        "../ajax/bitacora.php?op=insertar",
                        {usuario:usuario,accion:"Eliminó usuario con código "+idusuario},
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