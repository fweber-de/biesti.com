/*
 * biesti.com JS
 * © 2014, FLorian Weber
 */

$(document).ready(function() {

    var currentPage = $('#current-page').html();

    //active links
    $('#nl-' + currentPage).addClass('active');
    $('#nbl-' + currentPage).addClass('active');

});
