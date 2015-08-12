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
<div class='panel'>
  <div class='panel-heading'>
    <?php echo $lang->attend->settings;?>
  </div>
  <div class='panel-body'>
    <form id='ajaxForm' method='post'>
      <table class='table table-form table-condensed'>
      <tr>
        <th class='w-150px'><?php echo $lang->attend->latestSignInTime?></th>
        <td class='w-300px'><?php echo html::input('latestSignInTime', $latestSignInTime, "class='form-control'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->earliestSignOutTime?></th>
        <td><?php echo html::input('earliestSignOutTime', $earliestSignOutTime, "class='form-control'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->workingDaysPerWeek?></th>
        <td><?php echo html::select('workingDaysPerWeek', $lang->attend->workingDaysPerWeekList, $workingDaysPerWeek, "class='form-control'")?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->attend->forcedSignOut?></th>
        <td><?php echo html::radio('forcedSignOut', $lang->attend->forcedSignOutList, $forcedSignOut)?></td>
        <td></td>
      </tr>
      <tr><th></th><td clospan='2'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

