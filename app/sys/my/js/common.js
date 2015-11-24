$(document).ready(function()
{
    $('#menu .nav > li').removeClass('active').find('a[href*=' + v.type + ']').parent('li').addClass('active');
})
