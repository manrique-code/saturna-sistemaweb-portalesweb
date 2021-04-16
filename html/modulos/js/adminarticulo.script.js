const tagCategorias = document.getElementById("tag-categorias");
const totalSelectElements = (document.getElementById("cbo-categorias")) && document.getElementById("cbo-categorias").childElementCount;
// const menu = document.getElementById("menu");
let error = false;
let editor;

// adding the editor to the form
ClassicEditor.create(document.querySelector("#editor")).then(newEditor => { editor = newEditor }).catch(error => console.log(error));

console.log("Datos de contenido: ", document.getElementById("contenido-articulo").innerHTML);

document.getElementById("cbx-cargar-contenido").addEventListener("click", () => {
    if (document.getElementById("cbx-cargar-contenido").checked)
        editor.setData(document.getElementById("contenido-articulo").innerHTML);
    else
        editor.setData("");
});


// ---------------------------------------VALIDACIONES------------------------------------------------------------------------------------------------
document.getElementById("txt-titulo-articulo").addEventListener("blur", e => {
    if (document.getElementById("txt-titulo-articulo").value === "") {
        error = true;
        console.log(document.getElementById("txt-titulo-articulo").value);
        e.target.style.border = "1px solid #c23616";
        if (document.getElementById("error-titulo") === null)
            document.getElementById("txt-titulo-articulo").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px' id='error-titulo'>Inserta el titulo del artículo</p>"
            );
        else {
            document.getElementById("error-titulo").remove();
            document.getElementById("txt-titulo-articulo").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px'id='error-titulo'>Inserta el titulo del artículo</p>"
            );
        }

    } else {
        error = false;
        e.target.style.border = "1px solid rgba(0, 0, 0, 0.5)";
        (document.getElementById("error-titulo") === null)
            ? null
            : document.getElementById("error-titulo").remove();
    }
});

// validando que las etiquetas tenga datos cuando se cambia de input
document.getElementById("txt-tags").addEventListener("blur", e => {
    if (document.getElementById("txt-tags").value == "") {
        error = true;
        e.target.style.border = "1px solid #c23616";
        if (document.getElementById("error-tags") === null)
            document.getElementById("txt-tags").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px' id='error-tags'>Provee algunas tags para tener busquedas optimizadas</p>"
            );
        else {
            document.getElementById("error-tags").remove();
            document.getElementById("txt-tags").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px'id='error-tags'>Provee algunas tags para tener busquedas optimizadas</p>"
            );
        }

    } else {
        error = false;
        e.target.style.border = "1px solid rgba(0, 0, 0, 0.5)";
        (document.getElementById("error-tags") === null)
            ? null
            : document.getElementById("error-tags").remove();
    }
});

document.getElementById("txt-tags").addEventListener("keyup", e => {
    document.getElementById("txt-tags").style.border = "1px solid rgba(0, 0, 0, 0.5)";
    (document.getElementById("error-tags") === null)
        ? null
        : document.getElementById("error-tags").remove();
});


const validarFormulario = (create = true) => {
    // haciendo validaciones al formulario
    if (document.getElementById("txt-titulo-articulo").value == "") {
        error = true;
        document.getElementById("txt-titulo-articulo").style.border = "1px solid #c23616";
        document.getElementById("txt-titulo-articulo").focus();
        if (document.getElementById("error-titulo") === null)
            document.getElementById("txt-titulo-articulo").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px' id='error-titulo'>Inserta el titulo del artículo</p>"
            );
        else {
            document.getElementById("error-titulo").remove();
            document.getElementById("txt-titulo-articulo").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px'id='error-titulo'>Inserta el titulo del artículo</p>"
            );
        }

    } else {
        error = false;
        document.getElementById("txt-titulo-articulo").style.border = "1px solid rgba(0, 0, 0, 0.5)";
        (document.getElementById("error-titulo") === null)
            ? null
            : document.getElementById("error-titulo").remove();
    }

    if (create) {
        // validando el select para ver que el usuario seleccione aunque sea una opcion
        if (document.getElementById("tag-categorias") && document.getElementById("tag-categorias").childElementCount == 0) {
            error = true;
            document.getElementById("cbo-categorias").style.border = "1px solid #c23616";
            document.getElementById("cbo-categorias").focus();
            if (document.getElementById("error-categorias") === null)
                document.getElementById("cbo-categorias").insertAdjacentHTML(
                    "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px' id='error-categorias'>Selecciona al menos una categoría para este artículo.</p>"
                );
            else {
                document.getElementById("error-categorias").remove();
                document.getElementById("cbo-categorias").insertAdjacentHTML(
                    "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px'id='error-categorias'>Selecciona al menos una categoría para este artículo.</p>"
                );
            }

        } else {
            error = false;
            document.getElementById("cbo-categorias").style.border = "1px solid rgba(0, 0, 0, 0.5)";
            (document.getElementById("error-categorias") === null)
                ? null
                : document.getElementById("error-categorias").remove();
        }
    }

    // validando las tags del formulario
    if (document.getElementById("txt-tags").value.trim() == "") {
        error = true;
        document.getElementById("txt-tags").style.border = "1px solid #c23616";
        document.getElementById("txt-tags").focus();
        if (document.getElementById("error-tags") === null)
            document.getElementById("txt-tags").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px' id='error-tags'>Provee algunas tags para tener busquedas optimizadas.</p>"
            );
        else {
            document.getElementById("error-tags").remove();
            document.getElementById("txt-tags").insertAdjacentHTML(
                "afterend", "<p style='color:#c23616; margin: 0; font-size: 13px'id='error-tags'>Provee algunas tags para tener busquedas optimizadas.</p>"
            );
        }

    } else {
        error = false;
        document.getElementById("txt-tags").style.border = "1px solid rgba(0, 0, 0, 0.5)";
        (document.getElementById("error-tags") === null)
            ? null
            : document.getElementById("error-tags").remove();
    }
}
// ---------------------------------------VALIDACIONES------------------------------------------------------------------------------------------------

