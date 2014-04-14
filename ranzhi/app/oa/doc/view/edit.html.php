<?php
/**
 * The edit view file of doc module of RanZhi.
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
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php js::set('type',  $doc->type);?>
<?php js::set('libID', $doc->lib);?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo html::a($this->createLink('doc', 'view', "docID=$doc->id"), $doc->title);?></strong>
    <small class='text-muted'> <?php echo ' ' . $lang->doc->edit;?></small>
  </div>
  <form method='post' enctype='multipart/form-data' id='ajaxForm'>
    <table class='table table-form'> 
      <tr>
        <th class='w-80px'><?php echo $lang->doc->category;?></th>
        <td><?php echo html::select('module', $moduleOptionMenu, $doc->module, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->doc->type;?></th>
        <td><?php echo $lang->doc->types[$doc->type];?></td>
      </tr>
      <tr>
        <th><?php echo $lang->doc->title;?></th>
        <td><?php echo html::input('title', $doc->title, "class='form-control'");?></td>
      </tr> 
      <tr>
        <th><?php echo $lang->doc->keywords;?></th>
        <td><?php echo html::input('keywords', $doc->keywords, "class='form-control'");?></td>
      </tr>  
      <tr id='urlBox' class='hidden'>
        <th><?php echo $lang->doc->url;?></th>
        <td><?php echo html::input('url', urldecode($doc->url), "class='form-control'");?></td>
      </tr>  
      <tr id='contentBox' class='hidden'>
        <th><?php echo $lang->doc->content;?></th>
        <td><?php echo html::textarea('content', $doc->content, "class='form-control' rows='8'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->doc->digest;?></th>
        <td><?php echo html::textarea('digest', $doc->digest, "class='form-control' rows=3");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->doc->comment;?></th>
        <td><?php echo html::textarea('comment','', "class='form-control' rows=3");?></td>
      </tr> 
      <tr id='fileBox' class='hidden'>
        <th><?php echo $lang->doc->files;?></th>
        <td><?php echo $this->fetch('file', 'buildform', 'fileCount=2');?></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <?php echo html::submitButton() . html::backButton() . html::hidden('lib', $libID);?>
          <?php echo html::hidden('product', $doc->product) . html::hidden('project', $doc->project);?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
