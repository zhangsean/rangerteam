<?php
/**
 * The view file of edit function of address module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     address
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form id='addressForm' method='post' action='<?php echo inlink('edit', "addressID=$address->id")?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-60px'><?php echo $lang->address->title;?></th>
      <td><?php echo html::input('title', $address->title, "class='form-control'")?></td>
    </tr>
    <tr>
      <th><?php echo $lang->address->country;?></th>
      <td><?php echo html::input('country', $address->country, "class='form-control'")?></td>
    </tr>
    <tr>
      <th><?php echo $lang->address->province;?></th>
      <td><?php echo html::input('province', $address->province, "class='form-control'")?></td>
    </tr>
    <tr>
      <th><?php echo $lang->address->city;?></th>
      <td><?php echo html::input('city', $address->city, "class='form-control'")?></td>
    </tr>
    <tr>
      <th><?php echo $lang->address->location;?></th>
      <td><?php echo html::input('location', $address->location, "class='form-control'")?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton() . html::commonButton($lang->goback, 'reloadModal btn');?></td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
