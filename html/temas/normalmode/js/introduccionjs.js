//Modificar el contenido de un elemento
$("#t3").html("<a href='https://google.com'>Contenido Modificado</a>");

//cambiar un atributo
$("#t1").attr("class", "nuevoTitulo titulo");

//obtener el valor de un atributo
var clases = $("#t1").attr("class");
//alert(clases);

//modificar el css
$("#t2").css({"color":"red", "font-size":"24px"});

//agregar eventos
$("#t1").on("click",function(){
    alert($("#t1").html());
});

//agregar efectos
$("#t2").hover(function(){
    $("#t2").slideUp('slow');
});