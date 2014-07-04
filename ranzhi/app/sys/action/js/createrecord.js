$(document).ready(function()
{
    $.setAjaxForm('#createRecordForm', function(){$.reloadAjaxModal();});
    $('[name*=objectType]').change(function()
    {
        $('#order, #contract').attr('disabled', true).parents('tr').hide();
        if($(this).prop('checked')) 
        {
            $('[name*=objectType]').not(this).attr('checked', false);
            $('#' + $(this).val()).attr('disabled', false).parents('tr').show();
        }
    });
    $('#ajaxModal .sorter').click();
  
    $('[name*=createContact]').change(function()
    {   
        if($(this).prop('checked')) 
        {   
            $(this).parents('.input-group').find('select').hide();
            $(this).parents('.input-group').find('input[type=text]').show().focus();
        }   
        else
        {   
            $(this).parents('.input-group').find('select').show();
            $(this).parents('.input-group').find('input[type=text]').hide();
        }   
    })  
});
