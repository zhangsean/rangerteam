<?php
/**
 * The common header view file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
include $this->app->getBasePath() . 'app/sys/common/view/header.html.php';
