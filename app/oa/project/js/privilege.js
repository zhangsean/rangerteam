function whitelistBox()
{
    var acl = $('input[name=acl]:checked').val();
    $('#whitelistBox').addClass('hidden');
    if(acl == 'custom') $('#whitelistBox').removeClass('hidden');
}

function updateChecked(clickObj)
{
   /* check viewList if editList checked. */
   $('#editListBox input[type=checkbox]:checked').each(function()
   {
       var checkbox = $(this);
       $('#viewuser' + checkbox.val()).find('input').prop('checked', 'checked');
   });
}
