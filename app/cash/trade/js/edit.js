$(document).ready(function()
{
    var contract = $('#contract').val();
    $('.contractTD select').empty().load(createLink('crm.contract', 'getOptionMenu', 'traderID=' + $('#trader').val()), function()
    {
        $('#contract').val(contract);
    });
})
