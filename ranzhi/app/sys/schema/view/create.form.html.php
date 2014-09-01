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
<div id='recordBox' class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->schema->create;?></strong>
  </div>
  <table class='table table-list'>
    <thead>
      <tr>
        <?php for($i = 0; $i < count($records[0]); $i ++):?>
        <td><?php echo html::select('settings[' . chr($i + 65) . ']', $lang->trade->importedFields, '', "class='form-control chosen' multiple data-placeholder='{$lang->schema->placeholder->selectField}'");?></td>
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
<?php include '../../common/view/footer.html.php';?>
