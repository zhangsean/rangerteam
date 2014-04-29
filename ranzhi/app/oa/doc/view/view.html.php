<?php
/**
 * The view file of doc module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php echo css::internal($keTableCSS);?>
<?php js::set('libID ', $doc->lib);?>
<div class='col-md-8'>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->doc->view;?></strong></div>
    <div class='panel-body'>
      <table class='table table-form table-data'>
        <tr>
          <th class='w-70px'><?php echo $lang->doc->title;?></th>
          <td>
            <?php echo "#" . $doc->id . ' ' . $doc->title;?>
            <?php if($doc->deleted):?>
            <span class='label label-danger'><?php echo $lang->doc->deleted;?></span>
            <?php endif;?>
          </td>
        </tr>
        <tr>
          <th class='w-70px'><?php echo $lang->doc->digest;?></th>
          <td><?php echo htmlspecialchars_decode($doc->digest);?></td>
        </tr>
        <?php if($doc->type == 'url'):?>
        <tr>
          <th><?php echo $lang->doc->url;?></th>
          <td><?php echo html::a(urldecode($doc->url), '', '_blank');?></td>
        </tr>
        <?php endif;?>
        <?php if($doc->type == 'text'):?>
        <tr>
          <th><?php echo $lang->doc->content;?></th>
          <td class='content'><?php echo htmlspecialchars_decode($doc->content);?></td>
        </tr>
        <?php endif;?>
        <?php if($doc->type == 'file'):?>
        <tr>
          <th><?php echo $lang->files;?></th>
          <td><?php echo $this->fetch('file', 'printFiles', array('files' => $doc->files, 'fieldset' => 'false'));?></td>
        </tr>
        <?php endif;?>
      </table>
    </div>
  </div>
  <?php echo $this->fetch('action', 'history', "objectType=doc&objectID={$doc->id}");?>
  <div class='text-center'>
    <?php
    $browseLink = $this->session->docList ? $this->session->docList : inlink('browse');
    $params     = "docID=$doc->id";
    if(!$doc->deleted)
    {
        ob_start();
        echo html::a($this->createLink('doc', 'edit', $params), $lang->edit, "class='btn'");
        echo html::a($this->createLink('doc', 'delete', $params), $lang->delete, "class='deleter btn'");
        $actionLinks = ob_get_contents();
        ob_end_clean();
        echo $actionLinks;
        echo html::backButton();
    }
    ?>
  </div>
</div>
<div class='col-md-4'>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->doc->basicInfo;?></strong></div>
    <div class='panel-body'>
      <table class='table table-info'>
        <tr>
          <th class='w-80px'><?php echo $lang->doc->lib;?></th>
          <td><?php echo $lib;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->category;?></th>
          <td><?php echo $doc->moduleName ? $doc->moduleName : '/';?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->type;?></th>
          <td><?php echo $lang->doc->types[$doc->type];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->keywords;?></th>
          <td><?php echo $doc->keywords;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->addedBy;?></th>
          <td><?php echo $users[$doc->addedBy];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->addedDate;?></th>
          <td><?php echo $doc->addedDate;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->editedBy;?></th>
          <td><?php echo $users[$doc->editedBy];?></td>
        </tr>
        <tr>
          <th><?php echo $lang->doc->editedDate;?></th>
          <td><?php echo $doc->editedDate;?></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
