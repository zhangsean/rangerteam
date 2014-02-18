<?php
/**
 * The buildform view file of file module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php if(!$writeable):?>
<h5 class='text-danger a-left'> <?php echo $this->lang->file->errorUnwritable;?> </h5>
<?php else:?>
<div class="file-form">
  <?php for($i = 0; $i < $fileCount; $i ++):?>
  <div class='form-group clearfix'>
    <div class='col-sm-5' style='padding-left:0px'><input type='file' class='form-control' name='files[]' id="file<?php echo $i;?>"  tabindex='-1' /></div>
    <div class='col-sm-7' style='padding-right:0px'><input type='text' id='label<?php echo $i;?>' name='labels[]' class='form-control' tabindex='-1' placeholder='<?php echo $lang->file->label;?>'/></div>
  </div>
  <?php endfor;?>
</div>
<?php endif;?>
