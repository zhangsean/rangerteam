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
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix' title='DOC'><?php echo ' #' . $doc->id;?></span>
    <strong><?php echo $doc->title;?></strong>
    <?php if($doc->deleted):?>
    <span class='label label-danger'><?php echo $lang->doc->deleted;?></span>
    <?php endif;?>
  </div>
</div>
<div class='row'>
  <div class='col-md-8 col-lg-9'>
    <div class='main'>
      <dl>
        <dt><?php echo $lang->doc->digest;?></dt>
        <dd><?php echo htmlspecialchars_decode($doc->digest);?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang->doc->keywords;?></dt>
        <dd><?php echo $doc->keywords;?></dd>
      </dl>
      <?php if($doc->type == 'url'):?>
      <dl>
        <dt><?php echo $lang->doc->url;?></dt>
        <dd><?php echo html::a(urldecode($doc->url), '', '_blank');?></dd>
      </dl>
      <?php endif;?>
      <?php if($doc->type == 'text'):?>
      <dl>
        <dt><?php echo $lang->doc->content;?></dt>
        <dd class='content'><?php echo htmlspecialchars_decode($doc->content);?></dd>
      </dl>
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
            echo html::a($this->createLink('doc', 'edit', $params), $lang->edit, "class='btn'");
            echo html::a($this->createLink('doc', 'delete', $params), $lang->delete, "class='deleter btn'");
            echo '</div>';
            $actionLinks = ob_get_contents();
            ob_end_clean();
            echo $actionLinks;
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
            <th><?php echo $lang->doc->category;?></th>
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
