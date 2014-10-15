$(function()
{
   if(v.mode)  $('.taskMenu').find('[href*=' + v.mode + ']').parent().addClass('active');
   if(!v.mode) $('.taskMenu').find('ul li:nth-child(2) a').parent().addClass('active');
})
