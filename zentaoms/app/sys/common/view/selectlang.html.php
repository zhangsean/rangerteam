<?php
/**
 * The selectLang view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$clientLang = $this->app->getClientLang();
?>
<a href='###' class='dropdown-toggle' data-toggle='dropdown'><i class='icon-globe icon-large'></i> &nbsp;<?php echo $config->langs[$clientLang]?><span class='caret'></span></a>
<ul class='dropdown-menu'>
  <?php
  $langs = $config->langs;
  unset($langs[$clientLang]);
  foreach($langs as $langKey => $currentLang) echo "<li><a rel='nofollow' href='javascript:selectLang(\"$langKey\")'>$currentLang</a></li>";
  ?>
</ul>
