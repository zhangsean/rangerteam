<?php
/**
 * The logo view file of ui module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-certificate'></i> <?php echo $lang->company->setLogo;?></strong>
  </div>
  <div id='panel-body'>
    <div id='logoPreview'>
      <div id='headTitle'>
        <?php if(isset($config->company->logo)):?>
        <?php $logo = json_decode($config->company->logo);?>
        <div id='companyLogo'>
          <?php echo html::a('###', html::image($logo->webPath, "class='logo' title='" . zget($config->company, 'name', $lang->zentaoms) . "'"));?>
        </div>
        <?php else: ?>
        <div id='companyName'><h2><?php echo zget($config->company, 'name', $lang->zentaoms)?></h2></div>
        <?php endif;?>
      </div>
    </div>
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
