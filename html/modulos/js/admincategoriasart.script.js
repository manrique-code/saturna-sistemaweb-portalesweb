const getItemCategoria = (idCategoria, nombreCategoria, itemAnterior) => {
    const h4Category = document.createElement("h4");
    h4Category.id = `categoria-${idCategoria}`;
    h4Category.innerText = `${itemAnterior}`;

    const inputCategory = document.createElement("input");
    inputCategory.type = "text";
    inputCategory.id = `nombreCategoriaInput${idCategoria}`;
    inputCategory.value = nombreCategoria;

    const aCancelButton = document.createElement("a");
    aCancelButton.innerText = "Cancelar";
    aCancelButton.href = "#";

    const aGuardarEdicion = document.createElement("a");
    aGuardarEdicion.innerText = "Guardar";
    aGuardarEdicion.href = `javascript:editarCategoria(${idCategoria})`;
    aGuardarEdicion.classList.add("btnGuardarEdicionCategoria");

    const aEliminarCategoria = document.createElement("a");
    aEliminarCategoria.innerHTML = `<i class="far fa-trash-alt"></i>`;
    aEliminarCategoria.href = `javascript:eliminarCategoria(${idCategoria})`;
    aEliminarCategoria.classList.add("btnEliminarCategoria");

    const divCategoryItem = document.createElement("div");
    divCategoryItem.classList.add("categoryItem");
    divCategoryItem.dataset.categoria = idCategoria;

    divCategoryItem.appendChild(h4Category);
    divCategoryItem.appendChild(inputCategory);
    divCategoryItem.appendChild(aCancelButton);
    divCategoryItem.appendChild(aGuardarEdicion);
    divCategoryItem.appendChild(aEliminarCategoria);

    return (divCategoryItem);
};
document.getElementById("crearCategoriaInput").addEventListener("keyup", (event) => {
    if (document.getElementById("crearCategoriaInput").value.trim() === "") {
        document.getElementById("btnCrearCategoria").style = "display: none";
    } else {
        document.getElementById("btnCrearCategoria").style = "display: flex";
        $.ajax({
            url: "./webservices/?accion=admincategoriasart",
            method: "POST",
            data: {
                operacion: "verificarcategoria",
                categoria: document.getElementById("crearCategoriaInput").value,
            }
        }).done(response => {
            if (response.type === "success") {
                document.getElementById("errorCrearCategoriaInput").innerText = response.text;
            } else {
                document.getElementById("errorCrearCategoriaInput").innerText = response.text;
                document.getElementById("btnCrearCategoria").style = "display: none";
            }
        });
    }
});

document.addEventListener("click", event => {
    if (event.target && [...event.target.id].splice(0, [...event.target.id].length - 1).join("") === "nombreCategoriaInput") {
        document.getElementById(event.target.id).addEventListener("keyup", e => {
            if (document.getElementById(event.target.id).value.trim() === "") {
                document.getElementById("btnGuardarEdicionCategoria").style = "display: none";
            } else {
                document.getElementById("btnGuardarEdicionCategoria").style = "display: flex";
                $.ajax({
                    url: "./webservices/?accion=admincategoriasart",
                    method: "POST",
                    data: {
                        operacion: "verificarcategoria",
                        categoria: document.getElementById(event.target.id).value,
                    }
                }).done(response => {
                    if (response.type === "success") {
                        document.getElementById(`mensajeCategoriaEdicion${[...event.target.id].splice(-1)}`).innerText = response.text;
                    } else {
                        document.getElementById(`mensajeCategoriaEdicion${[...event.target.id].splice(-1)}`).innerText = response.text;
                        document.getElementById("btnGuardarEdicionCategoria").style = "display: none";
                    }
                });
            }
        })
    }
})

const crearCategoria = () => {
    $.ajax({
        url: "./webservices/?accion=admincategoriasart",
        method: "POST",
        data: {
            operacion: "crear",
            categoria: document.getElementById("crearCategoriaInput").value,
        }
    }).done(response => {
        if (response.type === "success") {
            document.getElementById("categorias").appendChild(getItemCategoria(
                response.datareturn[1],
                document.getElementById("crearCategoriaInput").value,
                document.getElementById(`categoria-${response.datareturn[1] - 1}`).innerText
            ));
        }
    });
}

const editarCategoria = (idcategoria) => {
    $.ajax({
        url: "./webservices/?accion=admincategoriasart",
        method: "POST",
        data: {
            operacion: "editar",
            categoria: document.getElementById(`nombreCategoriaInput${idcategoria}`).value,
            idcategoria,
        }
    }).done(response => {
        if (response.type == "success") {
            document.getElementById(`mensajeCategoriaEdicion${idcategoria}`).innerText = "";
        }
    })
};

const eliminarCategoria = (idcategoria) => {
    swal.fire({
        title: "Advertencia",
        text: `Estás seguro que deseas eliminar la categoría de "${document.getElementById(`nombreCategoriaInput${idcategoria}`).value}".
         Es muy posible que esta acción deje sin categoría a varios artículos`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dd0000",
        cancelButtonColor: "#a0a0a0",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then(result => {
        if (result.isConfirmed) {
            $("#categoryItem" + idcategoria).fadeOut("slow");
            $.ajax({
                url: "./webservices/?accion=admincategoriasart",
                method: "POST",
                data: {
                    operacion: "eliminar",
                    idcategoria,
                }
            })
        }

    });
};