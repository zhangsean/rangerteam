<?php
/**
 * The create view file of article category of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php js::set('type', $type);?>
<?php js::set('categoryID', $currentCategory);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-plus'></i>&nbsp;<?php echo $lang->article->create;?></strong></div>
  <div class='panel-body'>
    <form method='post' role='form' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th style='width: 100px'><?php echo $lang->article->category;?></th>
          <td style="width: 40%"><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='form-control chosen'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->article->author;?></th>
          <td><?php echo html::input('author', $app->user->realname, "class='form-control'");?>
        </tr>
        <tr>
          <th><?php echo $lang->article->original;?></th>
          <td><?php echo html::select('original', $lang->article->originalList, 1, "class='form-control chosen'");?></td>
          <td>
            <div class='row' id='copyBox'>
              <div class='col-md-4'><?php echo html::input('copySite', '', "class='form-control' placeholder='{$lang->article->copySite}'"); ?> </div>
              <div class='col-md-8'><?php echo html::input('copyURL',  '', "class='form-control' placeholder='{$lang->article->copyURL}'"); ?></div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->article->title;?></th>
          <td colspan='2'><?php echo html::input('title', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->article->alias;?></th>
          <td colspan='2'>
            <div class='input-group'>
              <?php if($type == 'page'):?>
              <span class='input-group-addon'>http://<?php echo $this->server->http_host . $config->webRoot?>page/</span>
              <?php else:?>
              <span class='input-group-addon'>http://<?php echo $this->server->http_host . $config->webRoot . $type?>/id_</span>
              <?php endif;?>
              <?php echo html::input('alias', '', "class='form-control' placeholder='{$lang->alias}'");?>
              <span class="input-group-addon">.html</span>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->article->keywords;?></th>
          <td colspan='2'><?php echo html::input('keywords', '', "class='form-control'");?></td>
        </tr>
      <tr>
        <th><?php echo $lang->article->summary;?></th>
        <td colspan='2'><?php echo html::textarea('summary', '', "rows='2' class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->article->content;?></th>
        <td colspan='2'><?php echo html::textarea('content', '', "rows='10' class='form-control'");?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='2'><?php echo html::submitButton() . html::commonButton($lang->article->createDraft, "btn btn-default draft") . html::hidden('type', $type);?></td>
      </div>
    </form>
  </div>
</div>

<?php include '../../common/view/footer.html.php';?>
