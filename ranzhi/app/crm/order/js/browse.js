$(function()
{
    $('.leftmenu li').removeClass('active').find('[href*=' + v.mode + ']').parent().addClass('active');
    $('.leftmenu li').find('[href*=' + v.mode + ']').parent().addClass('active');
});
