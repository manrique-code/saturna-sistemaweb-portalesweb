$(document).ready(function () {
  $('.modal').modal();
});

function crearUsuario() {
  swal.fire({
    title: '¿Continuar?',
    text: "Estan seguro de que los datos son correctos",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Continuar',
    cancelButtonText: 'Cancelar',

  }).then((result) => {
    if (result.isConfirmed) {
      swal.fire({
        text: "Enviando Datos",
        allowOutsideClick: false
      });
      swal.showLoading();
      //Llamada Ajax
      $.ajax({
        url: `./webservices/?accion=${idmodulo}`,
        method: 'POST',
        data: {
          operacion: 'crearUsuario',
          idusuario: $("#txtidusuario").val(),
          nombre: $("#txtnombre").val(),
          email: $("#txtemail").val(),
          fechanacimiento: $("#txtfechanacimiento").val(),
          password: $("#txtpassword").val(),
          celular: $("#txtcelular").val(),
          essuperadmin: $("#chkEsAdmin").prop('checked') ? 1 : 0,
          estado: $("#chkEstado").prop('checked') ? 1 : 0
        }

      })
        .done((respuesta) => {
          if (respuesta.type == 'success') {
            console.log(respuesta);
            $("#frmUsuario input").val("");
            $('#mdl-usuario').modal('close');
          }
          swal.fire(respuesta);
        });


    }
  });
}
