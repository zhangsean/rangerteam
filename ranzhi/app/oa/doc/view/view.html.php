<?php
/**
 * The view file of doc module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     doc
 * @version     $Id: view.html.php 975 2010-07-29 03:30:25Z jajacn@126.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php echo css::internal($keTableCSS);?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix' title='DOC'><?php echo ' #' . $doc->id;?></span>
    <strong><?php echo $doc->title;?></strong>
    <?php if($doc->deleted):?>
    <span class='label label-danger'><?php echo $lang->doc->deleted;?></span>
    <?php endif; ?>
  </div>
</div>
<div class='row'>
  <div class='col-md-8 col-lg-9'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->doc->digest;?></legend>
        <div><?php echo htmlspecialchars_decode($doc->digest);?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->doc->keywords;?></legend>
        <div><?php echo $doc->keywords;?></div>
      </fieldset>
      <?php if($doc->type == 'url'):?>
      <fieldset>
        <legend><?php echo $lang->doc->url;?></legend>
        <div><?php echo html::a(urldecode($doc->url), '', '_blank');?></div>
      </fieldset>
      <?php endif;?>
      <?php if($doc->type == 'text'):?>
      <fieldset>
        <legend><?php echo $lang->doc->content;?></legend>
        <div class='content'><?php echo htmlspecialchars_decode($doc->content);?></div>
      </fieldset>
      <?php endif;?>
      <?php if($doc->type == 'file'):?>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $doc->files, 'fieldset' => 'true'));?>
      <?php endif;?>
      <?php include '../../../sys/common/view/action.html.php';?>
      <div class='actions'>
        <?php
        $browseLink = $this->session->docList ? $this->session->docList : inlink('browse');
        $params     = "docID=$doc->id";
        if(!$doc->deleted)
        {
            ob_start();
            echo "<div class='btn-group'>";
            echo html::a($this->createLink('doc', 'edit', $params), $lang->edit);
            echo html::a($this->createLink('doc', 'delete', $params), $lang->delete, "class='deleter'");
            echo '</div>';
            $actionLinks = ob_get_contents();
            ob_end_clean();
            echo $actionLinks;
        }
        else
        {
            //common::printRPN($browseLink);
        }
        ?>
      </div>
    </div>
  </div>
  <div class='col-md-4 col-lg-3'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->doc->basicInfo;?></legend>
        <table class='table table-data table-condensed table-borderless table-fixed'>
         <tr>
            <th class='w-80px'><?php echo $lang->doc->lib;?></th>
            <td><?php echo $lib;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->doc->module;?></th>
            <td><?php echo $doc->moduleName ? $doc->moduleName : '/';?></td>
          </tr>
          <tr>
            <th><?php echo $lang->doc->type;?></th>
            <td><?php echo $lang->doc->types[$doc->type];?></td>
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
      </fieldset>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
