<?php
/**
 * The others view file of setting module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     setting
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <?php echo $lang->setting->customer;?>
  </div>
  <div class='panel-body'>
    <form id='ajaxForm' method='post'>
      <table class='table table-form table-condensed'>
      <tr>
        <th class='w-150px'><?php echo $lang->setting->intoCustomerPool?></th>
        <td><?php echo html::input('intoCustomerPool', $intoCustomerPool, "class='form-control w-200px'")?><span class='text-important'><?php echo $lang->setting->intoCustomerPoolTip?></span></td>
        <td></td>
      </tr>
      <tr><th></th><td clospan='2'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

