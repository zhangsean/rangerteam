$(function()
{
   /* set style of avatar uploader in form */
   $('form #files').change(function(){$('form .avatar span').text($(this).val());});
   $('form .avatar span').click(function(){$('form #files').click();});
   $('form #desc').focus(function(){$(this).height($(this).closest('.row').height()-57);});
});
