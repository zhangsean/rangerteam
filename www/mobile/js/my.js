$(function()
{
    $(document).on('click', '.lang-menu > a', function()
    {
        selectLang($(this).data('value'));
    });
});
