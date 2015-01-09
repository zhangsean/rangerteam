<?php
/**
 * The manage privilege view of group module of RanZhi.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     group
 * @version     $Id: managepriv.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<form class='form-inline' id='ajaxForm' method='post'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->group->priv?></strong>
    </div>
    <div class='panel-body'>
      <table class='data'>
        <?php if($type == 'byGroup'):?>
        <tr>
          <td>
            <?php foreach($rights as $code => $right):?>
            <?php if($right['right'] == 1):?>
            <div class='group-item'>
              <label>
                <?php echo html::image($right['icon'], "class='app-icon'");?>
                <?php echo html::checkbox('apps', array($code => $right['name']), $right['right'] == '1' ? $code : '');?>
              </label>
            </div>
            <?php endif?>
            <?php endforeach?>
          </td>
        </tr>
        <tr>
          <td>
            <?php foreach($rights as $code => $right):?>
            <?php if($right['right'] != 1):?>
            <div class='group-item'>
              <label>
                <?php echo html::image($right['icon'], "class='app-icon'");?>
                <?php echo html::checkbox('apps', array($code => $right['name']), $right['right'] == '1' ? $code : '');?>
              </label>
            </div>
            <?php endif?>
            <?php endforeach?>
          </td>
        </tr>
        <?php endif?>
        <?php if($type == 'byApp'):?>
        <tr>
          <th class='w-80px text-center'><?php echo $lang->group->common?></th>
          <td>
            <?php foreach($rights as $code => $right):?>
            <div class='group-item'><?php echo html::checkbox('groups', array($code => $right['name']), $right['right'] == '1' ? $code : '');?></div>
            <?php endforeach?>
          </td>
        </tr>
        <?php endif?>
      </table>
    </div>
    <div class='panel-footer text-center'>
      <?php 
      echo html::submitButton();
      echo html::backButton();
      echo html::hidden('foo'); // Just a var, to make sure $_POST is not empty.
      ?>
    </div>
  </div>
</form>
<?php include '../../common/view/footer.html.php';?>
