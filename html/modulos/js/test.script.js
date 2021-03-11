function generarChiste(){
    $.ajax({
        url: "https://api.chucknorris.io/jokes/random"        
    })
    .done((respuesta)=>{
        $("#chiste").hide();
        $("#chiste").html("Chiste ID " + respuesta.id + ": " + respuesta.value);
        $("#chiste").fadeIn();
    });
}