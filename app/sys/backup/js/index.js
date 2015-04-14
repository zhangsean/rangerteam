$(function()
{
    $('.backup').click(function()
    {
        $('#waitting .modal-body #backupType').html(v.backup);
        $('#waitting').modal('show');
    })
    $('.restore').click(function()
    {
        $('#waitting .modal-body #backupType').html(v.restore);
        $('#waitting').modal('show');
    })
})
