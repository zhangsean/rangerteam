<?php
/**
 * The kityminder view of common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     common 
 * @version     $Id: minder.html.php 8679 2014-05-03 00:44:12Z sunhao $
 * @link        http://www.ranzhi.org
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
js::import($jsRoot  . 'kityminder/kityminder.all.min.js'); 
css::import($jsRoot . 'kityminder/themes/default/kityminder.min.css');
?>
<script>
$(function()
{
    window.minder = KM.getKityMinder('kityminder');
});
</script>
