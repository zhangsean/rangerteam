<?php
/**
 * The settings view file of attend module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attend
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <?php echo $lang->attend->settings;?>
  </div>
  <div class='panel-body'>
    <form id='ajaxForm' method='post'>
      <table class='table table-form table-condensed'>
      <tr>
        <th class='w-150px'><?php echo $lang->attend->signInLimit?></th>
        <td class='w-300px'><?php echo html::input('signInLimit', $signInLimit, "class='form-control form-time'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->signOutLimit?></th>
        <td><?php echo html::input('signOutLimit', $signOutLimit, "class='form-control form-time'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->workingDays?></th>
        <td><?php echo html::select('workingDays', $lang->attend->workingDaysList, $workingDays, "class='form-control'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->mustSignOut?></th>
        <td><?php echo html::radio('mustSignOut', $lang->attend->mustSignOutList, $mustSignOut)?></td>
        <td></td>
      </tr>
      <tr><th></th><td clospan='2'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

