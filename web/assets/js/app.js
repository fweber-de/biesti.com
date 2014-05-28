/*
 * biesti.com JS
 * © 2014, FLorian Weber
 */

$(document).ready(function() {

    var currentPage = $('#current-page').html();

    //active links
    $('#nl-' + currentPage).addClass('active');
    $('#nbl-' + currentPage).addClass('active');
    
    var picn = 2;
    
    setInterval(function() {
        $('.img-profile').attr('src', $('#src-pi-' + picn).html());
        picn++;
        
        if(picn > $('#profile-img-src-box').children().length) picn = 1;
    }, 5000);

});
