$(document).ready(function()
{
    $("a[href*='board'][href$='" + v.boardID + "']").parent().addClass('active');
    $('.nav-system-forum').addClass('active');
})
