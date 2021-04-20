const eliminarModulo = (tipo, idmodulo) => {
    swal.fire({
        title: "Confirmación",
        text: `Está a punto de eliminar el módulo: "${idmodulo}". ¿Está seguro que desea realizar esta acción? La eliminación de un módulo puede afectar el funcionamiento del blog.`,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#27ae60",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, eliminar.",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            swal.fire({
                text: "Eliminando...",
                allowOutsideClick: false,
            });
            swal.showLoading();

            $.ajax({
                url: `./webservices/?accion=adminmodulos`,
                method: 'POST',
                data: {
                    operacion: "eliminar",
                    idmodulo,
                    tipo
                }
            }).done(response => {
                if (response.type === "success") {
                    $("#moduloItem" + idmodulo).fadeOut("slow");
                    swal.fire(response);
                } else {
                    swal.fire(response);
                }
            });
        }
    });
};