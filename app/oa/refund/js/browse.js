$(document).ready(function()
{
     $.setAjaxJSONER('.refund', function(response)
     {
        bootbox.dialog(
        {  
            message: v.createTradeTip,  
            buttons:
            {  
                back:
                {  
                    label: v.lang.no,
                    className: 'btn-primary',  
                    callback:  function(){location.reload();}  
                },
                trade:
                {  
                    label: v.lang.yes,
                    className: 'btn-primary',  
                    callback:  function()
                    {
                         $.setAjaxLoader('.createTrade', '.modal');
                         $('.createTrade').click();
                         return false;
                    }

                }  
            }  
        });
    })
})
