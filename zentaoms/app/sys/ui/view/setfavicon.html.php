<?php
/**                            
 * The favicon view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL           
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     site           
 * @version     $Id$           
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->ui->setFavicon;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' enctype='multipart/form-data'>
      <div class='form-group'>
          <?php if(isset($this->config->site->favicon)) echo "<div class='col-sm-2'>" . html::image($favicon->webPath) . '</div>';?>
          <div class='col-sm-4'><input type='file' name='files' id='files' class='form-control'></div>
          <div class='col-sm-4'><?php echo html::submitButton();?><?php if($favicon) echo html::a(inlink('deleteFavicon'), $lang->site->favicon->reset, "class='btn'");?></div>
      </div>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
