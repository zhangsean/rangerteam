$(document).ready(function()
{
    $('.btn-vcard').click(function(e){$(this).closest('.card-user').addClass('show'); e.stopPropagation()});
    $(document).click(function(){$('.card-user.show').removeClass('show')});
});
