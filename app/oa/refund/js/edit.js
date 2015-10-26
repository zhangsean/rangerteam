$(document).ready(function()
{
    /* Add a trade detail item. */
    $(document).on('click', '.icon-plus', function()
    {
        $(this).closest('.row').after($('#detailTpl').html());
        $(this).closest('.row').next().find("[name^='categoryList']").chosen();
        var options = window.datetimepickerDefaultOptions;
        $.extend(options, {startView: 2, minView: 2, maxView: 1, format: 'yyyy-mm-dd'})
        $(this).closest('.row').next().find("[name^='dateList']").fixedDate().datetimepicker(options);
    });

    /* Remove a trade detail item. */
    $(document).on('click', '.icon-minus', function()
    {
        if($('#detailBox .row').size() > 1)
        {
            $(this).closest('.row').remove();
        }
        else
        {
            $(this).closest('.row').find('input,select').val('');
        }
    });
});
