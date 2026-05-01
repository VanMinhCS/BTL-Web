$(document).ready(function(){
    $('.main-slider').slick({
        dots: true,          
        infinite: true,      
        speed: 500,          
        fade: true,
        cssEase: 'linear',
        autoplay: true,      
        autoplaySpeed: 4000
    });

    if ($('.featured-products').length > 0) {
        $('.featured-products').slick({
            slidesToShow: 3,        
            slidesToScroll: 1,      
            dots: true,             
            infinite: true,         
            arrows: true,           
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [
                {
                    breakpoint: 992,
                    settings: { slidesToShow: 2 }
                },
                {
                    breakpoint: 576,
                    settings: { slidesToShow: 1, arrows: false }
                }
            ]
        });
    }
});