let error = false;
const previsualizacion = document.getElementById("previsualizacion").innerText;

let editor = ace.edit("editorPhp");
editor.setOptions({
    maxLines: Infinity,
    minLines: 20,
    fontSize: "100%",
});
editor.setTheme("ace/theme/monokai");
editor.getSession().setMode("ace/mode/php");


let editorAccion = ace.edit("editorPhpAccion");
editorAccion.setOptions({
    maxLines: Infinity,
    minLines: 20,
    fontSize: "100%",
});
editorAccion.setTheme("ace/theme/monokai");
editorAccion.getSession().setMode("ace/mode/php");


let editorScript = ace.edit("editorScript");
editorScript.setOptions({
    maxLines: Infinity,
    minLines: 20,
    fontSize: "100%",
});
editorScript.setTheme("ace/theme/monokai");
editorScript.getSession().setMode("ace/mode/javascript");


let editorHtml = ace.edit("editorHtml");
editorHtml.setOptions({
    maxLines: Infinity,
    minLines: 20,
    fontSize: "100%",
});
editorHtml.setTheme("ace/theme/monokai");
editorHtml.getSession().setMode("ace/mode/html");

const decodeSpecialTags = (html) => {
    const data = document.createElement("textarea");
    data.innerHTML = html;
    return data.value;
};

const hideEditors = (phpModulo, phpAccion, script, html) => {
    document.getElementById("editorPhp").style.display = (phpModulo) ? "block" : "none";
    document.getElementById("editorPhpAccion").style.display = (phpAccion) ? "block" : "none";
    document.getElementById("editorScript").style.display = (script) ? "block" : "none";
    document.getElementById("editorHtml").style.display = (html) ? "block" : "none";
};

hideEditors(true, false, false, false);

editor.setValue(decodeSpecialTags(dataArchivoModulo));
editorAccion.setValue(decodeSpecialTags(dataArchivoAccion));

document.getElementById("cbxEditor") && document.getElementById("cbxEditor").addEventListener("change", event => {
    switch (document.getElementById("cbxEditor").value) {
        case "modulo":
            hideEditors(true, false, false, false);
            editor.setValue(decodeSpecialTags(dataArchivoModulo));
            editor.getSession().setMode("ace/mode/php");
            break;

        case "accion":
            hideEditors(false, true, false, false);
            editorAccion.setValue(decodeSpecialTags(dataArchivoAccion));
            editor.getSession().setMode("ace/mode/php");
            break;

        case "script":
            hideEditors(false, false, true, false);
            editor.getSession().setMode("ace/mode/javascript");
            editorScript.setValue(dataArchivoScript);
            break;
        case "html":
            hideEditors(false, false, false, true);
            editor.getSession().setMode("ace/mode/php");
            editorHtml.setValue(dataArchivoModulo);
            break;
        default:
            break;
    }
});

// validaciones del formulario --------------------------------------------------------------------------------------------
document.getElementById("txtIdModuloNuevoInput").addEventListener("keyup", event => {
    if (document.getElementById("txtIdModuloNuevoInput").value.match(/\s/g)) {
        error = true;
        document.getElementById("errorInput").innerText = "El código del módulo no puede incluir espacios.";
        document.getElementById("previsualizacion").innerText = "Previsualización: Error de previsulización."
    } else {
        error = false;
        document.getElementById("txtIdModuloNuevoInput").style.border = "none";
        document.getElementById("previsualizacion").innerText = `Previsualización: http://www.portalesweb.hn/?mod=${document.getElementById("txtIdModuloNuevoInput").value}`;
        $.ajax({
            url: `./webservices/?accion=adminmodulos`,
            method: 'POST',
            data: {
                operacion: "verificar",
                idmodulo: document.getElementById("txtIdModuloNuevoInput").value,
            }
        }).done(response => {
            if (response.type === "success") {
                error = false;
                document.getElementById("errorInput").innerText = "El código es correcto.";
            } else {
                error = true;
                document.getElementById("errorInput").innerText = "El código ya existe.";
            }
        });
    }
});

document.getElementById("txtTituloModuloNuevoInput").addEventListener("blur", event => {
    if (document.getElementById("txtTituloModuloNuevoInput").value.trim() === "") {
        error = true;
        document.getElementById("infoInputTituloNuevo").style = "display:block";
        document.getElementById("infoInputTituloNuevo").innerText = "No te olvidés de ponerle título al módulo!";
    } else {
        error = false;
        document.getElementById("infoInputTituloNuevo").style = "display:none";
        document.getElementById("txtTituloModuloNuevoInput").style.border = "none";
    }
});

document.getElementById("txtTituloModuloNuevoInput").addEventListener("keyup", event => {
    if (document.getElementById("txtTituloModuloNuevoInput").value.trim() !== "") {
        document.getElementById("infoInputTituloNuevo").style = "display:none";
        document.getElementById("txtTituloModuloNuevoInput").style.border = "none";
    }
});

