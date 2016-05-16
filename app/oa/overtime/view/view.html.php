<?php
/**
 * The view file of overtime module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     overtime
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('confirmReview', $lang->overtime->confirmReview)?>
<div class='row-table'>
  <div class='col-main'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->overtime->desc;?></strong></div>
      <div class='panel-body'>
        <p><?php echo $overtime->desc;?></p>
      </div>
    </div> 
    <?php echo $this->fetch('action', 'history', "objectType=overtime&objectID={$overtime->id}");?>
    <div class='page-actions'>
      <?php
      if($type == 'browseReview' and $overtime->status == 'wait')
      {
          echo html::a($this->createLink('oa.overtime', 'review', "id=$overtime->id&status=pass"), $lang->overtime->statusList['pass'], "class='reviewPass btn'");
          echo html::a($this->createLink('oa.overtime', 'review', "id=$overtime->id&status=reject"), $lang->overtime->statusList['reject'], "class='reviewReject btn'");
      }

      if($type == 'personal' and ($overtime->status == 'wait' or $overtime->status == 'draft'))
      {
          if($overtime->status == 'wait' or $overtime->status == 'draft') echo html::a($this->createLink('oa.overtime', 'switchstatus', "id=$overtime->id"), $overtime->status == 'wait' ? $lang->overtime->cancel : $lang->overtime->commit, "class='switch-status btn'");
          echo html::a($this->createLink('oa.overtime', 'edit', "id=$overtime->id"), $lang->edit, "data-toggle='modal' class='btn'");
          echo html::a($this->createLink('oa.overtime', 'delete', "id=$overtime->id"), $lang->delete, "class='deleter btn'");
      }

      $browseLink = $this->session->overtimeList ? $this->session->overtimeList : inlink('personal');
      commonModel::printRPN($browseLink, $preAndNext);
      ?>
    </div>
  </div>
  <div class='col-side'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->overtime->baseInfo;?></strong></div>
      <div class='panel-body'>
        <table class='table table-info'>
          <tr>
            <th><?php echo $lang->overtime->status;?></th>
            <td class='text-warning'><?php echo $lang->overtime->statusList[$overtime->status];?></td>
          </tr> 
          <tr>
            <th class='w-80px'><?php echo $lang->overtime->type?></th>
            <td><?php echo zget($lang->overtime->typeList, $overtime->type);?></td>
          </tr>
          <tr>
            <th><?php echo $lang->overtime->begin?></th>
            <td><?php echo $overtime->begin . ' ' . $overtime->start;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->overtime->end?></th>
            <td><?php echo $overtime->end . ' ' . $overtime->finish;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->overtime->hours?></th>
            <td><?php echo $overtime->hours . $lang->overtime->hoursTip;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->overtime->createdBy;?></th>
            <td><?php echo zget($users, $overtime->createdBy);?></td>
          </tr> 
          <tr>
            <th><?php echo $lang->overtime->createdDate;?></th>
            <td><?php echo $overtime->createdDate;?></td>
          </tr> 
          <tr>
            <th><?php echo $lang->overtime->reviewedBy;?></th>
            <td><?php echo zget($users, $overtime->reviewedBy);?></td>
          </tr> 
          <tr>
            <th><?php echo $lang->overtime->reviewedDate;?></th>
            <td><?php echo $overtime->reviewedDate;?></td>
          </tr> 
        </table>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