// imprime el titulo del articulo a medida se empieza a escribir
document.getElementById("txt-titulo-articulo").addEventListener("keyup", e => {
    document.getElementById("article-title").innerHTML = (document.getElementById("article-title").innerText.split(":")[0] == "Editar artículo")
        ? `Editar artículo: ${document.getElementById("txt-titulo-articulo").value}`
        : `Nuevo artículo: ${document.getElementById("txt-titulo-articulo").value}`;
    (document.getElementById("error-titulo") === null)
        ? null
        : document.getElementById("error-titulo").remove();
});

// obtener las categorias del div de tags
const getCategorias = () => {
    const idCategorias = [];
    const categorias = document.getElementById("tag-categorias").getElementsByTagName("*");
    console.log(categorias);
    if (categorias.length) {
        for (let i = 0; i < categorias.length; i++) {
            idCategorias.push(categorias[i].dataset.nombrecategoria);
        }
    } else {
        idCategorias.push(false);
    }

    return (idCategorias);
};

// añadiendo las categorías a la barra de categorías.
const addCategoryTag = (categoryName) => {
    if (categoryName !== "default") {
        const pElement = document.createElement("p");
        let text = document.createTextNode(`#${categoryName}`);
        pElement.appendChild(text);
        pElement.dataset.nombrecategoria = categoryName;
        pElement.id = "tag";
        document.getElementById("tag-categorias").appendChild(pElement);
        document.getElementById("cbo-categorias").remove(document.getElementById("cbo-categorias").selectedIndex);
        console.log(document.getElementById("cbo-categorias").length);
    }
}

// evento para cuando se seleccione una opcion del combobox
(document.getElementById("cbo-categorias")) && document.getElementById("cbo-categorias").addEventListener("change", e => {
    console.log(document.getElementById("cbo-categorias").value);
    addCategoryTag(document.getElementById("cbo-categorias").value);
    getDeletedCategories(document.getElementById("cbo-categorias").value);
    error = false;
    document.getElementById("cbo-categorias").style.border = "1px solid rgba(0, 0, 0, 0.5)";
    (document.getElementById("error-categorias") === null)
        ? null
        : document.getElementById("error-categorias").remove();
});

// removiendo un elemento de la barra de categorias
const removeCategoryTag = (categoryName) => {
    const cboCategorias = document.getElementById("cbo-categorias");
    const option = document.createElement("option");
    const tagCategorias = document.getElementById("tag-categorias");

    option.value = categoryName;
    option.text = categoryName;

    cboCategorias.add(option);
};

document.getElementById("tag-categorias").dataset.categoriaseliminadas = "";

document.addEventListener("click", e => {
    if (e.target && e.target.id == "tag") {
        document
            .getElementById("tag-categorias")
            .dataset
            .categoriaseliminadas = document
                .getElementById("tag-categorias")
                .dataset.categoriaseliminadas + e.target.dataset.nombrecategoria + " ";
        removeCategoryTag(e.target.dataset.nombrecategoria);
        document.getElementById("tag-categorias").removeChild(e.target);
    }
    // console.log(e);
});

const getDeletedCategories = (categoria = "") => {
    return (document.getElementById("tag-categorias").dataset.categoriaseliminadas.trim().split(" "))
}

