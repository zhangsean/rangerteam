<?php 
/**
 * The index view of company module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company 
 * @version     $Id: index.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
include '../../common/view/header.html.php';
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-group'></i> <?php echo $lang->aboutUs; ?></strong></div>
  <div class='panel-body'>
    <div class='article-content'>
      <?php echo $company->content;?>
      <div id='contact'>
        <?php foreach($contact as $item => $value):?>
        <dl>
          <dt><?php echo $lang->company->$item;?>:</dt>
          <dd><?php echo $value;?></dd>
        </dl>
        <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
