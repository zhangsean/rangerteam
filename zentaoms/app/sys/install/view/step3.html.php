<?php
/**
 * The html template file of step3 method of install module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <?php if(isset($error)):?>
  <table class='table table-bordered shadow'>
	<caption><?php echo $lang->install->error;?></caption>
    <tr><td class='red'><?php echo $error;?></td></tr>
    <tr><td><?php echo html::backButton($lang->install->pre, 'btn btn-primary');?></td></tr>
  </table>
  <?php else:?>
  <table class='table table-bordered shadow'>
	<caption><?php echo $lang->install->saveConfig;?></caption>
    <tr>
      <td>
        <?php 
        echo html::textArea('config', $result->content, "rows='10' class='area-1 f-12px'");
        printf($lang->install->save2File, $result->myPHP);
        ?>
      </td>
    </tr>
    <tr><td class='a-center'><?php echo html::a(inlink('step4'), $lang->install->next, "class='btn btn-primary'");?></td></tr>
  </table>
  <?php endif;?>
</div>
<?php include './footer.html.php';?>
