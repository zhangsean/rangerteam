$(function()
{
   if(v.mode)  $('.taskMenu').find('[href*=' + v.mode + ']').parent().addClass('active');
   if(!v.mode) $('.taskMenu').find('ul li:nth-child(2) a').parent().addClass('active');

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
})
