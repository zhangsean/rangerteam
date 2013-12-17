<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
$clientLang = $this->app->getClientLang();
css::import($jsRoot . 'bootstrap/datetimepicker/css/min.css');
js::import($jsRoot  . 'bootstrap/datetimepicker/js/min.js'); 
if($clientLang != 'en') js::import($jsRoot . 'bootstrap/datetimepicker/js/locales/' . $clientLang . '.js'); 
?>
<script language='javascript'>
$(function() {
    startDate = new Date(1970, 1, 1);
    $(".date").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        startDate:startDate,
        pickerPosition: "top-left",
        todayBtn: true,
        autoclose: true,
        keyboardNavigation:false,
        language:'<?php echo $clientLang?>'
    })
});
</script>
