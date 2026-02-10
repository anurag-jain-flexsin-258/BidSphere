import "./bootstrap";
import Swiper from "swiper/bundle";
import "swiper/css";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", () => {
    // Initialize Swiper only if the element exists
    const swiperEl = document.querySelector(".mySwiper");
    if (swiperEl) {
        const nextBtn = document.querySelector(".swiper-button-next");
        const prevBtn = document.querySelector(".swiper-button-prev");

        new Swiper(".mySwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 60000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation:
                nextBtn && prevBtn
                    ? {
                          nextEl: ".swiper-button-next",
                          prevEl: ".swiper-button-prev",
                      }
                    : false, 
        });
    }
});
