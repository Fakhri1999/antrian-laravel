$(function(){
    $('.marquee-horz').marquee({
        speed: 100,
        gap: 50,
        delayBeforeStart: 0,
        direction: 'left',
        duplicated: true,
        pauseOnHover: true
    });
    $('.marquee-vert').marquee({
        direction: 'up',
        speed: 25,
        duplicated: true,
        delayBeforeStart: 0,
    });
});