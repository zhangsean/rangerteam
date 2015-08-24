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
<?php include '../../../sys/common/view/header.lite.html.php';?>
<div class='panel-body'>
  <form id='ajaxForm' method='post'>
    <table class='table table-form table-condensed'>
      <tr>
        <th><?php echo $lang->attend->date?></th>
        <td><?php echo $attend->date?></td>
        <th><?php echo $lang->attend->status?></th>
        <td><?php echo zget($lang->attend->statusList, $attend->status)?></td>
      </tr> 
      <tr>
        <th><?php echo $lang->attend->signIn?></th>
        <td><?php echo $attend->signIn?></td>
        <th><?php echo $lang->attend->signOut?></th>
        <td><?php echo $attend->signOut?></td>
      </tr> 
    </table>
    <table class='table table-form table-condensed'>
      <?php if(!empty($attend->reviewStatus)):?>
      <tr>
        <th><?php echo $lang->attend->reviewStatus?></th>
        <td><?php echo zget($lang->attend->reviewStatusList, $attend->reviewStatus) . " " . $attend->reviewedBy . " " . $attend->reviewedDate?></td>
        <td></td>
      </tr>
      <?php endif;?>
      <tr>
        <th><?php echo $lang->attend->reason?></th>
        <td><?php echo html::select('reason', $lang->attend->reasonList, $attend->reason, "class='form-control'")?></td>
        <td></td>
      </tr> 
      <?php if(strpos(',late,both,absent', $attend->status) !== false):?>
      <tr id='trIn'>
        <th><?php echo $lang->attend->manualIn?></th>
        <td><?php echo html::input('manualIn', empty($attend->manualIn) ? $this->config->attend->signInLimit : $attend->manualIn, "class='form-control'")?></td>
        <td></td>
      </tr>
      <?php endif;?>
      <?php if(strpos(',early,both,absent', $attend->status) !== false):?>
      <tr id='trOut'>
        <th><?php echo $lang->attend->manualOut?></th>
        <td><?php echo html::input('manualOut', empty($attend->manualOut) ? $this->config->attend->signOutLimit : $attend->manualOut, "class='form-control'")?></td>
        <td></td>
      </tr> 
      <?php endif;?>
      <tr>
        <th><?php echo $lang->attend->desc?></th>
        <td><?php echo html::textarea('desc', $attend->desc, "class='form-control'")?></td>
        <td></td>
      </tr> 
      <tr><th></th><td clospan='2'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
