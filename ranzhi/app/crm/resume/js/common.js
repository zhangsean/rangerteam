$(function()
{
    /* Set ajaxform for create and edit. */
    $.setAjaxForm('#resumeForm', function(data)
    {   
        if(data.result == 'success')
        {
            if(data.locate == 'reload') return location.href = location.href;
            $.reloadAjaxModal(1500);
        }
    });

    /* Reload modal. */
    $('.reloadModal').click(function(){$.reloadAjaxModal()});

    /* Load page in modal. */
    $.setAjaxLoader('.loadInModal', '#ajaxModal');
})