const validarFormulario = () => {
    // validar que el formulario de codigo tenga datos correctos.
    if (document.getElementById("txtIdModuloNuevoInput").value.trim() === "") {
        error = true;
        document.getElementById("errorInput").style = "display:block";
        document.getElementById("txtIdModuloNuevoInput").style.border = "1px solid red";
        document.getElementById("errorInput").innerText = "El módulo no puede ser creado sin código. Por favor ingresa un código.";
        document.getElementById("txtIdModuloNuevoInput").focus();
    } else {
        error = false;
        document.getElementById("errorInput").style = "display:none";
        document.getElementById("txtIdModuloNuevoInput").style.border = "none";
    }

    if (document.getElementById("txtTituloModuloNuevoInput").value.trim() === "") {
        error = true;
        document.getElementById("txtTituloModuloNuevoInput").style.border = "1px solid red";
        document.getElementById("txtTituloModuloNuevoInput").focus();
        document.getElementById("infoInputTituloNuevo").innerText = "No te olvidés de ponerle un título al módulo.";
    } else {
        error = false;
        document.getElementById("infoInputTituloNuevo").style.display = "none";
        document.getElementById("txtTituloModuloNuevoInput").style.border = "none";
    }
}
// validaciones del formulario --------------------------------------------------------------------------------------------
let isShowingModule = true;
const createButtonVisibility = (mostrar) => {
    const iconVisible = document.createElement("i");
    iconVisible.classList.add("far");
    iconVisible.classList.add("fa-eye");

    const iconNoVisible = document.createElement("i");
    iconNoVisible.classList.add("far");
    iconNoVisible.classList.add("fa-eye-slash");

    const label = document.createElement("label");

    const div = document.createElement("div");

    if (mostrar) {
        label.innerText = "El módulo será visible.";
        div.appendChild(iconVisible);
        div.appendChild(label);
        return (div);
    } else {
        label.innerText = "El módulo no será visible.";
        div.appendChild(iconNoVisible);
        div.appendChild(label);
        return (div);
    }
}

document.getElementById("btnMostrarUOcultarModulo").addEventListener("click", event => {
    document.getElementById("btnMostrarUOcultarModulo").innerHTML = "";
    isShowingModule = !isShowingModule;
    let icon = createButtonVisibility(isShowingModule);
    document.getElementById("btnMostrarUOcultarModulo").appendChild(icon);
});

editor.getSession().on("change", () => {
    dataArchivoModulo = editor.getValue();
});

let c = 0;
editorAccion.getSession().on("change", () => {
    c++;
    if (c !== 1) dataArchivoAccion = editorAccion.getValue();
});

const cleanForm = () => {

}

const irMenu = (preguntar = true) => {
    if (preguntar) {
        swal.fire({
            title: "Confirmación",
            text: `Serás redireccionado al menú de artículos`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, quiero ir",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                location.replace("./?mod=adminarticulos");
            }
        });
    } else location.replace("./?mod=adminmodulos");
}


const crearModulo = () => {
    validarFormulario();
    if (!error) {
        swal.fire({
            title: "Confirmación",
            text: `Se creará el módulo ${document.getElementById("txtIdModuloNuevoInput").value} con sus archivos correspondientes. ¿Estás de acuerdo?`,
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
                    url: `./webservices/?accion=adminmodulos`,
                    method: 'POST',
                    data: {
                        operacion: "crear",
                        idmodulo: document.getElementById("txtIdModuloNuevoInput").value,
                        modulo: document.getElementById("txtTituloModuloNuevoInput").value,
                        tipo: document.getElementById("selectTipoModuloNuevo") && document.getElementById("selectTipoModuloNuevo").value,
                        mostrartitulo: (isShowingModule) ? 1 : 0,
                        includejavascript: document.getElementById("cbxCrearJavascript") && document.getElementById("cbxCrearJavascript").checked
                    }
                }).done(response => {
                    if (response.type === "success") {
                        swal.fire(response).then(() => irMenu(false));
                    } else {
                        swal.fire(response);
                    }
                });
            }
        });
    }
};


const editarModulo = (tipo) => {
    validarFormulario();
    if (!error) {
        swal.fire({
            title: "Confirmación",
            text: `Se editará el módulo ${document.getElementById("txtIdModuloNuevoInput").value} con sus archivos correspondientes. ¿Estás de acuerdo?`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, editar",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                swal.fire({
                    text: "Guardando cambios...",
                    allowOutsideClick: false,
                });
                swal.showLoading();
                $.ajax({
                    url: `./webservices/?accion=adminmodulos`,
                    method: 'POST',
                    data: {
                        operacion: "editar",
                        idmodulo: document.getElementById("txtIdModuloNuevoInput").value,
                        modulo: document.getElementById("txtTituloModuloNuevoInput").value,
                        tipo,
                        mostrartitulo: (isShowingModule) ? 1 : 0,
                        contenidomodulo: editor.getValue(),
                        contenidoaccion: editorAccion.getValue(),
                        contenidojavascript: "",
                    }
                }).done(response => {
                    if (response.type === "success") {
                        swal.fire(response).then(() => irMenu(false));
                    } else {
                        swal.fire(response);
                    }
                });
            }
        });
    }
};
