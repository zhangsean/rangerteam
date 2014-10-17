<?php
/**
 * The public form items of block of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      guanxiying <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php $this->loadModel('block', 'sys');?>
<tr>
  <th class='w-100px'><?php echo $lang->block->name?></th>
  <td><?php echo html::input('title', $block ? $block->title : '', "class='form-control'")?></td>
</tr>
<tr>
  <th><?php echo $lang->block->style;?></th>
  <td>
    <div class='w-240px'>
      <div class='input-group'>
        <span class='input-group-addon'><?php echo $lang->block->grid;?></span>
        <?php echo html::select('grid', $config->block->gridOptions, $block ? $block->grid : 4, "class='form-control chosen' placeholder='请选择宽度'")?>
        <div class='input-group-btn block'>
          <?php $btn = isset($block->params->color) ? 'btn-' . $block->params->color : 'btn-default'?>
          <button type='button' class="btn <?php echo $btn;?> dropdown-toggle" data-toggle='dropdown'>
            <?php echo $lang->block->color;?> <span class='caret'></span>
          </button>
          <?php echo html::hidden('params[color]', isset($block->params->color) ? $block->params->color : 'default');?>
          <div class='dropdown-menu buttons'>
            <li><button type='button' data-id='default' class='btn btn-block btn-default'><?php echo $lang->block->color;?></button></li>
            <li><button type='button' data-id='primary' class='btn btn-block btn-primary'><?php echo $lang->block->color;?></button></li>
            <li><button type='button' data-id='warning' class='btn btn-block btn-warning'><?php echo $lang->block->color;?></button></li>
            <li><button type='button' data-id='danger' class='btn btn-block btn-danger'><?php echo $lang->block->color;?></button></li>
            <li><button type='button' data-id='success' class='btn btn-block btn-success'><?php echo $lang->block->color;?></button></li>
            <li><button type='button' data-id='info' class='btn btn-block btn-info'><?php echo $lang->block->color;?></button></li>
          </div>
        </div>
      </div>
    </div>
  </td>
</tr>
