<?php
/**
 * The datepicker view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
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
