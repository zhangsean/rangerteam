<?php
/**
 * The create book view file of book of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai<daitingting@xirangit.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php'; ?>
<form id='ajaxForm' method='post' class='form-inline'>
  <table class='table table-form'>
    <caption><?php echo $lang->book->createBook;?></caption>
    <tr>
      <th><?php echo $lang->book->author;?></th>
      <td><?php echo html::input('author', $app->user->realname, "class='text-3 form-control'");?></td>
    </tr>
    <tr>
      <th class="w-100px"><?php echo $lang->book->title;?></th>
      <td><?php echo html::input('title', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->alias;?></th>
      <td>
        <div class="input-group text-1">
          <span class="input-group-addon">http://<?php echo $this->server->http_host . $config->webRoot?>book/</span>
          <?php echo html::input('alias', '', "class='text-1 form-control' placeholder='{$lang->alias}'");?>
          <span class="input-group-addon">.html</span>
        </div>
        <span class='star'>*</span>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->book->keywords;?></th>
      <td><?php echo html::input('keywords', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->summary;?></th>
      <td><?php echo html::textarea('summary', '', "class='area-1' rows='3'");?></td>
    </tr>
    <tr>
      <th></th><td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
