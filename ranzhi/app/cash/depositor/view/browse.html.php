<?php 
/**
 * The browse view file of depositor module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     depositor 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->depositor->list;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'>{$lang->depositor->create}</i>", "class='btn btn-primary'")?>
    </div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='depositorList'>
    <thead>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
