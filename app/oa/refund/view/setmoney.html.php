<?php
/**
 * The set money view file of refund module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     refund
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='with-side'>
  <div class='side'>
    <nav class='menu leftmenu affix'>
      <ul class='nav nav-primary'>
        <li><?php commonModel::printLink('refund', 'settings', '', "{$lang->refund->reviewer}");?></li>
        <li><?php commonModel::printLink('refund', 'setcategory', '', "{$lang->refund->setCategory}");?></li>
        <li><?php commonModel::printLink('refund', 'setdepositor', '', "{$lang->refund->setDepositor}");?></li>
        <li><?php commonModel::printLink('refund', 'setmoney', '', "{$lang->refund->money}");?></li>
      </ul>
    </nav>
  </div>
  <div class='main'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->refund->money;?></strong></div>
      <div class='panel-body'>
        <form id='ajaxForm' class='form-inline' method='post'>
          <table class='table table-form table-condensed w-p50'>
            <tr>
              <th class='w-60px'><?php echo $lang->refund->money;?></th>
              <td><?php echo html::input('money', isset($this->config->refund->money) ? $this->config->refund->money : '', "class='form-control'");?></td>
              <td class='pd-0'><?php echo html::a('javascript:void(0)', "<i class='icon-question-sign'></i>", "data-original-title='{$lang->refund->moneyTip}' data-toggle='tooltip'");?></td>
            </tr>
            <tr>
              <th></th>
              <td colspan='2'><?php echo html::submitButton();?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
