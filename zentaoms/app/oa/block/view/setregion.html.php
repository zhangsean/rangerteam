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
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-cog'></i> <?php echo $lang->block->setPage . ' - '. $lang->block->pages[$page] . ' - ' . $lang->block->regions->{$page}[$region];?></strong></div>
    <form id='ajaxForm' method='post'>
      <table class='table table-hover table-striped table-bordered'>
        <caption></caption>
        <thead>
          <tr>
            <th class='text-center col-xs-4'><?php echo $lang->block->title;?></th>
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
</div>
<?php include '../../common/view/footer.admin.html.php';?>
