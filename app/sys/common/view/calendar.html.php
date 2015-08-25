<?php
/**
 * The calendar view of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     common 
 * @version     $Id: calendar.html.php 2508 2015-01-26 08:32:52Z chujilu $
 * @link        http://www.ranzhico.com
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$clientLang = $this->app->getClientLang();
$jsRoot     = $config->webRoot . "js/";
css::import($jsRoot . 'calendar/zui.calendar.min.css');
js::import($jsRoot  . 'calendar/zui.calendar.min.js'); 
?>
<script language='javascript'>
$(function()
{
    $('div.calendar').each(function()
    {
        var calendarObj = $(this);
        var settings    = calendarObj.data();

        /* Get data from table. */
        var calendars = new Array();
        calendarObj.find(".calendar-data .calendar-calendar").each(function()
        {
            var rowObj = $(this);
            var calendar = new Array();
            if(rowObj.find('.name').length)  calendar['name']  = rowObj.find('.name').html();
            if(rowObj.find('.title').length) calendar['title'] = rowObj.find('.title').html();
            if(rowObj.find('.desc').length)  calendar['desc']  = rowObj.find('.desc').html();
            if(rowObj.find('.color').length) calendar['color'] = rowObj.find('.color').html();
            calendars.push(calendar);
        });
        var events = new Array();
        calendarObj.find(".calendar-data .calendar-row").each(function()
        {
            var rowObj = $(this);
            var event = new Array();
            if(rowObj.find('.title').length)    event['title']    = rowObj.find('.title').html();
            if(rowObj.find('.desc').length)     event['desc']     = rowObj.find('.desc').html();
            if(rowObj.find('.allDay').length)   event['allDay']   = rowObj.find('.allDay').html();
            if(rowObj.find('.start').length)    event['start']    = rowObj.find('.start').html();
            if(rowObj.find('.end').length)      event['end']      = rowObj.find('.end').html();
            if(rowObj.find('.data').length)     event['data']     = rowObj.find('.data').html();
            if(rowObj.find('.calendar').length) event['calendar'] = rowObj.find('.calendar').html();
            events.push(event);
        });
        calendarObj.find(".calendar-data").remove();

        /* Init calendar. */
        settings.data = {'calendars':calendars, 'events':events};
        calendarObj.calendar(settings);
    });
});
</script>
