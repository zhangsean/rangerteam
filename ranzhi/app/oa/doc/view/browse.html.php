<?php
/**
 * The browse view file of doc module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc 
 * @version     $Id $
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/treeview.html.php';?>
<?php js::set('libID ', $libID);?>
<?php js::set('browseType ', $browseType);?>
<div class='col-sm-3'>
  <div class='panel' id='treebox'>
    <div class='panel-heading'>
      <strong><?php echo $libName;?></strong>
    </div>
    <div class='panel-body'>
      <?php echo $moduleTree;?>
      <div class='text-right'>
        <ul class='doclib-action'>
          <?php
          echo '<li>' . html::a($this->createLink('tree', 'browse', "type=doc&moduleID=0&rootID=$libID"), $lang->doc->manageType) . '</li>';
          if(!isset($lang->doc->systemLibs[$libID]))
          {
              echo '<li>' . html::a(inlink('editLib',   "libID=$libID"), $lang->doc->editLib, "data-toggle='modal'") . '</li>';
              echo '<li>' . html::a(inlink('deleteLib', "libID=$libID"), $lang->doc->deleteLib, "class='deleter'") . '</li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class='col-sm-9'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><i class="icon-list-ul"></i> <?php echo $lang->doc->list;?></strong>
      <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create', "libID=$libID&moduleID=$moduleID&productID=$productID&projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->doc->create, 'class="btn btn-primary"');?></div>
    </div>
    <table class='table table-condensed table-hover table-striped table-borderless tablesorter table-fixed' id='docList'>
      <thead>
        <tr>
          <?php $vars = "libID=$libID&module=$moduleID&productID=$productID&projectID=$projectID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
          <th class='w-100px'><?php commonModel::printOrderLink('id',        $orderBy, $vars, $lang->doc->id);?></th>
          <th>                <?php commonModel::printOrderLink('title',     $orderBy, $vars, $lang->doc->title);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('type',      $orderBy, $vars, $lang->doc->type);?></th>
          <th class='w-100px'><?php commonModel::printOrderLink('addedBy',   $orderBy, $vars, $lang->doc->addedBy);?></th>
          <th class='w-120px'><?php commonModel::printOrderLink('addedDate', $orderBy, $vars, $lang->doc->addedDate);?></th>
          <th class='w-100px {sorter:false}'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($docs as $key => $doc):?>
        <?php
        $viewLink = $this->createLink('doc', 'view', "docID=$doc->id");
        $canView  = commonModel::hasPriv('doc', 'view');
        ?>
        <tr class='text-center'>
          <td><?php if($canView) echo html::a($viewLink, sprintf('%03d', $doc->id)); else printf('%03d', $doc->id);?></td>
          <td class='text-left' title="<?php echo $doc->title?>"><nobr><?php echo html::a($viewLink, $doc->title);?></nobr></td>
          <td><?php echo $lang->doc->types[$doc->type];?></td>
          <td><?php isset($users[$doc->addedBy]) ? print($users[$doc->addedBy]) : print($doc->addedBy);?></td>
          <td><?php echo date("m-d H:i", strtotime($doc->addedDate));?></td>
          <td>
            <?php 
            echo html::a($this->createLink('doc', 'edit', "doc={$doc->id}"), $lang->edit);
            if(commonModel::hasPriv('doc', 'delete'))
            {
                $deleteURL = $this->createLink('doc', 'delete', "docID=$doc->id&confirm=yes");
                echo html::a($deleteURL, $lang->delete, "class='reloadDeleter'");
            }
            ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='6'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
