<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
js::set('lang', $lang->js);
?>
<div class='container'>
  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) exit($lang->IE6Alert); ?>
  <div id='header'>
    <?php if(isset($config->site->logo)):?>
    <?php $logo = json_decode($config->site->logo);?>
    <div id='logoBox' class='f-left'>
      <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "class='logo' title='{$this->config->company->name}'"));?>
    </div>
    <div class='f-left'><p id='slogan'><?php if(isset($config->site->slogan)) echo $config->site->slogan;?></p></div>
    <?php else: ?>
    <div class='f-left' id='name'><h3><?php if(isset($config->site->name)) echo $config->site->name;?></h3></div>
    <div class='f-left' id='slogan'><?php if(isset($config->site->slogan)) echo $this->config->site->slogan;?></div>
    <?php endif;?>
    <div class='c-both'></div>
  </div>
