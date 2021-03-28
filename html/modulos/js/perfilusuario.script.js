// obteniendo los elementos del formulario
const $profilePicSelector = document.getElementById("edicion");
const frmFullName = document.getElementById("txt-nombre");
const frmEmail = document.getElementById("txt-email");
const frmBirthDate = document.getElementById("txt-fecha-nac");
const frmPhoneNumber = document.getElementById("txt-celular");
const frmPassword = document.getElementById("txt-password");
const frmConfirmPassword = document.getElementById("txt-confirm-password");
const btnSaveData = document.getElementById("saveData");
const file = document.getElementById("input");

// obteniendo los valores del formulario
const idusuario = document.querySelector("h3").innerHTML;

let error = false;

// ver si las contraseñas coinciden
const doesPasswordMatch = (password, confirmPassword) => {
    return (password === confirmPassword);
}


// tomar datos
frmFullName.addEventListener("blur", (event) => {
    if (fullName == "") {
        error = true;
        event.target.style.border = "1px solid #c23616";
    } else {
        fullName = document.getElementById("txt-nombre").value;
        console.log();
        error = false;
    }
});

frmEmail.addEventListener("blur", (event) => {
    if (email == "") {
        error = true;
        event.target.style.border = "1px solid #c23616";
    } else {
        error = false;
    }
});

frmBirthDate.addEventListener("blur", (event) => {
    if (birthDate == "") {
        error = true;
        event.target.style.border = "1px solid #c23616";
    } else {
        error = false;
    }
});

frmPhoneNumber.addEventListener("blur", (event) => {
    if (phoneNumber == "") {
        event.target.style.border = "1px solid #c23616";
        error = true;
    } else if (phoneNumber.match(/[^\d]/g)) {
        event.target.style.border = "1px solid #c23616";
        error = true;
    } else {
        error = false;
    }
});

document.getElementById("edicion").addEventListener("click", (event) => {
    file.click();
    // console.log(info);
});

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

file.addEventListener("change", () => {
    // console.log(file.files[0]);
    // let c = document.createElement("canvas");
    // c.height = 250;
    // c.width = 250;
    // let ctx = c.getContext("2d");

    // ctx.drawImage(file, 0, 0, c.height, c.width);
    // let base64String = c.toDataURL();
    // console.log(base64String);
    getBase64(file.files[0]).then(
        data => {
            document.getElementById("img-perfil").setAttribute("src", data);
        }
    );
}, false);

// const info = {
//     fullName,
//     email,
//     birthDate,
//     phoneNumber,
//     password,
//     confirmPassword,
//     idusuario
// };

// enviar informacion en un post al webservice
function updateUserProfile() {
    if (doesPasswordMatch(
        document.getElementById("txt-password").value,
        document.getElementById("txt-confirm-password").value
    )) {
        if (!error) {
            let infoImage = "";
            getBase64(file.files[0]).then(data => {
                infoImage = data;
            })
            console.log(infoImage);
            swal.fire({
                title: "Confirmación",
                text: "Tus datos de usuario serán actualizados, ¿estás seguro?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#27ae60",
                cancelButtonColor: "#a0a0a0",
                confirmButtonText: "Sí, actualizalos",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire({
                        text: "Enviando datos",
                        allowOutsideClick: false,
                    });
                    swal.showLoading();
                    console.log(`infoImage: ${infoImage}`);
                    $.ajax({
                        url: `./webservices/?accion=perfilusuario`,
                        method: 'POST',
                        data: {
                            operacion: "editarPerfilUsuario",
                            idusuario: idusuario,
                            nombre: document.getElementById("txt-nombre").value,
                            email: document.getElementById("txt-email").value,
                            fechanacimiento: document.getElementById("txt-fecha-nac").value,
                            password: document.getElementById("txt-password").value,
                            celular: document.getElementById("txt-celular").value,
                            image: infoImage,
                        }
                    })
                        .done((respuesta) => {
                            if (respuesta.type == 'success') {
                                console.log(`respuesta: ${respuesta}`);
                            }
                            swal.fire(respuesta);
                        });

                }
            }).catch(respuesta => {
                console.log(respuesta);
            });
        }
    } else {
        document.getElementById("txt-password").style.border = "1px solid #c23616";
    }
}