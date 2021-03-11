$(()=>{
    $('#menuDesplegable').sidenav();
});

var altura = 0, animando=false;
var siguiente = 0;
$(document).ready(function(){
    var controles = $("<div>");
    
    controles.addClass("controles");
    
    $("<div>").addClass("btnControl btnPrev").appendTo(controles);
    $("<div>").addClass("btnControl btnNext").appendTo(controles);
    
    var slides = $(".sliderPW").children();
    var cantidad = slides.length;
   
    controles.appendTo(".sliderPW");
   
    altura = $(slides[0]).height();
    $(".sliderPW").css({"height":altura+"px"});

    var actual = 0;
    siguiente = actual+1;
    var anterior = cantidad-1;
    

    $(slides[actual]).css({"z-index":2});
    $(slides[siguiente]).css({"z-index":3, "top":-altura+"px"});
    $(slides[anterior]).css({"z-index":1});

    $(".sliderPW .controles .btnNext").on("click",function(){
        if(!animando){
            animando=true;

            $(slides[siguiente]).animate({"top":"0px"},function(){
                $(slides[actual]).css({"z-index":1});
                $(slides[anterior]).css({"z-index":0});
                $(slides[siguiente]).css({"z-index":2});
                anterior=actual;
                actual++;
    
                if(actual==(cantidad-1)){
                    siguiente = 0;
                }        
                else{
                    actual = actual>=cantidad ? 0 : actual;
                    siguiente=actual+1;
                }
                $(slides[siguiente]).css({"z-index":3, "top":-altura+"px"});
                animando = false;
            });
        }
    });

    $(".sliderPW .controles .btnPrev").on("click",function(){
        if(!animando){
            animando=true;

            $(slides[actual]).animate({"top":-altura+"px"},function(){
                $(slides[actual]).css({"z-index":3});
                $(slides[anterior]).css({"z-index":2});
                $(slides[siguiente]).css({"z-index":0, "top":"0px"});
                siguiente=actual;
                actual--;
                if(actual<0){
                    actual=cantidad-1;
                }        
               
                anterior= actual == 0 ? cantidad-1 : actual-1;
                $(slides[anterior]).css({"z-index":1});
                console.log(actual)
                console.log(siguiente)
                console.log(anterior)
                animando = false;
            });
        }
    });
    
    
    $(window).resize(function(){
        altura = $(slides[0]).height();
        $(".sliderPW").css({"height":altura+"px"});
        $(slides[siguiente]).css({"top":-altura+"px"});
    });
    
});