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
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->ui->setLogo;?></caption> 
    <tr>
      <th class='w-150px'>
        <?php if(isset($this->config->site->logo)) echo html::image($logo->webPath, "class='w-150px'");?>
      </th> 
      <td class='v-middle'>
        <?php echo html::file('files');?>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
