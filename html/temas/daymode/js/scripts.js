const header = document.querySelector('.header');
const menu = document.getElementById("menu");
const user = document.querySelector(".user-header");
const logo = document.querySelector(".header .logo .imagen-logo");
const nav = document.querySelector(".header nav");
const whiteLogo = "../img/assets/logo white.png";

let menuAbierto = false;

console.log(logo);

// abrir el menu de opciones
document.getElementById("menu").addEventListener("click", (event) => {
    menuAbierto = !menuAbierto;
    // (menuAbierto ? nav.classList.add("active") : nav.classList.remove("active"));
    if (menuAbierto) {
        nav.classList.add("active");



        header.classList.remove("active");
        menu.classList.remove("active");
        user.classList.remove("active");
        logo.classList.remove("active");

    } else {
        nav.classList.remove("active");

        if (window.scrollY >= 50) {
            header.classList.add("active");
            menu.classList.add("active");
            user.classList.add("active");
            logo.classList.add("active");
        } else {
            header.classList.remove("active");
            menu.classList.remove("active");
            user.classList.remove("active");
            logo.classList.remove("active");
        }
    }
}, false);

// cambiar el color del header cuando hay scroll
window.onscroll = () => {
    if (window.scrollY >= 50) {
        header.classList.add("active");
        menu.classList.add("active");
        user.classList.add("active");
        logo.classList.add("active");
        nav.classList.add("scroll");
    } else {
        header.classList.remove("active");
        menu.classList.remove("active");
        user.classList.remove("active");
        logo.classList.remove("active");
        nav.classList.remove("scroll");
    }
};