<?php
/**
 * The edit book view file of book of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai<daitingting@xirangit.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php 
$path = explode(',', $node->path);
js::set('path', json_encode($path));
?>
<form id='ajaxForm' method='post' class='form-inline' action='<?php echo inlink('edit', "nodeID=$node->id")?>'>
  <table class='table table-form'>
    <caption><?php echo $lang->edit . $lang->book->typeList[$node->type];?></caption>
    <tr>
      <th><?php echo $lang->book->author;?></th>
      <td><?php echo html::input('author', $node->author, "class='text-3 form-control'");?></td>
    </tr>
    <?php if($node->type != 'book'):?>
    <tr>
      <th class='w-100px'><?php echo $lang->book->parent;?></th>
      <td><?php echo html::select("parent", $optionMenu, $node->parent, "class='select-3 form-control'");?></td>
    </tr>
    <?php endif;?>
    <tr>
      <th class="w-100px"><?php echo $lang->book->title;?></th>
      <td><?php echo html::input('title', $node->title, 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->alias;?></th>
      <td>
        <div class='input-group text-1'>
          <span class='input-group-addon'>http://<?php echo $this->server->http_host . $config->webRoot?>book/id@</span>
          <?php echo html::input('alias', $node->alias, "class='text-1 form-control' placeholder='{$lang->alias}'");?>
          <span class='input-group-addon'>.html</span>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->book->keywords;?></th>
      <td><?php echo html::input('keywords', $node->keywords, "class='text-1 form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->summary;?></th>
      <td><?php echo html::textarea('summary', $node->summary, "class='area-1' rows='2'");?></td>
    </tr>
    <?php if($node->type == 'article'):?>
    <tr>
      <th><?php echo $lang->book->content;?></th>
      <td valign='middle'><?php echo html::textarea('content', $node->content, "rows='12' class='area-1 form-control'");?></td>
    </tr>
    <?php endif;?>
    <tr>
      <th></th>
      <td><?php echo html::submitButton() . html::hidden('referer', $this->server->http_referer);?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
