$(document).ready(function()
{
    $('.ajax-theme').click(function()
    {
        var current = $(this);
        $('.msg').fadeOut()
        $.getJSON($(this).attr('href'), function(data)
        {
            $('.current').removeClass('current');
            current.find('.msg').text(data.message).fadeIn(function()
            {
               current.addClass('current');
               setTimeout('$(".current .msg").fadeOut();', 4000);
            });
        });
        return false;
    });
})
