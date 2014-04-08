<?php
/**
 * The footer.lite view of common module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
?>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);

/* Load hook files for current page. */
$extPath      = dirname(dirname(dirname(__FILE__))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
