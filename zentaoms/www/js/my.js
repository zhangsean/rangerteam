$(document).ready(function() 
{
    setRequiredFields();

    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');

    $.setReloadDeleter('.reloadDeleter');
    $.setReload('.reload');

    setInterval('ping()', 1000 * 360);
});
