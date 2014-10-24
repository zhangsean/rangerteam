$(document).ready(function()
{
    $.setAjaxForm('#balanceForm', function(response) { if(response.result == 'success') $.reloadAjaxModal(); });
    $('.leftmenu a[href*=balance]').parent().addClass('active');   

    $(document).on('change', '#depositor', function()
    {
        currency = $(this).find('option:selected').attr('data-currency')

        $('.currency').html(v.currencyList[currency]);
    })

    $('#depositor').change();
})
