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
    $("#nombre").val("");
    $("#email").val("");
    $("#clave").val("");

    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");

    $("#idusuario").val("");

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
                    url: '../ajax/configuracion.php?op=listar',
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
            {usuario:usuario,accion:"Visualizó las configuraciones"}
        );
}

//funcion para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url: "../ajax/configuracion.php?op=guardaryeditar",
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
        {usuario:usuario,accion:"Configuración Registrada"}
    );
    limpiar();
}

function mostrar(idempresa)
{
    $.post("../ajax/configuracion.php?op=mostrar",{idempresa:idempresa},function(data,status)
        {
            data = JSON.parse(data);
            mostrarform(true);
            $("#empresa").val(data.nombre);
            $("#Eslogan").val(data.eslogan);
            $("#nit").val(data.nit);
            $("#direccion").val(data.direccion);
            $("#tel").val(data.telefono);
            $("#correo").val(data.correo);
            $("#mision").val(data.mision);
            $("#vision").val(data.vision);
            $("#Valores").val(data.valores);

            $("#imagenmuestra").show(); 
            $("#imagenmuestra").attr("src","../files/usuarios/"+data.logo); //agregamos el atributo src para mostrar la imagen
            $("#imagenactual").val(data.logo);
            $("#idempresa").val(data.idempresa);
        }
    );
    $.post(
        "../ajax/bitacora.php?op=insertar",
        {usuario:usuario,accion:"Visualizó detalle de configuración"},
        function(f)
        {
            
            
        }
    );
}

init();