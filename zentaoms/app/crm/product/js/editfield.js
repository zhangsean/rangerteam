/* Check field length and alert notice when change control. */
$('#control').change(function()
{
    $.get(createLink('product', 'checkFieldLength', 'fieldID=' + v.fieldID + '&control=' + $(this).val()), function(data)
    {
        if(data) bootbox.alert(data);
    })
})
