
function mostrarNose() {
    $("#tienda").val(localStorage.getItem('Tienda'));
}

function obtenerNombreTienda() {
    let tiendaSeleccionada = $("#tienda option:selected").text();
    return tiendaSeleccionada;
}

function actualizarTienda() {
    let tiendaNueva = $("#tienda").val();
    localStorage.setItem('Tienda', tiendaNueva);
    window.location.reload();
}

mostrarNose();