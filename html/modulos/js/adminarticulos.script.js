const eliminarArticulo = (idArticulo) => {
    swal.fire({
        title: "Advertencia",
        text: `Esta acción eliminará por completo el artículo y no se podrá revertir. ¿Quieres hacerlo de todas formas?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#27ae60",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            $("#" + idArticulo).fadeOut("slow");
            $.ajax({
                url: "./webservices/?accion=adminarticulo",
                method: "POST",
                data: {
                    operacion: "eliminar",
                    idarticulo: idArticulo,
                }
            }).done(response => {
                if (response.type == "success") {
                    console.log("response: ", response);
                }
            })
        }
    });
};