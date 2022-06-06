function mostrarGrafica(bandera) {
    if (bandera) {
        $("#dia1").show();
        $("#dia2").show();
        $("#mes1").hide();
        $("#mes2").hide();
    } else {
        $("#dia1").hide();
        $("#dia2").hide();
        $("#mes1").show();
        $("#mes2").show();
    }
}

function mostrarNose() {
    $("#tienda").val(localStorage.getItem('Tienda'));
}

mostrarNose();
mostrarGrafica(true);
