$(function()
{
   if(v.mode)  $('#menu').find('[href*=' + v.mode + ']').parent().addClass('active');
   else $('#menu').find('li.all').addClass('active');

    window.reloadDataTable = function()
    {
        var $list = $('#taskList');
        $list.load(document.location.href + ' #taskList', function()
        {
            $list.dataTable();
            $list.find('[data-toggle="modal"]').modalTrigger();
            resetBoards();
        });
        return false;
    };
});
