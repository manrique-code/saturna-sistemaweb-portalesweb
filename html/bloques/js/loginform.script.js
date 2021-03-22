function procesarPassword() {
    var pass = $("#txt-contra").val();
    $("#txt-contra").val("");
    pass = sha512(pass);
    console.log(pass);
    $("#txt-contra-encrypt").val(pass.toUpperCase());
    $("#frmUserLogin").attr("action", "./").submit();
}