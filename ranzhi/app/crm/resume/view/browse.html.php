<?php
/**
 * The view file of browse function of resume module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     resume
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<table class='table table-hover table-bordered'>
  <caption>
    <div class='pull-right'><?php echo html::a(inlink('create', "contactID=$contact->id"), $this->lang->resume->create, "class='loadInModal'");?></div>
  </caption>
  <tr class='text-center'>
    <th class='w-50px'><?php echo $lang->resume->id;?></th>
    <th><?php echo $lang->resume->customer;?></th>
    <th class='w-100px'><?php echo $lang->resume->dept;?></th>
    <th><?php echo $lang->resume->title;?></th>
    <th class='w-100px'><?php echo $lang->resume->join;?></th>
    <th class='w-100px'><?php echo $lang->resume->left;?></th>
    <th class='w-100px'><?php echo $lang->actions;?></th>
  </tr>
  <?php foreach($resumes as $resume):?>
  <tr>
    <td><?php echo $resume->customer?></td>
    <td><?php echo $customers[$resume->customer]?></td>
    <td><?php echo $resume->dept?></td>
    <td><?php echo $resume->title?></td>
    <td><?php echo $resume->join?></td>
    <td><?php echo $resume->left?></td>
    <td>
      <?php
      echo html::a(inlink('edit', "id=$resume->id"), $lang->edit, "class='loadInModal'");
      echo html::a(inlink('delete', "id=$resume->id"), $lang->delete, "class='deleter'");
      ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
