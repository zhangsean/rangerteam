<?php
/**
 * The common header file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
$navs = $this->tree->getChildren(0, 'blog');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  if(!isset($title))    $title    = ''; 
  if(!empty($title))    $title   .= $lang->minus;
  if(!isset($keywords)) $keywords = '';
  if(!isset($desc))     $desc     = '';

  echo html::title($title . $config->company->name);
  echo html::meta('keywords',    strip_tags($keywords));
  echo html::meta('description', strip_tags($desc));

  css::import($themeRoot . 'bootstrap/css/core.min.css');
  css::import($themeRoot . 'default/blog.css');

  js::exportConfigVars();
  if($config->debug)
  {
      js::import($jsRoot . 'jquery/min.js');
      js::import($jsRoot . 'bootstrap/min.js');
      js::import($jsRoot . 'ranzhi.js');
      js::import($jsRoot . 'my.js');
  }
  else
  {
      js::import($jsRoot . 'all.js');
  }

  if(isset($pageCSS)) css::internal($pageCSS);

  echo html::icon($webRoot . 'favicon.ico');
  echo html::rss($config->webRoot .'rss.xml', $config->company->name);
  js::set('lang', $lang->js);
?>
<!--[if lt IE 9]>
<?php
js::import($jsRoot . 'html5shiv/min.js');
js::import($jsRoot . 'respond/min.js');
?>
<![endif]-->
</head>
<body>
<div class='container'>
  <div class="header">
    <div class="header-top">
      <div class="nav pull-right">
        <?php echo commonModel::printTopBar();?>
      </div>
      <?php if(isset($config->company->logo)):?>
      <?php $logo = json_decode($config->company->logo);?>
      <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "id='logo' title='{$this->config->company->name}'"));?>
      <?php else:?>
      <h3><?php echo $this->config->company->name?></h3>
      <?php endif;?>      
    </div>
    <ul class="nav">
      <li <?php if(empty($category)) echo "class='active'"?>>
         <?php echo html::a($this->inlink('index'), $lang->blog->home)?>
      </li>
      <?php 
      foreach($navs as $nav)
      {
        $class= $nav->id == $category->id ? "class='nav-blog-$nav->id active'" : "class='nav-blog-$nav->id'";
        echo "<li {$class}>" . html::a($this->inlink('index', "id={$nav->id}", "category={$nav->alias}"), $nav->name) . '</li>';
      }
      ?>
      <li class="pull-right">
        <?php echo html::a($config->webRoot, '<i class="icon-home icon-large"></i> ' . $lang->blog->siteHome);?>
      </li>
      <li class="pull-right">
        <?php echo html::a(helper::createLink('rss', 'index', '', '', 'xml') . '?type=blog', "<i class='icon icon-rss'></i> RSS", "target='_blank'"); ?>
      </li>
    </ul>
  </div>
