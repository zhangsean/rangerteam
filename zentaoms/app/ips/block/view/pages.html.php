<?php
/**
 * The browse view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class='table table-bordered table-hover table-striped w-p80'>
  <caption><?php echo $lang->block->browseRegion;?></caption>
  <tr>
    <th class='w-200px'><?php echo $lang->block->page;?></th>
    <th class='a-center'><?php echo $lang->block->regionList;?></th>
  </tr>
  <?php foreach($this->lang->block->pages as $page => $name):?>
  <?php if(empty($lang->block->regions->$page)) continue;?>
  <tr>
    <td class='a-left'><?php echo $name;?></td>
    <td>
    <?php
    $regions = $lang->block->regions->$page;
    foreach($regions as $region => $regionName)
    {
        echo html::a($this->inlink('setregion', "page={$page}&region={$region}"), $regionName);
    }
    ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
