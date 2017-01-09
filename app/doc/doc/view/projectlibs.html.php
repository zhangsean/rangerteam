<?php
/**
 * The project libs view file of doc module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php $this->doc->setMenu($project->id);?>
<div id='libs'>
  <div class='libs-group clearfix'>
    <?php foreach($libs as $libID => $libName):?>
    <?php
    if($libID == 'project' and $from != 'doc') continue;

    $libLink = inlink('browse', "libID=$libID&browseType=all&param=0&orderBy=id_desc&from=$from");
    if($libID == 'project') $libLink = inlink('allLibs', "type=project");
    if($libID == 'files')   $libLink = inlink('showFiles', "projectID=$project->id");
    ?>
    <a class='lib' title='<?php echo $libName?>' href='<?php echo $libLink?>'>
      <i class='icon icon-2x icon-folder-open-alt'></i>
      <div class='lib-name' title='<?php echo $libName?>'><?php echo $libName?></div>
    </a>
    <?php endforeach; ?>
    <?php if(commonModel::hasPriv('doc', 'createLib')) echo html::a(inlink('createLib', "type=project&projectID={$project->id}"), "<i class='icon icon-plus'></i>", "class='lib addbtn' data-toggle='modal' title='{$lang->doc->createLib}'")?>
  </div>
</div>
<?php js::set('type', 'doc');?>
<?php include '../../common/view/footer.html.php';?>
