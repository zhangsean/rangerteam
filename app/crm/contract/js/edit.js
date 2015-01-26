$(document).ready(function()
{
    $('.orderTH').not(':first').empty();

    $(document).on('click', '.plus', function()
    {
        if($(this).parents('tr').find('option:selected').val() == '') return false;

        $('#tmpData').html($('#orderGroup tbody').html());

        $('select.select-order').not('#orderGroup select, #tmpData select').each(function()
        {
            selectedValue = $(this).find('option:selected').val();

            if(selectedValue)
            {
                $('#tmpData').find("option[value='" + selectedValue + "']").remove();
            }
            else
            {
                $('#tmpData').empty();
                return false;
            }
        });

        if($('#tmpData').html() == '') return false;

        $(this).parents('tr').after( $('#tmpData').html());
    });
  
    $(document).on('click', '.minus', function()
    {
        if($(this).parents('table').find('.order-real').not('tbody.hide .order-real').size() == 1)
        {
            $(this).parents('tr').html($('#orderGroup tr').html());
            $(this).parents('td').find('select').val('').change();
            return false;
        }
        $(this).parents('tr').remove();
        $('.order-real').change();
    });
})
