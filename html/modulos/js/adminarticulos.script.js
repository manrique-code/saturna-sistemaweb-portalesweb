const eliminarArticulo = (idArticulo) => {
    swal.fire({
        title: "Advertencia",
        text: "Esta acción eliminará por completo el artículo y no se podrá revertir. ¿Quieres hacerlo de todas formas?",
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

const ocultarArticulo = (idArticulo, estado) => {
    // document.getElementById(`visibilidad-${idArticulo}`).innerHTML = "";
    console.log("data a enviarse: ", {
        operacion: "mostrarocultar",
        idarticulo: idArticulo,
        estate: (estado)
            ? `<a class="btn-accion-table" href="javascript:ocultarArticulo(${idArticulo}, 0)"><i class="far fa-eye"></i></a>`
            : `<a class="btn-accion-table" href="javascript:ocultarArticulo(${idArticulo}, 1)"><i class="far fa-eye-slash"></i></a>`
    });
    $.ajax({
        url: "./webservices/?accion=adminarticulo",
        method: "POST",
        data: {
            operacion: "mostrarocultar",
            idarticulo: idArticulo,
            estado,
        }
    }).done(response => {
        if (response.type == "success") {
            console.log(response);
            document.getElementById(`visibilidad-${idArticulo}`).innerHTML = (estado)
                ? `<a class="btn-accion-table" href="javascript:ocultarArticulo(${idArticulo}, 0)"><i class="far fa-eye"></i></a>`
                : `<a class="btn-accion-table" href="javascript:ocultarArticulo(${idArticulo}, 1)"><i class="far fa-eye-slash"></i></a>`
        } else swal.fire({ response });
    })
};