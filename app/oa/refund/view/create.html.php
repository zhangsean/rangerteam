<?php
/**
 * The create view file of refund module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     refund
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form id='ajaxForm' method='post' action="<?php echo $this->createLink('oa.refund', 'create')?>">
  <div class='panel'>
    <div class='panel-heading'>
      <?php echo $lang->refund->create;?>
    </div>
    <div class='panel-body'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->refund->name?></th>
          <td class='w-400px'><?php echo html::input('name', '', "class='form-control'")?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->refund->category?></th>
          <td><?php echo html::select('category', $categories, '', "class='form-control chosen'")?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->refund->date?></th>
          <td><?php echo html::input('date', '', "class='form-control form-date'")?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->refund->money?></th>
          <td>
            <div class='input-group'>
            <?php echo html::input('money', '', "class='form-control'")?>
            <span class='input-group-addon'></span>
            <?php echo html::select('currency', $currencyList, '', "class='form-control w-p20'")?>
            </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->refund->detail?></th>
          <td colspan='2' id='detailBox'>
            <div class='row'>
              <div class='col-md-1'><?php echo html::input('dateList[]', '', "class='form-control form-date' placeholder='{$lang->refund->date}'")?></div>
              <div class='col-md-3'>
                <div class='input-group'>
                  <?php echo html::input('moneyList[]', '', "class='form-control' placeholder='{$lang->refund->money}'")?>
                  <span class='input-group-addon'></span>
                  <?php echo html::select('currencyList[]', $currencyList, '', "class='form-control'")?>
                </div>
              </div>
              <div class='col-md-2'><?php echo html::select('categoryList[]', $categories, '', "class='form-control chosen' placeholder='{$lang->refund->category}'")?></div>
              <div class='col-md-3'><?php echo html::textarea('descList[]', '', "class='form-control' style='height:32px;' placeholder='{$lang->refund->desc}'")?></div>
              <div class='col-md-2'><i class='btn btn-mini icon-plus'></i>&nbsp;&nbsp;<i class='btn btn-mini icon-minus'></i></div>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->refund->desc?></th>
          <td><?php echo html::textarea('desc', '', "class='form-control'")?></td>
          <td></td>
        </tr>
        <tr><th></th><td colspan='2'><?php echo html::submitButton() . '&nbsp;&nbsp;' . html::backButton();?></td></tr>
      </table>
    </div>
  </div>
</form>
<script type='text/template' id='detailTpl'>
<div class='row'>
  <div class='col-md-1'><?php echo html::input('dateList[]', '', "class='form-control form-date' placeholder='{$lang->refund->date}'")?></div>
  <div class='col-md-3'>
    <div class='input-group'>
      <?php echo html::input('moneyList[]', '', "class='form-control' placeholder='{$lang->refund->money}'")?>
      <span class='input-group-addon'></span>
      <?php echo html::select('currencyList[]', $currencyList, '', "class='form-control'")?>
    </div>
  </div>
  <div class='col-md-2'><?php echo html::select('categoryList[]', $categories, '', "class='form-control' placeholder='{$lang->refund->category}'")?></div>
  <div class='col-md-3'><?php echo html::textarea('descList[]', '', "class='form-control' style='height:32px;' placeholder='{$lang->refund->desc}'")?></div>
  <div class='col-md-2'><i class='btn btn-mini icon-plus'></i>&nbsp;&nbsp;<i class='btn btn-mini icon-minus'></i></div>
</div>
</script>
<?php include '../../common/view/footer.html.php';?>
