<?php
/**
 * The attend block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include "../../../sys/common/view/calendar.html.php";?>
<?php css::internal(".calendar .day>.content {min-height: 5px;}");?>
<div id='attendCalendar' class='calendar' data-with-header='false' data-drag-then-drop='false'>
  <table class='calendar-data'>
    <tr class='calendar-calendar'>
      <td class='name'>normal</td>
      <td class='color'>primary</td>
    </tr>
    <tr class='calendar-calendar'>
      <td class='name'>abnormal</td>
      <td class='color'>red</td>
    </tr>
    <?php foreach($attends as $attend):?>
    <tr class='calendar-row'>
      <td class='title'><?php echo $lang->attend->abbrStatusList[$attend->status]?></td>
      <td class='desc'><?php echo $lang->attend->statusList[$attend->status]?></td>
      <td class='start'><?php echo $attend->date?></td>
      <td class='end'><?php echo $attend->date?></td>
      <td class='allDay'>true</td>
      <td class='calendar'><?php echo strpos('normal,leave,trip,rest', $attend->status) !== false ? 'normal' : 'abnormal';?></td>
      <?php if(strpos('normal,leave,trip,rest', $attend->status) === false):?>
      <td class='click' data-title=<?php echo $lang->attend->edit;?>><?php echo $this->createLink('oa.attend', 'edit', "date=$attend->date");?></td>
      <?php endif;?>
    </tr>
    <?php endforeach;?>
  </table>
</div>
