let error = false;
let editor;
let editorPhp;
let edtiorjs;

const decodeSpecialTags = (html) => {
    const data = document.createElement("textarea");
    data.innerHTML = html;
    return data.value;
};

if (tipoArchivo == 1) {
    document.getElementById("editorPHP").style.display = "block";
    editorPhp = ace.edit("editorPHP");
    editorPhp.setOptions({
        maxLines: Infinity,
        minLines: 20,
        fontSize: "100%",
    });
    editorPhp.setTheme("ace/theme/monokai");
    editorPhp.getSession().setMode("ace/mode/php");
    editorPhp.setValue(decodeSpecialTags(contenido));
}

$(document).ready(function () {
    if (tipoArchivo == 0) editor.setData(decodeSpecialTags(contenido));
});


edtiorjs = document.getElementById("editorJs") && ace.edit("editorJs");
document.getElementById("editorJs") && edtiorjs.setOptions({
    maxLines: Infinity,
    minLines: 20,
    fontSize: "100%",
});
document.getElementById("editorJs") && edtiorjs.setTheme("ace/theme/monokai");
document.getElementById("editorJs") && edtiorjs.getSession().setMode("ace/mode/javascript");
document.getElementById("editorJs") && edtiorjs.setValue(decodeSpecialTags(jscontent));

const hideEditors = (phpModulo, phpAccion, html) => {
    document.getElementById("editorPHP").style.display = (phpModulo) ? "block" : "none";
    document.getElementById("editorJs").style.display = (phpAccion) ? "block" : "none";
    (!html) ? (tipoArchivo == 0) ? editor.destroy() : null : ClassicEditor.create(document.querySelector("#editorHtml")).then(newEditor => { editor = newEditor }).catch(error => console.log(error));
};

(tipoArchivo != 5) ? (tipoArchivo == 1) ? hideEditors(true, false, false) : hideEditors(false, false, true) : null;

document.getElementById("cboTipoArchivo") && document.getElementById("cboTipoArchivo").addEventListener("change", event => {
    switch (document.getElementById("cboTipoArchivo").value) {
        case "HTML":
            editor.setData(decodeSpecialTags(contenido));
            hideEditors(false, false, true);
            break;
        case "javascript":
            edtiorjs.setValue(decodeSpecialTags(jscontent));
            hideEditors(false, true, false);
            break;
        case "PHP":
            editorPhp.setValue(decodeSpecialTags(contenido));
            hideEditors(true, false, false);
            break;
        default:
            break;
    }
});

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

tipoArchivo != 5 && editorPhp.getSession().on("change", () => {
    contenido = editorPhp.getValue();
});

let c = 0;
tipoArchivo != 5 && edtiorjs.getSession().on("change", () => {
    c++;
    if (c !== 1) jscontent = edtiorjs.getValue();
});

const editar = (idbloque, tipo) => {
    swal.fire({
        title: "Confirmación",
        text: `Se editará el bloque con sus archivos correspondientes. ¿Estás de acuerdo?`,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#27ae60",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, editar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            console.log("Data a enviar", {
                idbloque,
                bloque: document.getElementById("txtBloqueName").value,
                tipo,
                mostrartitulo: 0,
                contenidoBloque: (tipoArchivo == 1) ? editorPhp.getValue() : editor.getData(),
                contenidoScript: edtiorjs.getValue()
            });
            swal.fire({
                text: "Enviando datos",
                allowOutsideClick: false,
            });
            swal.showLoading();
            $.ajax({
                url: `./webservices/?accion=adminbloques`,
                method: 'POST',
                data: {
                    operacion: "editar",
                    idbloque,
                    bloque: document.getElementById("txtBloqueName").value,
                    tipo,
                    mostrartitulo: 0,
                    contenidoBloque: (tipoArchivo == 1) ? editorPhp.getValue() : editor.getData(),
                    contenidoScript: edtiorjs.getValue()
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
                    mostrartitulo: 0,
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