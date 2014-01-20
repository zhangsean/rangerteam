function createKey()
{
    var chars = '0123456789abcdefghiklmnopqrstuvwxyz'.split('');
    var key   = ''; 
    for(var i=0; i < 32; i++)
    {   
        key += chars[Math.floor(Math.random() * chars.length)];
    }   
    $('#key').val(key);
    return false;
}

function toggleSize(value)
{
  $('#custom').hide();
  if(value == 'custom')$('#custom').show();
}

$('#size').change(function(){toggleSize($(this).val())});
$(function(){toggleSize($('#size').val());})
