$(function()
{
   if(v.mode)  $('#menu').find('[href*=' + v.mode + ']').parent().addClass('active');
   else $('#menu').find('li.all').addClass('active');
});
