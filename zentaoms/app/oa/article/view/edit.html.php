<?php
/**
 * The edit view file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::set('type',$type);?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-edit'></i> <?php echo $type == 'blog' ? $lang->blog->edit : ($type == 'page' ? $lang->page->edit : $lang->article->edit);?></strong></div>
  <div class='panel-body'>
  <form method='post' class='form-horizontal' id='ajaxForm'>
    <?php if($type != 'page'):?>
    <div class='form-group'>
      <label class='col-sm-2 control-label required'><?php echo $lang->article->category;?></label>
      <div class='col-sm-4'>
      <?php 
      echo html::select("categories[]", $categories, array_keys($article->categories), "multiple='multiple' class='form-control chosen'");
      ?>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->author;?></label>
      <div class='col-sm-4'><?php echo html::input('author', $article->author, "class='form-control'");?></div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->original;?></label>
      <div class='col-sm-4'><?php echo html::select('original', $lang->article->originalList, $article->original, "class='form-control chosen'");?></div>
      <div id='copyBox' class='col-sm-6'>
        <div class='row'>
          <div class='col-sm-4'><?php echo html::input('copySite', $article->copySite, "class='form-control' placeholder='{$lang->article->copySite}'"); ?> </div>
          <div class='col-sm-8'><?php echo html::input('copyURL',  $article->copyURL, "class='form-control' placeholder='{$lang->article->copyURL}'"); ?></div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div class='form-group'>
      <label class='col-sm-2 control-label required'><?php echo $lang->article->title;?></label>
      <div class='col-sm-10'><?php echo html::input('title', $article->title, "class='form-control'");?></div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->alias;?></label>
      <div class='col-sm-10'>
        <div class="input-group">
          <?php if($type == 'page'):?>
          <span class="input-group-addon">http://<?php echo $this->server->http_host . $config->webRoot?>page/</span>
          <?php else:?>
          <span class="input-group-addon">http://<?php echo $this->server->http_host . $config->webRoot . $type?>/id_</span>
          <?php endif;?>
          <?php echo html::input('alias', $article->alias, "class='form-control' placeholder='{$lang->alias}'");?>
          <span class="input-group-addon">.html</span>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->keywords;?></label>
      <div class='col-sm-10'> <?php echo html::input('keywords', $article->keywords, "class='form-control'");?></div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->summary;?></label>
      <div class='col-sm-10'><?php echo html::textarea('summary', $article->summary, "rows='2' class='form-control'");?></div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label required'><?php echo $lang->article->content;?></label>
      <div class='col-sm-10'><?php echo html::textarea('content', htmlspecialchars($article->content), "rows='10' class='form-control'");?></div>
    </div>
    <div class="form-group">
      <label for="addedDate" class="col-sm-2 control-label"><?php echo $lang->article->addedDate;?></label>
      <div class='col-sm-4'>
        <div class="input-append date">
          <?php echo html::input('addedDate', date('Y-m-d H:i'), "class='form-control'");?>
          <span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
        </div>
      </div>
      <div class="col-sm-6"><span class="help-inline"><?php echo $lang->article->note->addedDate;?></span></div>
    </div>
    <div class='form-group'>
      <label class='col-sm-2 control-label'><?php echo $lang->article->status;?></label>
      <div class='col-sm-4'><?php echo html::select('status', $lang->article->statusList, $article->status, "class='form-control chosen'");?></div>
    </div>
    <div class='form-group'>
      <div class="col-sm-2"></div><div class='col-sm-10'><?php echo html::submitButton();?></div>
    </div>
  </form>
  </div>
</div>

<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/footer.admin.html.php';?>
