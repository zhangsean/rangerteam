<?php
/**
 * The lang view file of setting module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     setting
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class="col-md-2">
  <ul class="nav nav-primary nav-stacked leftmenu affix">
    <li id='userTab'><?php echo html::a(inlink('lang', "module=user&type=roleList"), $lang->setting->module->user . "<i class='icon-chevron-right'></i>")?></li>
    <li id='productTab'><?php echo html::a(inlink('lang', "module=product&type=statusList"), $lang->setting->module->product . "<i class='icon-chevron-right'></i>")?></li>
    <li id='customerTab'><?php echo html::a(inlink('lang', "module=customer&type=typeList"), $lang->setting->module->customer . "<i class='icon-chevron-right'></i>")?></li>
  </ul>
</div>
<div class='col-md-10'>
  <div class='panel'>
    <form method='post' id='ajaxForm'>
      <table class='table'>
        <tr>
          <th class='w-100px'><?php echo $lang->setting->key;?></th>
          <th><?php echo $lang->setting->value;?></th>
          <th class='w-40px'></th>
        </tr>
        <?php foreach($fieldList as $key => $value):?>
        <tr class='text-center'>
          <?php $system = isset($systemField[$key]) ? $systemField[$key] : 1;?>
          <td><?php echo $key === '' ? 'NULL' : $key; echo html::hidden('keys[]', $key) . html::hidden('systems[]', $system);?></td>
          <td>
            <?php $readonly = ($module == 'product' and $field == 'statusList' and $system == 1) ? 'readonly' : ''; ?>
            <?php echo html::input("values[]", $value, "class='form-control' $readonly");?>
          </td>
          <td>
            <a href='javascript:void()' class='link-icon' onclick='addItem(this)'>+</a>
            <?php if(!$system):?><a href='javascript:void()' onclick='delItem(this)' class='link-icon'>x</a><?php endif;?>
          </td>
        </tr>
        <?php endforeach;?>
        <tfoot>
          <tr>
            <td colspan='3' class='text-center'>
            <?php 
            $appliedTo = array($clientLang => $lang->setting->currentLang, 'all' => $lang->setting->allLang);
            echo html::radio('lang', $appliedTo, 'all');
            echo html::submitButton();
            echo html::a(inlink('restore', "module=$module&field=$field"), $lang->setting->restore, "class='btn deleter'");
            ?>
            </td>
          </tr>
        <tfoot>
      </table>
    </form>
  </div>
</div>
<?php
$itemRow = <<<EOT
  <tr class='a-center'>
    <td>
      <input type='text' value="" name="keys[]" class='form-control'>
      <input type='hidden' value="0" name="systems[]">
    </td>
    <td>
      <input type='text' value="" name="values[]" class='form-control'>
    </td>
    <td class='a-left'>
      <a href='javascript:void()' class='link-icon' onclick='addItem(this)'>+</a>
      <a href='javascript:void()' class='link-icon' onclick='delItem(this)'>x</a>
    </td>
  </tr>
EOT;
?>
<?php js::set('itemRow', $itemRow)?>
<?php js::set('module', $module)?>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
