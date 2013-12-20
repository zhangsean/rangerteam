<?php
/**
 * The setpage view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php'; ?>
<form id='ajaxForm' method='post'>
  <table class='table table-hover table-striped'>
    <caption><?php echo $lang->block->setPage . '-'. $lang->block->pages[$page] . '-' . $lang->block->regions->{$page}[$region];?></caption>
    <thead>
      <tr class='a-center'>
        <th class='w-p30 a-center'><?php echo $lang->block->title;?></th>
        <th><?php echo $lang->actions; ?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($blocks as $block) echo $this->block->createEntry($block);?>
    </tbody>
    <tbody id='entry' class='hide'><?php echo $this->block->createEntry();?></tbody>
    <tfoot>
      <tr> <td colspan='2' class='a-center'> <?php echo html::submitButton();?> </td> </tr>
    </tfoot>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
