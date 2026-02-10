import "./bootstrap";
import Swiper from "swiper/bundle";
import "swiper/css";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", () => {
    // Initialize Swiper only if the element exists
    const swiperEl = document.querySelector(".mySwiper");
    if (swiperEl) {

        new Swiper(".mySwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }
});
