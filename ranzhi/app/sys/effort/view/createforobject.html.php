<?php
/**
 * The view file for createForObject of effort module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     effort
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<div class="modal-dialog" style="width:800px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->effort->create; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('effort', 'createForObject', "objectType=$objectType&objectID=$objectID&account=$account&date=" . str_replace('-', '', $date)) ?>'>
        <table class='table' id='objectTable'> 
          <tr class='text-center'>
            <th class='w-id'><?php echo $lang->effort->id;?></th>
            <th class='w-150px'><?php echo $lang->effort->date;?></th>
            <th class='w-80px'><?php echo $lang->effort->consumed;?></th>
            <?php if($objectType == 'task'):?>
            <th class='w-80px'><?php echo $lang->effort->left;?></th>
            <?php endif;?>
            <th><?php echo $lang->effort->work;?></th>
            <th class='w-100px'><?php echo $lang->actions;?></th>
          </tr>
          <?php foreach($efforts as $effort):?>
          <tr>
            <td class='text-center'><?php echo $effort->id?></td>
            <td class='text-center'><?php echo $effort->date?></td>
            <td class='text-center'><?php echo $effort->consumed?></td>
            <?php if($objectType == 'task'):?>
            <td class='text-center'><?php echo $effort->left;?></td>
            <?php endif;?>
            <td><?php echo $effort->work;?></td>
            <td class='text-center'>
              <?php
              echo html::a(inlink('edit', "effortID=$effort->id"), $lang->edit, "class='edit'");
              echo html::a(inlink('delete', "effortID=$effort->id"), $lang->delete, "class='deleter'");
              ?>
            </td>
          </tr>
          <?php endforeach;?>
          <?php $today = date(DT_DATE1);?>
          <?php for($i = 1; $i <= 5; $i++):?>
          <tr>
            <td align='center'><?php echo $i . html::hidden("id[$i]", $i);?></td>
            <td><?php echo html::input("dates[$i]", $today, "class='form-control date'");?></td>
            <td><?php echo html::input("consumed[$i]", '', "class='form-control'");?></td>
            <?php if($objectType == 'task'):?>
            <td><?php echo html::input("left[$i]", '', "class='form-control'");?></td>
            <?php endif;?>
            <td>
            <?php
            echo html::hidden("objectType[$i]", $objectType); 
            echo html::hidden("objectID[$i]", $objectID); 
            echo html::input("work[$i]", '', "class='form-control'");
            ?>
            </td>
            <td></td>
          </tr>  
          <?php endfor;?>
          <tr>
            <?php $cols = $objectType == 'task' ? 6 : 5;?>
            <td colspan='<?php echo $cols?>' class='text-center'><?php echo html::submitButton();?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
