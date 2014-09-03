<?php 
/**
 * The create view file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include dirname($app->getAppRoot()) . '/sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxForm'>
<div id='recordBox' class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->schema->create;?></strong>
  </div>
  <table class='table table-data'>
    <thead>
      <tr>
        <th class='text-center'><?php echo $lang->schema->name;?></th>
        <td colspan='<?php echo count($records[0]) - 1;?>'>
          <div class='input-group'>
            <div class='col-xs-4'><?php echo html::input('name', $file['title'], "class='form-control'");?></div>
            <?php echo html::submitButton()?>
          </div>
        </td>
      </tr>
      <tr>
        <?php for($i = 0; $i < count($records[0]); $i ++):?>
        <td class='w-200px'><?php echo html::select('schema[' . chr($i + 65) . '][]', $lang->trade->importedFields, '', "class='form-control chosen' multiple data-placeholder='{$lang->schema->placeholder->selectField}'");?></td>
        <?php endfor;?>
      </tr>
    </thead>
    <?php foreach($records as $row => $values):?>
      <?php if($row > 10) break;?>
    <tr>
      <?php foreach($values as $key => $value):?>
      <td><nobr><?php echo $value;?></nobr></td>
      <?php endforeach;?>
    </tr>
    <?php endforeach;?>
  </table>
</div>
</form>
<?php include '../../common/view/footer.html.php';?>
