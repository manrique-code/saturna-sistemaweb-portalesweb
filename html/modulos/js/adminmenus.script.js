document.getElementById("inputCreaMenu").addEventListener("keyup", event => {
    if (document.getElementById("inputCreaMenu").value.trim() !== "") {
        $.ajax({
            url: `./webservices/?accion=adminmenus`,
            method: 'POST',
            data: {
                operacion: "verificar",
                idmenu: document.getElementById("inputCreaMenu").value
            }
        }).done(response => {
            if (response.type == "success") {
                document.getElementById("informacionInputCrearMenu").style.color = "green";
                document.getElementById("informacionInputCrearMenu").innerText = "Correcto";
            } else {
                document.getElementById("informacionInputCrearMenu").style.color = "red";
                document.getElementById("informacionInputCrearMenu").innerText = "Este menú ya existe. Intenta con otro nombre.";
            };
        });
    } else {
        document.getElementById("informacionInputCrearMenu").style.color = "white";
    }
});

var elems = document.querySelectorAll('.modal');
var instances = M.Modal.init(elems);

const editarMenu = (idmenu, menu) => {
    document.getElementById("inputCreaMenu").value = menu;
    instances.open();
}

const crearMenu = () => {
    document.getElementById("inputCreaMenu").focus();
    if (document.getElementById("inputCreaMenu").value.trim() !== "") {
        swal.fire({
            title: "Confirmación",
            text: `Se creará el menú ${document.getElementById("inputCreaMenu").value.trim()}.`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, crear",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                swal.fire({
                    text: "Creando menú...",
                    allowOutsideClick: false,
                });
                swal.showLoading();
                $.ajax({
                    url: `./webservices/?accion=adminmenus`,
                    method: 'POST',
                    data: {
                        operacion: "crear",
                        menu: document.getElementById("inputCreaMenu").value,
                    }
                }).done(response => {
                    if (response.type === "success") {
                        console.log(response);
                        swal.fire(response);
                    } else {
                        console.log(response);
                        swal.fire(response);
                    }
                });
            }
        });
    } else document.getElementById("informacionInputCrearMenu").focus();
}


