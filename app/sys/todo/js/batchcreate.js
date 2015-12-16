$(document).ready(function()
{
    $('input[name=switchAll]').click(function()
    {
        if($(this).prop('checked'))
        {
            $('[name*=switchDate]').each(function()
            {
                var key = $(this).attr('data-key');
                $('#switchDate' + key).prop('checked', 'checked');
                switchDateList(key);
            })
        }
        else
        {
            $('[name*=switchDate]').each(function()
            {
                var key = $(this).attr('data-key');
                $('#switchDate' + key).prop('checked', false);
                switchDateList(key);
            })
        }
    })
})

function updateAction(date)
{
  if(date.indexOf('-') != -1)
  {
    var datearray = date.split("-");
    var date = '';
    for(i=0 ; i<datearray.length ; i++)
    {
      date = date + datearray[i];
    }
  }
  link = createLink('todo', 'batchCreate', 'date=' + date);
  location.href=link;
}

function switchDateList(number)
{
    if($('#switchDate' + number).prop('checked'))
    {
        $('[name=begins\\[' + number + '\\]]').attr('disabled', 'disabled');
        $('[name=ends\\[' + number + '\\]]').attr('disabled', 'disabled');
    }
    else
    {
        $('[name=begins\\[' + number + '\\]]').removeAttr('disabled');
        $('[name=ends\\[' + number + '\\]]').removeAttr('disabled');
    }
}
