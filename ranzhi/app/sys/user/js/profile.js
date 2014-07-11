$(document).ready(function()
{
    $('.btn-avatar').click(function(){$('#files').click();});
    $('#files').change(function(){$('#avatarForm').submit();});

    $.setAjaxForm('#avatarForm', function(response)
    {
        if(response.result == 'success')
        {
            $('.btn-avatar').popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
            $('.btn-avatar').next('.popover').addClass('popover-success');
            function distroy(){$('btn-avatar').popover('destroy'); $('#ajaxModal').load(response.locate);}
            setTimeout(distroy,800);
        }
    });
});
