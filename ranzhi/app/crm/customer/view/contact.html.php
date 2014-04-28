<?php
/**
 * The contact list file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<table class='table table-bordered table-hover table-striped table-data'>
  <caption>
    <div class='pull-right'><?php echo html::a(inlink('linkContact', "customerID=$customerID"), $lang->customer->linkContact, "class='loadInModal'")?></div>
  </caption>
  <thead>
    <tr class='text-center'>
      <th class='w-60px'><?php echo $lang->contact->id;?></th>
      <th><?php echo $lang->contact->realname;?></th>
      <th><?php echo $lang->contact->phone;?></th>
      <th><?php echo $lang->contact->email;?></th>
      <th><?php echo $lang->contact->qq;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td><?php echo $contact->realname;?></td>
      <td><?php echo $contact->phone;?></td>
      <td><?php echo $contact->email;?></td>
      <td><?php echo $contact->qq;?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
