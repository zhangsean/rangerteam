<?php
/**
 * The set view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
if($type == 'html')
{
    $webRoot   = $config->webRoot;
    $jsRoot    = $webRoot . "js/";
    $themeRoot = $webRoot . "theme/";
    include '../../common/view/kindeditor.html.php';
}
?>
<form method='post' id='blockForm' class='form form-horizontal' action='<?php echo $this->createLink('block', 'set', "index=$index&type=$type&blockID=$blockID")?>'>
  <table class='table table-form'>
  <?php if($type == 'rss'):?>
    <tbody>
      <tr>
        <th class='w-100px'><?php echo $lang->block->name?></th>
        <td><?php echo html::input('title', $block ? $block->title : '', "class='form-control'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->block->color;?></th>
        <td>
          <div class='input-group-btn'>
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
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->block->lblRss?></th>
        <td><?php echo html::input('params[link]', $block ? $block->params->link : '', "class='form-control'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->block->lblNum?></th>
        <td><?php echo html::input('params[num]', $block ? $block->params->num : 0, "class='form-control'")?></td>
      </tr>
    </tbody>
    <?php else:?>
    <tbody>
      <tr>
        <th><?php echo $lang->block->name?></th>
        <td><?php echo html::input('title', $block ? $block->title : '', "class='form-control'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->block->color;?></th>
        <td>
          <div class='input-group-btn'>
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
        </td>
      </tr>
      <tr>
        <th class='w-100px'><?php echo $lang->block->lblHtml;?></th>
        <td><?php echo html::textarea('html', $block ? $block->params->html : '', "class='form-control' rows='10'")?></td>
      </tr>
    </tbody>
    <?php endif;?>
    <tfoot>
      <tr><td colspan='2' class='text-center'><?php echo html::submitButton()?></td></tr>
    </tfoot>
  </table>
  </form>
