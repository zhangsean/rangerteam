$(document).ready(function()
{
    $('.file-form .form-group div[class*=col-sm]').removeAttr('style');
    $("a[href*='forum']").parent().addClass('active');
    $("a[href$='forum']").parent().removeClass('active');
});
