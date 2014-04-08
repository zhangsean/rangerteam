<?php
/**
 * The set view file of block module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.co
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
<form method='post' id='ajaxForm' class='form form-horizontal' action='<?php echo $this->createLink('block', 'set', "index=$index&type=$type")?>'>
  <table class='table table-form w-p80'>
  <?php if($type == 'rss'):?>
    <tbody>
      <tr class='a-left'>
        <th class='w-100px'><?php echo $lang->block->name?></th>
        <td><?php echo html::input('name', $block ? $block->name : '', "class='form-control'")?></td>
      </tr>
      <tr class='a-left'>
        <th><?php echo $lang->block->lblRss?></th>
        <td><?php echo html::input('params[link]', $block ? $block->params->link : '', "class='form-control'")?></td>
      </tr>
      <tr class='a-left'>
        <th><?php echo $lang->block->lblNum?></th>
        <td><?php echo html::input('params[num]', $block ? $block->params->num : 0, "class='form-control'")?></td>
      </tr>
    </tbody>
    <?php else:?>
    <tbody>
      <tr class='a-left'>
        <th><?php echo $lang->block->name?></th>
        <td><?php echo html::input('name', $block ? $block->name : '', "class='form-control'")?></td>
      </tr>
      <tr class='a-center'>
        <th class='w-100px'><?php echo $lang->block->lblHtml;?></th>
        <td><?php echo html::textarea('html', $block ? $block->html : '', "class='form-control' rows='10'")?></td>
      </tr>
    </tbody>
    <?php endif;?>
    <tfoot>
      <tr><td></td><td><?php echo html::submitButton()?></td></tr>
    </tfoot>
  </table>
  </form>
