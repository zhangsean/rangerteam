<?php
/**
 * The logo view file of ui module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-certificate'></i> <?php echo $lang->ui->setLogo;?></strong>
    <div class='panel-heading-actions'>
      <a href='###' class='action-primary'><i class='icon-edit'></i> <?php echo $lang->site->changeLogo; ?></a>
    </div>
  </div>
  <div id='setContainer'>
    <div id='logoPreview'>
      <div id='headNav'><?php echo commonModel::printTopBar();?></div>
      <div id='headTitle'>
        <?php if(isset($config->site->logo)):?>
        <?php $logo = json_decode($config->site->logo);?>
        <div id='siteLogo'>
          <?php echo html::a('###', html::image($logo->webPath, "class='logo' title='{$this->config->company->name}'"));?>
        </div>
        <?php else: ?>
        <div id='siteName'><h2><?php echo $config->site->name;?></h2></div>
        <?php endif;?>
        <div id='siteSlogan'><span><?php echo $this->config->site->slogan;?></span></div>
      </div>
    </div>
    <ul id='navPreview' class='clearfix'>
      <li><span><i class='icon-home icon-large'></i></span></li>
      <li><span>NEWS</span></li>
      <li><span>PRODUCT</span></li>
      <li><span>ABOUT</span></li>
      <li><span>FORUM</span></li>
      <li><span>HELP</span></li>
    </ul>
    <div id='setLogo'>
      <form method='post' id='ajaxForm' enctype='multipart/form-data' class='form-horizontal'>
        <div class='form-group'>
          <div class='col-sm-8'><?php echo html::file('files', "class='form-control'");?></div>
          <div class='col-sm-4'><?php echo html::submitButton();?></div>
        </div>
      </form>
    </div>

  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
