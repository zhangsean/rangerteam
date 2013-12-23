<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php include 'header.lite.html.php';?>
<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation' id='mainNavbar'>
  <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-ex1-collapse'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
    <?php echo html::a($this->createLink($this->config->default->module), $lang->zentaoms, "class='navbar-brand'");?>
  </div>
  <div class='collapse navbar-collapse navbar-ex1-collapse'>
    <?php echo commonModel::createMainMenu($this->moduleName);?>
    <ul class='nav navbar-nav' id='navbarSwitcher'>
      <li><a href='###'><i class='icon-chevron-sign-right icon-large'></i></a></li>
    </ul>

    <?php echo commonModel::createManagerMenu();?>
    <ul class='nav navbar-nav navbar-right'>
      <li class='dropdown'><?php include 'selectlang.html.php';?></li>
    </ul>
  </div>
</nav>

<div class="clearfix">
  <?php 
  $moduleMenu = commonModel::createModuleMenu($this->moduleName);
  if($moduleMenu) echo "<div class='col-md-2'>$moduleMenu</div>\n<div class='col-md-10'>\n";
  ?>
