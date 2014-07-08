$(function()
{
    /* set style of avatar uploader in form */
    $('form #files').change(function(){$('form .avatar span').text($(this).val());});
    $('form .avatar span').click(function(){$('form #files').click();});

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
