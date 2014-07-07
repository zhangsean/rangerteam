$(function()
{
    $('form #desc').focus(function(){$(this).height($(this).closest('.row').height()-57);}).blur(function(){$(this).removeAttr('style')});
    $('.leftmenu li').removeClass('active').find('[href*=' + v.mode + ']').parent().addClass('active');
    $('.leftmenu li').find('[href*=' + v.mode + ']').parent().addClass('active');
});
