<?php 
/**
 * The setting view of contract module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     contract 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->contract->setting;?></strong>
  </div>
  <form method='post' id='ajaxForm'>
    <table class='table table-hover table-form w-400px'>
      <tbody>
        <tr>
          <td>
            <?php
            foreach($config->contract->codeFormat as $unit):
            $value = '';
            ?>
            <div class="input-group">
              <?php 
              if(!isset($lang->contract->codeUnitList[$unit]))
              {
                  $value = $unit; 
                  $unit  = 'fix';
              }
              echo html::select('unit[]', $lang->contract->codeUnitList, $unit, "class='form-control unit'");
              $hideInput = $unit == 'fix' ? '' : "style='display:none'";
              ?>
              <?php echo "<span  {$hideInput} class='input-group-addon'>:</span>" . html::input('unit[]', $value, "{$hideInput} class='form-control'");?>
              <div class='input-group-btn'>
                <i class='icon-plus-sign icon-large'></i>
                <i class='icon-minus-sign icon-large'></i>
              </div>
            </div> 
            <?php endforeach;?>
          </td>
        </tr>
      </tbody>
      <tfoot><tr><td><?php echo html::submitButton();?></td></tr>
      </tfoot>
    </table>
  </form>

  <?php /* Hidden form. */ ?>
  <div id='unitItem' class='hide'>
    <div class="input-group">
      <?php echo html::select('unit[]', $lang->contract->codeUnitList, '', "class='form-control unit'");?>
      <?php echo "<span class='input-group-addon' style='display:none'>:</span>" . html::input('unit[]', '', "class='form-control' style='display:none'");?>
      <div class='input-group-btn'>
        <i class='icon-plus-sign icon-large'></i>
        <i class='icon-minus-sign icon-large'></i>
      </div>
    </div> 
  </div>
  <?php /* Hidden form. */ ?>

<?php include '../../common/view/footer.html.php';?>
