function procesarPassword() {
    var pass = $("#txt-contra").val();
    var user = $("#txt-usuario").val();
    $("#login-usuario").val(user);
    console.log(user);
    $("#txt-contra").val("");
    pass = sha512(pass);
    console.log(pass);
    $("#txt-contra-encrypt").val(pass.toUpperCase());
    $("#frmUserLogin").attr("action", "./").submit();
}