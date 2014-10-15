$(document).ready(function() 
{
    setRequiredFields();

    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');
    $.setReloadDeleter('.reloadDeleter');
    $.setReload('.reload');

    /* Ping for keep login every six minute. */
    if(needPing) setInterval('ping()', 1000 * 360);

    $("#topNav li").hover(function () 
    {
        $(this).toggleClass('hover');
    });

    // active lightbox
    $("[data-toggle=lightbox]").lightbox();
});
