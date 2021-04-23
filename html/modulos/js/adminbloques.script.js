let error = false;
document.getElementById("txtIdbloque") && document.getElementById("txtIdbloque").addEventListener("blur", event => {
    if (document.getElementById("txtIdbloque").value.trim() === "") {
        error = true;
        document.getElementById("txtIdbloque").style.border = "1px solid red";
        document.getElementById("infoTxtIdBloque").innerText = "No introducir un codigo para el bloque.";
        document.getElementById("infoTxtIdBloque").style.color = "red";
    } else {
        error = false;
        document.getElementById("txtIdbloque").style.border = "1px solid grey";
        document.getElementById("infoTxtIdBloque").style.color = "transparent";
    }
});

document.getElementById("txtIdbloque") && document.getElementById("txtIdbloque").addEventListener("keyup", event => {
    if (document.getElementById("txtIdbloque").value.trim().match(/\s/g)) {
        error = true;
        document.getElementById("txtIdbloque").style.border = "1px solid red";
        document.getElementById("infoTxtIdBloque").innerText = "Los codigos de los bloques no pueden llevar espacios.";
        document.getElementById("infoTxtIdBloque").style.color = "red";
    } else {
        error = false;
        document.getElementById("txtIdbloque").style.border = "1px solid grey";
        document.getElementById("infoTxtIdBloque").style.color = "green";
        $.ajax({
            url: `./webservices/?accion=adminbloques`,
            method: 'POST',
            data: {
                operacion: "verificar",
                idbloque: document.getElementById("txtIdbloque").value,
            }
        }).done(response => {
            if (response.type === "success") {
                error = false;
                document.getElementById("infoTxtIdBloque").innerText = "El código es correcto.";
            } else {
                error = true;
                document.getElementById("infoTxtIdBloque").innerText = "El código ya existe.";
                document.getElementById("infoTxtIdBloque").style.color = "red";
            }
        });
    }
});

const eliminar = (idbloque, tipo) => {
    swal.fire({
        title: "Confirmación",
        text: `Se eliminará el bloque con sus archivos correspondientes. ¿Estás de acuerdo?`,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "red",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            swal.fire({
                text: "Enviando datos",
                allowOutsideClick: false,
            });
            swal.showLoading();
            $.ajax({
                url: `./webservices/?accion=adminbloques`,
                method: 'POST',
                data: {
                    operacion: "eliminar",
                    idbloque,
                    tipo
                }
            }).done(response => {
                if (response.type === "success") {
                    console.log(response);
                    swal.fire(response).then(() => irMenu(false));
                } else {
                    console.log(response);
                    swal.fire(response);
                }
            });
        }
    });
}

const irMenu = (preguntar = true) => {
    if (preguntar) {
        swal.fire({
            title: "Confirmación",
            text: `Serás redireccionado al menú de bloques`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, quiero ir",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                location.replace("./?mod=adminbloques");
            }
        });
    } else location.replace("./?mod=adminbloques");
}

const crear = () => {
    swal.fire({
        title: "Confirmación",
        text: `Se creará el bloque ${document.getElementById("txtIdbloque").value} con sus archivos correspondientes. ¿Estás de acuerdo?`,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#27ae60",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, crear",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            swal.fire({
                text: "Enviando datos",
                allowOutsideClick: false,
            });
            swal.showLoading();
            $.ajax({
                url: `./webservices/?accion=adminbloques`,
                method: 'POST',
                data: {
                    operacion: "crear",
                    idbloque: document.getElementById("txtIdbloque").value,
                    bloque: document.getElementById("txtBloqueName").value,
                    tipo: document.getElementById("cboTipoArchivo").value,
                    mostrartitulo: 1,
                    javascript: document.getElementById("chbxJavascript").checked,
                }
            }).done(response => {
                if (response.type === "success") {
                    console.log(response);
                    swal.fire(response).then(() => irMenu(false));
                } else {
                    console.log(response);
                    swal.fire(response);
                }
            });
        }
    });
};