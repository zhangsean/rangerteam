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
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->ui->setFavicon;?></caption> 
    <tr>
      <th class='w-150px'>     
        <?php if(isset($this->config->site->favicon)) echo html::image($favicon->webPath);?>
      </th> 
      <td class='v-middle'>    
        <?php echo html::file('files');?>
        <?php echo html::submitButton();?>
        <?php if($favicon) echo html::a(inlink('deleteFavicon'), $lang->ui->favicon->reset, "class='ml-10px'");?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
