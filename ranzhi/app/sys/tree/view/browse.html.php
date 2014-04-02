<?php
/**
 * The browse view file of tree module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
if(RUN_MODE == 'front')
{
    include $app->getModuleRoot() . 'common/view/header.html.php';
}
else
{
    include '../../common/view/header.admin.html.php';
}
include '../../common/view/kindeditor.html.php';
include '../../common/view/chosen.html.php';
js::set('root', $root);
js::set('type', $type);
?>
<div class='col-md-12'>
<?php if(strpos($treeMenu, '<li>') !== false):?>
<div class='row'>
  <div class='col-md-4'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-sitemap"></i> <?php echo $lang->category->common;?></strong></div>
      <div class='panel-body'><div id='treeMenuBox'><?php echo $treeMenu;?></div></div>
    </div>
  </div>
  <div class='col-md-8' id='categoryBox'></div>
</div>
<?php else:?>
<div id='categoryBox'></div>
<?php endif;?>
</div>
<?php
include '../../common/view/treeview.html.php';
if(RUN_MODE == 'front')
{
    include $app->getModuleRoot() . 'common/view/footer.html.php';
}
else
{
    include '../../common/view/footer.admin.html.php';
}

?>
