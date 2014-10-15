$(document).ready(function()
{
    if(typeof(v.projectID) != undefined && v.projectID != 0)
    {
        $('.menu .nav li').removeClass('active');
        $('.leftmenu li').removeClass('active').find('[href*=' + v.status + ']').parent().addClass('active');
        $('.leftmenu li').find('[href*=' + v.status + ']').parent().addClass('active');

    }

    $("#createButton").modalTrigger({width:800});
    $.setAjaxJSONER('.switcher', function(){location.reload()});

    var $leftmenu = $('.menu.leftmenu');
    $leftmenu .next('a').css('margin-top', '10px').appendTo($leftmenu);
})
