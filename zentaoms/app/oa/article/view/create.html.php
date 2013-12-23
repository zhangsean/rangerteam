<?php
/**
 * The create view file of article category of chanzhiEPS.
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
<?php js::set('type', $type);?>
<?php js::set('categoryID', $currentCategory);?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>

<div class='panel'>
  <div class='panel-heading'><strong><i class="icon-plus"></i>&nbsp;
    <?php if($type == 'blog'):?>
    <?php echo $lang->blog->create;?>
    <?php elseif($type == 'page'):?>
    <?php echo $lang->page->create;?>
    <?php else:?>
    <?php echo $lang->article->create;?>
    <?php endif;?>
  </strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' role='form' id='ajaxForm'>
      <?php if($type != 'page'):?>
      <div class='form-group'>
        <label class='col-sm-2 control-label required'><?php echo $lang->article->category;?></label>
        <div class='col-sm-4'>
        <?php 
        echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='form-control chosen'");
        ?>
        </div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'><?php echo $lang->article->author;?></label>
        <div class='col-sm-4'><?php echo html::input('author', $app->user->realname, "class='form-control'");?></div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'><?php echo $lang->article->original;?></label>
        <div class='col-sm-4'><?php echo html::select('original', $lang->article->originalList, 1, "class='form-control chosen'");?></div>
        <div id='copyBox' class='col-md-6'>
          <div class='row'>
            <div class='col-md-4'><?php echo html::input('copySite', '', "class='form-control' placeholder='{$lang->article->copySite}'"); ?> </div>
            <div class='col-md-8'><?php echo html::input('copyURL',  '', "class='form-control' placeholder='{$lang->article->copyURL}'"); ?></div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <div class='form-group'>
        <label class='col-sm-2 control-label required'><?php echo $lang->article->title;?></label>
        <div class='col-sm-10'><?php echo html::input('title', '', "class='form-control'");?></div>
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
            <?php echo html::input('alias', '', "class='form-control' placeholder='{$lang->alias}'");?>
            <span class="input-group-addon">.html</span>
          </div>
        </div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'><?php echo $lang->article->keywords;?></label>
        <div class='col-sm-10'> <?php echo html::input('keywords', '', "class='form-control'");?></div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'><?php echo $lang->article->summary;?></label>
        <div class='col-sm-10'><?php echo html::textarea('summary', '', "rows='2' class='form-control'");?></div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label required'><?php echo $lang->article->content;?></label>
        <div class='col-sm-10'><?php echo html::textarea('content', '', "rows='10' class='form-control'");?></div>
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
        <div class='col-sm-10 col-sm-offset-2'><?php echo html::submitButton() . html::commonButton($lang->article->createDraft, "btn btn-default draft") . html::hidden('type', $type);?></td></div>
      </div>
    </form>
  </div>
</div>

<?php include '../../common/view/footer.admin.html.php';?>
