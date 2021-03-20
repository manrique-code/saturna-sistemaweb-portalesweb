<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
    maximum-scale=1.0">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/styles.css">
    <title>Saturna</title>
</head>
<body>    
    <div class="contenedor">

        <!-- barra de navegacion -->
        <header class="header">
            <div class="logo">
                <div class="imagen-logo"></div>
            </div>
            <nav class="">
                <a href="#" class="seleccionado">Inicio</a>
                <a href="#">Tecnología</a>
                <a href="#">Cine</a>
                <a href="#">Cursos</a>
                <a href="#">About us</a>
                <a href="#">Log-in</a>
            </nav>
            <div class="icons-nav">
                <a href="#" id="user"><i class="far fa-user-circle user-header"></i></a>
                <i class="fas fa-bars menu-header" id="menu"></i>
            </div>
        </header>

        <div id="logins" class="active">
            <form action="" class="login-container">
                <div class="login-input">
                    <label for="txt-usuario">Usuario</label>
                    <input type="text" name="" id="txt-usuario">
                </div>
                <div class="login-input">
                    <label for="txt-contra">Contraseña</label>
                    <input type="password" name="" id="txt-contra">
                </div>
                <button id="btn-login">Login</button>
                <button id="btn-cancelar">Cancelar</button>
            </form>
        </div>

        <!-- lo mas visto -->

        <section class="mas-visto">
            <h1>Lo más visto</h1>
            <a href="#">
                <div class="mv-card">
                    <img src="<?php echo $urlTema?>/img/noticias/macbook.jpg" alt="MacBook Air" class="img-mv-card">
                    <div class="mv-content">
                        <a href=""><p class="category">Tecnología</p></a>
                        <h2>La nueva MacBook Air con M1</h2>
                        <p>Analizo a profunidad la nueva propuesto de portátiles de Apple, con procesadores M1 diseñados por ellos mismos.</p>
                    </div>
                </div>
            </a>
        </section>

        <section class="ultimas-entradas">
            <h2>Últimas entradas en el blog</h2>
            <div class="ue-items">
                <a href="#">
                    <div class="ue-cards">
                        <img src="<?php echo $urlTema?>/img/noticias/lobster.jpg" alt="The Lobster" class="ue-img-cards">
                        <div class="ue-card-content">
                            <a href="#">
                                <p class="cine">Cine</p>
                            </a>
                            <h2>The Lobster, el clásico</h2>
                            <p class="ue-preview">Después de 7 años de su lanzamiento seguimos analizando esta obra del séptimo arte que siempre nos soprende</p>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="ue-cards">
                        <img src="<?php echo $urlTema?>/img/noticias/graphql.png" alt="" class="ue-img-cards">
                        <div class="ue-card-content">
                            <a href="#">
                                <p class="tec">Tecnología</p>
                            </a>
                            <h2>GraphQL, posible reemplazo de las API</h2>
                            <p class="ue-preview">GraphQL, el nuevo lenguaje de quieries diseñado por los ingenieros de Facebook el cual difieren en gran medida de las APIRest.</p>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="ue-cards">
                        <img src="<?php echo $urlTema?>/img/noticias/s21ultra.jpg" alt="Galaxy S21 Ultra" class="ue-img-cards">
                        <div class="ue-card-content">
                            <a href="#">
                                <p class="tec">Tecnología</p>
                            </a>
                            <h2>Galaxy S21 Ultra, tras 2 semanas de uso XD</h2>
                            <p class="ue-preview">Les cuento que es lo que me ha parecido el Galaxy S21 tras apenas dos semanas de uso, es que la marca promotora ya me lo va a quitar y entonces mejor ya les digo que tal la experiencia.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <aside class="recomendaciones">
            <h2>Recomendaciones</h2>
            <div class="r-item">
                <div class="calif-tec">
                    <p>11/10</p>
                </div>
                <img src="<?php echo $urlTema?>/img/recomendaciones/pubg.jpg" alt="PUBG">
            </div>
            <div class="r-item">
                <div class="calif-cine">
                    <p>10/10</p>
                </div>
                <img src="<?php echo $urlTema?>/img/recomendaciones/enemy.jpg" alt="Enemy (2014)" title="Enemy (2014)">
            </div>
        </aside>

        <section class="cursos">
            <div class="header-cursos">
                <h2>Cursos</h2>
                <a href="#">Ver  más cursos</a>
            </div>
            <div class="cursos-items">
                <a href="#">
                    <div class="apps">
                        <p>Mobile App Development</p>
                    </div>
                    <img src="<?php echo $urlTema?>/img/cursos/aplicaciones.jpg" alt="">
                </a>
            </div>
            <div class="cursos-items">
                <a href="#">
                    <div class="apps">
                        <p>Web Development</p>
                    </div>
                    <img src="<?php echo $urlTema?>/img/cursos/web.jpg" alt="">
                </a>
            </div>
        </section>

        <section class="mas-articulos">
            <h2>Más artículos</h2>
            <a href="#">
                <div class="ma-cards">
                    <img src="<?php echo $urlTema?>/img/noticias/ubuntu.png" alt="Linx Ubuntu">
                    <div class="ma-card-content">
                        <a href="#">
                            <p class="tec">Tecnología</p>
                        </a>
                        <h2>Lorem Ipsum</h2>
                        <p class="ma-preview">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Commodi officia soluta quo asperiores distinctio molestiae, tempora esse ipsum debitis vel rerum quaerat delectus fugit? Doloribus eum ducimus repudiandae nihil reprehenderit!</p>
                    </div>
                </div>
            </a>
        </section>

        <footer>
            <div class="social-media">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="autor">Sergio Manrique Rios Reyes</p>
        </footer>

    </div>

    <script src="<?php echo $urlTema?>//js/scripts.js"></script>
</body>
</html>