const cleanForm = () => {
    document.getElementById("txt-titulo-articulo").value = "";
    document.getElementById("txt-tags").value = "";
    document.getElementById("cbx-publicar").checked = false;
};

const irMenu = (preguntar = true) => {
    if (preguntar) {
        cleanForm();
        // document.getElementById("menu").click();
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
    } else location.replace("./?mod=adminarticulos");
}

// enviando datos al endpoint del webservice
const submitData = () => {
    validarFormulario();
    if (!error) {
        console.log("Información del editor: ", editor.getData());
        console.log(getCategorias());
        console.log(document.getElementById("cbx-publicar").checked);
        console.log("Data a enviarse: ", {
            operacion: "crear",
            titulo: document.getElementById("txt-titulo-articulo").value,
            contenido: editor.getData(),
            estado: (document.getElementById("cbx-publicar").checked) ? 1 : 0,
            idusuario: document.getElementById("txt-idusuario").innerText,
            tags: document.getElementById("txt-tags").value,
            categorias: getCategorias(),
        });
        swal.fire({
            title: "Confirmación",
            text: `Se creará el articulo: ${document.getElementById("txt-titulo-articulo").value}, ¿estás seguro?`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, crealo",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                swal.fire({
                    text: "Enviando datos",
                    allowOutsideClick: false,
                });
                swal.showLoading();
                $.ajax({
                    url: `./webservices/?accion=adminarticulo`,
                    method: 'POST',
                    data: {
                        operacion: "crear",
                        titulo: document.getElementById("txt-titulo-articulo").value,
                        contenido: editor.getData(),
                        estado: (document.getElementById("cbx-publicar").checked) ? 1 : 0,
                        idusuario: document.getElementById("txt-idusuario").innerText,
                        tags: document.getElementById("txt-tags").value,
                        categorias: getCategorias(),
                    }
                }).done((response) => {
                    if (response.type == "success") {
                        console.log("respuesta: ", response);
                        swal.fire(response).then(() => {
                            irMenu();
                        });
                    } else {
                        swal.fire(response);
                        console.log("respuesta error", response);
                    }
                });
            }
        }).catch(respuesta => {
            console.log("respuesta de error", respuesta);
            swal.fire(respuesta);
        });
    }
}

// edicion del articulo
const editArticulo = () => {
    validarFormulario(false);
    if (!error) {
        console.log("Información del editor: ", editor.getData());
        console.log(getCategorias());
        console.log(document.getElementById("cbx-publicar").checked);
        console.log("Data a enviarse: ", {
            operacion: "editar",
            titulo: document.getElementById("txt-titulo-articulo").value,
            contenido: (editor.getData().trim() === "")
                ? document.getElementById("contenido-articulo").innerHTML
                : editor.getData(),
            estado: (document.getElementById("cbx-publicar").checked) ? 1 : 0,
            idusuario: document.getElementById("txt-idusuario").innerText,
            tags: document.getElementById("txt-tags").value,
            idarticulo: parseInt(document.getElementById("article-title").dataset.idarticulo)
        });
        swal.fire({
            title: "Confirmación",
            text: `Se editará el articulo: ${document.getElementById("txt-titulo-articulo").value}, ¿ok?`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#a0a0a0",
            confirmButtonText: "Sí, editar",
            cancelButtonText: "Cancelar",
        }).then(result => {
            if (result.isConfirmed) {
                swal.fire({
                    text: "Enviando datos",
                    allowOutsideClick: false,
                });
                swal.showLoading();
                $.ajax({
                    url: `./webservices/?accion=adminarticulo`,
                    method: 'POST',
                    data: {
                        operacion: "editar",
                        titulo: document.getElementById("txt-titulo-articulo").value,
                        contenido: (editor.getData().trim() === "")
                            ? document.getElementById("contenido-articulo").innerHTML
                            : document.getElementById("cbx-cargar-contenido").checked
                                ? editor.getData()
                                : document.getElementById("contenido-articulo").innerHTML,
                        estado: (document.getElementById("cbx-publicar").checked) ? 1 : 0,
                        idusuario: document.getElementById("txt-idusuario").innerText,
                        tags: document.getElementById("txt-tags").value,
                        idarticulo: parseInt(document.getElementById("article-title").dataset.idarticulo),
                    }
                }).done((response) => {
                    if (response.type == "success") {
                        console.log("respuesta: ", response);
                        swal.fire(response).then(() => {
                            irMenu(false);
                        });
                    } else {
                        swal.fire(response);
                        console.log("respuesta error", response);
                    }
                });
            }
        }).catch(respuesta => {
            console.log("respuesta de error", respuesta);
            swal.fire(respuesta);
        });
    }
};

