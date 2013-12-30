<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
include '../../../sys/common/view/header.lite.html.php';
include '../../../sys/common/view/chosen.html.php';
?>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
<div id='frontHeader'>
  <table class='cont frontNavbar' id='frontTopbar'>
    <tr>
      <td class='w-p50'>
        <?php if(isset($app->company->name)) echo "<span id='companyname'>{$app->company->name}</span> ";?>
      </td>
      <td class='pull-right'><?php commonModel::printTopBar();?></td>
    </tr>
  </table>
  <table class='cont frontNavbar' id='frontNavbar'>
    <tr><td id='mainmenu'><?php commonModel::printMainmenu($this->moduleName);?></td></tr>
  </table>
</div>
<div class="frontNavbar" id="modulemenu">
  <?php commonModel::printModuleMenu($this->moduleName);?>
</div>
<div id='wrap'>
<?php endif;?>
  <div class='outer'>
