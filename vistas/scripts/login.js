$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();
    usuarioa = $("#usuarioa").val();
    clavea = $("#clavea").val();
    tienda = $("#tienda").val();
    localStorage.setItem("Tienda", tienda);

    $.post("../ajax/usuario.php?op=verificar",
        {
            usuarioa: usuarioa,
            clavea: clavea,
            tienda: tienda
        },
        function (data) {
            if (data != 'null') {
                $.post(
                    "../ajax/bitacora.php?op=insertar2",
                    { usuario: usuarioa, clave: clavea, accion: "Usuario inició sesión" },
                    function (f) {
                        //bootbox.alert(f);
                    }
                );
                $(location).attr("href", "escritorio.php");
                // bootbox.alert("Todo bien");
            }
            else {
                bootbox.alert("Usuario o contraseña incorrecta");
            }
        }
    );
})


$("#frmOlvide").on('submit', function (e) {
    e.preventDefault();
    usuarioa = $("#usuarioa").val();
    clavea = $("#clavea").val();
    $.post("../ajax/olvide.php?op=verificar",
        {
            usuarioa: usuarioa,
            clavea: clavea
        },
        function (data) {
            if (data != 'null') {
                $(location).attr("href", "login.php");
                // bootbox.alert("Todo bien");
            }
            else {
                bootbox.alert("Correo Invalido incorrecta");
            }
        }
    );
})