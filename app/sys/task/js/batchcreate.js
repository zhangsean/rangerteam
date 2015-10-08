$(document).ready(function()
{
    /* Get team. */
    $('[name^=teamShow]').on('change', function()
    {
      var $select = $(this);
      var $options = $select.children('option');
      setTimeout(function()
      {
          var selections = $select.next('.chosen-container').find('.search-choice-close').map(function()
          {
            return $options.eq($(this).data('optionArrayIndex')).val();
          }).get().join(',');
          $('#team\\[' + $select.data('index') + '\\]').val(selections);
          console.log('#team\\[' + $select.data('index') + '\\]');
      }, 100);
    });

    /* show team menu. */
    $('[name^=multiple]').change(function()
    {
        var checkboxObj = $(this);
        console.log(checkboxObj.prop('checked'));
        var checked = checkboxObj.prop('checked');
        if(checked)
        {
            checkboxObj.parents('td').next('td').find('select').addClass('hidden');
            checkboxObj.parents('td').next('td').find('a').removeClass('hidden');
        }
        else
        {
            checkboxObj.parents('td').next('td').find('select').removeClass('hidden');
            checkboxObj.parents('td').next('td').find('a').addClass('hidden');
        }
    });
});
