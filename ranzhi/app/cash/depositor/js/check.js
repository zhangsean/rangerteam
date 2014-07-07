$(document).ready(function()
{
    if(!v.dateOptions)
    {
        bootbox.alert(v.createBalance, function(){ location.href = createLink('balance', 'create')});
    }
});
