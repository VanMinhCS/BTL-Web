$(document).ready(function(){
    $('.main-slider').slick({
        dots: true,          // Hiện dấu chấm chuyển trang
        infinite: true,      // Chạy vô tận
        speed: 500,          // Tốc độ chuyển
        fade: true,          // Hiệu ứng mờ dần (sang trọng hơn cho Banner)
        cssEase: 'linear',
        autoplay: true,      // Tự động chạy
        autoplaySpeed: 4000
    });
});