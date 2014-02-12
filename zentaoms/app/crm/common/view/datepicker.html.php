<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
$clientLang = $this->app->getClientLang();
css::import($jsRoot . 'datetimepicker/css/min.css');
js::import($jsRoot  . 'datetimepicker/js/min.js'); 
if($clientLang != 'en') js::import($jsRoot . 'datetimepicker/js/locales/' . $clientLang . '.js'); 
?>
<script language='javascript'>
$(function()
{
    startDate = new Date(2000, 1, 1);
    $(".date-picker").datetimepicker
    ({
        format: 'yyyy-mm-dd',
        startDate:startDate,
        pickerPosition: 'left',
        todayBtn: true,
        autoclose: true,
        keyboardNavigation:false,
        language:'<?php echo $clientLang?>'
    })

    $(".time-picker").datetimepicker
    ({
        format: 'yyyy-mm-dd hh:ii',
        startDate:startDate,
        pickerPosition: 'left',
        todayBtn: true,
        autoclose: true,
        keyboardNavigation:false,
        language:'<?php echo $clientLang?>'
    })


});
</script>
