<?php
/**
 * The admin view of entry module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id: admin.html.php 7488 2013-12-26 07:26:10Z zhujinyong $
 * @link        http://www.zentao.net
 */
?>
<div class='panel'>
  <form method='post' id='ajaxForm' class='form form-horizontal' action='<?php echo $this->createLink('block', 'set', "index=$index&type=$type")?>'>
  <table class='table table-bordered table-hover table-striped'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->block->params->name;?></th>
        <th><?php echo $lang->block->params->value;?></th>
      </tr>
    </thead>
    <tbody>
      <tr class='a-left'>
        <th class='w-200px'><?php echo $lang->block->name;?></th>
        <td>
        <?php
        echo html::input('name', isset($block->name) ? $block->name : '', "class='form-control'");
        echo html::hidden('blockID', $blockID) . html::hidden('entryID', $entryID);
        ?>
        </td>
      <?php foreach($params as $key => $param):?>
      <tr class='a-left'>
        <th><?php echo $param['name']?></th>
        <td>
        <?php
          if(!isset($param['control'])) $param['control'] = 'input';
          if(!method_exists('html', $param['control'])) $param['control'] = 'input';

          $control = $param['control'];
          $attr    = empty($param['attr']) ? '' : $param['attr'];
          $default = $block ? $block->params->$key : (isset($param['default']) ? $param['default'] : '');
          $values  = isset($param['values']) ? $param['values'] : array();
          if($control == 'select' or $control == 'radio' or $control == 'checkbox')
          {
              echo html::$control("params[$key]", $values, $default, "class='form-control' $attr");
          }
          else
          {
              echo html::$control("params[$key]", $default, "class='form-control' $attr");
          }
        ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr><td colspan="2"><?php echo html::submitButton()?></div></td></tr>
    </tfoot>
  </table>
  </form>
</div>
