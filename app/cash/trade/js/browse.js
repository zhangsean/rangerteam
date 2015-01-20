$(document).ready(function()
{
    /* Add a trade detail item. */
    $(document).on('click', '.icon-plus', function()
    {
        $(this).parents('tr').after($('#hiddenDetail').html().replace(/key/g, v.key));
        $(this).parents('tr').next().find("[name*='handlers']").chosen({no_results_text: '', placeholder_text:' ', disable_search_threshold: 1, search_contains: true, width: '100%'});
        $(this).parents('tr').next().find("[name*='category']").chosen({no_results_text: '', placeholder_text:' ', disable_search_threshold: 1, search_contains: true, width: '100%'});
        v.key ++;
    })

    /* Remove a trade detail item. */
    $(document).on('click', '.icon-minus', function()
    {
        if($('#ajaxForm table tbody tr').size() > 1)
        {
            $(this).parents('tr').remove();
        }
        else
        {
            $(this).parents('tr').find('input,select').val('');
        }
    })

    $('#submit').click(function()
    {
        var tradeChecked = false;

        $('[name*=tradeIDList]').each(function()
        {
            if($(this).prop('checked')) tradeChecked = true;
        })

        return tradeChecked;
    })
});
