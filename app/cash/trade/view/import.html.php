<?php 
/**
 * The import view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     trade 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<form method='post' id='ajaxForm' enctype='multipart/form-data' action='<?php echo inlink('import')?>'>
  <table class='table table-form table-condensed'>
    <tr>
      <th class='w-50px'><?php echo $lang->trade->depositor?></th>
      <td class='w-180px'><?php echo html::select('depositor', $depositors, '', "class='form-control'")?></td>
      <th class='w-50px'><?php echo $lang->trade->schema?></th>
      <td class='w-180px'><?php echo html::select('schema', $schemas, '', "class='form-control'")?></td>
      <th class='w-70px'><?php echo $lang->trade->importFile?></th>
      <td class='w-200px'><?php echo html::file('files', "class='form-control'")?></td>
      <th class='w-50px'><?php echo $lang->trade->encode?></th>
      <td class='w-100px'><?php echo html::select('encode', $lang->trade->encodeList, '', "class='form-control'")?></td>
      <th></th><td><?php echo html::submitButton() . $lang->trade->fileNode;?></td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
