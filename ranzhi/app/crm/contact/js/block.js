$(document).ready(function()
{
    $('.btn-vcard').hover(function()
    {
        $(this).parents('td').find('.contact-info, p.vcard').toggle();
        $(this).toggleClass('icon-qrcode');
        $(this).toggleClass('icon-list');
    });
    $('.btn-vcard').blur(function()
    {
        $(this).parents('td').find('.contact-info, p.vcard').toggle();
        $(this).toggleClass('icon-qrcode');
        $(this).toggleClass('icon-list');
    });

    $('p.vcard').hide();
    return false;
});
