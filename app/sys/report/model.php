<?php
/**
 * The model file of report module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: model.php 4726 2013-05-03 05:51:27Z chencongzhi520@gmail.com $
 * @link        http://www.ranzhico.com
 */
?>
<?php
class reportModel extends model
{
    /**
     * Create the html code of chart.
     * 
     * @param  string $swf      the swf type
     * @param  string $dataURL  the date url
     * @param  int    $width 
     * @param  int    $height 
     * @access public
     * @return string
     */
    public function createChart($swf, $dataURL, $width = 800, $height = 500)
    {
        $chartRoot = $this->app->getWebRoot() . 'js/fusioncharts/';
        $swfFile   = "fcf_$swf.swf";
        return <<<EOT
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="$width" height="$height" id="fcf$swf" >
<param name="movie"     value="$chartRoot$swfFile" />
<param name="FlashVars" value="&dataURL=$dataURL&chartWidth=$width&chartHeight=$height">
<param name="quality"   value="high" />
<param name="wmode"     value="Opaque">
<embed src="$chartRoot$swfFile" flashVars="&dataURL=$dataURL&chartWidth=$width&chartHeight=$height" quality="high" wmode="Opaque" width="$width" height="$height" name="fcf$swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
EOT;
    }

    /**
     * Create the js code of chart.
     * 
     * @param  string $swf      the swf type
     * @param  string $dataURL  the date url
     * @param  int    $width 
     * @param  int    $height 
     * @access public
     * @return string
     */
    public function createJSChart($swf, $dataXML, $width = 'auto', $height = 500)
    {
        $jsRoot = $this->app->getWebRoot() . 'js/';
        static $count = 0;
        $count ++;
        $chartRoot = $this->app->getWebRoot() . 'js/fusioncharts/';
        $swfFile   = "fcf_$swf.swf";
        $divID     = "chart{$count}div";
        $chartID   = "chart{$count}";

        $js = '';
        if($count == 1) $js = "<script language='Javascript' src='{$jsRoot}/fusioncharts/fusioncharts.js'></script>";
        return <<<EOT
$js
<div id="$divID" class='chartDiv'></div>
<script language="JavaScript"> 
function createChart$count()
{
chartWidth = "$width";
if(chartWidth == 'auto') chartWidth = $('#$divID').width() - 10;
if(chartWidth < 300) chartWidth = 300;
var $chartID = new FusionCharts("$chartRoot$swfFile", "{$chartID}id", chartWidth, "$height"); 
$chartID.setDataXML("$dataXML");
$chartID.render("$divID");
}
</script>
EOT;
    }

    public function createJSChartFlot($projectName, $flotJSON, $width = 'auto', $height = 500)
    {
        $this->app->loadLang('project');
        $jsRoot  = $this->app->getWebRoot() . 'js/';
        $width   = $width . 'px';
        $height  = $height . 'px';

        $dataJSON     = $flotJSON['data'];
        $limitJSON    = $flotJSON['limit'];
        $baselineJSON = $flotJSON['baseline'];
        $dateListJSON = $flotJSON['dateList'];
        $ticksJSON    = $flotJSON['ticks'];
return <<<EOT
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{$jsRoot}jquery/flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="{$jsRoot}jquery/flot/jquery.flot.min.js"></script>
<div id="placeholder" style="width:$width;height:$height;margin:0 auto"></div>
<script type="text/javascript">
$(function () 
{
    var data     = $dataJSON;
    var limit    = $limitJSON;
    var baseline = $baselineJSON;
    var dateList = $dateListJSON;
    var ticks    = $ticksJSON;
    var firstDay = 0;
    function showTooltip(x, y, contents) 
    {
        $('<div id="tooltip">' + contents + '</div>').css
        ({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

        var options = {
            series: {lines:{show: true,  lineWidth: 2}, points: {show: true},hoverable: true},
            legend: {noColumns: 1},
            grid: { hoverable: true, clickable: true },
            xaxis:
            {
                 ticks:ticks,
                 tickFormatter: function(val)
                 {
                     tick = new Date(dateList[val]);
                     if(dateList[val] != undefined)
                     {
                         var month    = tick.getMonth() + 1;
                         var dateTail = '';
                         if(firstDay != month)
                         {
                             dateTail = '/' + month;
                             firstDay = month;
                         }

                         if(config.clientLang == 'en')
                         {
                             title = month + '/' + tick.getDate() + '/' + tick.getFullYear();
                         }
                         else
                         {
                             title = tick.getFullYear() + '/' + month + '/' + tick.getDate();
                         }

                         if(ticks.length <= 30) dateTail = '/' + month;
                         return '<span title="' + title + '">' + tick.getDate() + dateTail + '</span>';
                     }
                     return '';
                 }
            },
            yaxis: {mode: null, min: 0, minTickSize: [1, "day"]}};

    var placeholder = $("#placeholder");
    $("#placeholder").bind("plotselected", function (event, ranges) 
    {
        plot = $.plot(placeholder, data, $.extend(true, {}, options, {xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to } }));
    });
    var plot = $.plot(placeholder, [
            {
                data:data,
                color: "rgb(10, 12, 235)",
                lines:  {show: true},
                points: {show: true}
            },
            {
                data:baseline,
                color: "rgb(235, 12, 10)",
                hoverable: false,
                lines:  {show: true, lineWidth:0.5, lineType:'dashed', style:'dashed'},
                points: {show: false}
            },
            {
                data:limit,
                lines:  {show: false},
                points: {show: false}
            }
        ], options);
    var previousPoint = null;

    placeholder.bind("plothover", function(event, pos, item) 
    {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) 
        {
            if (previousPoint != item.dataIndex)    
            {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2), y = item.datapoint[1].toFixed(2);

                showTooltip(item.pageX, item.pageY, y);
            }
        }
    });
});
</script>
<h1>$projectName  {$this->lang->project->burn}</h1>
EOT;
    }

    /**
     * Create xml data of single charts.
     * 
     * @param  array  $sets 
     * @param  array  $chartOptions 
     * @param  array  $colors 
     * @access public
     * @return string the xml data.
     */
    public function createSingleXML($sets, $chartOptions = array(), $colors = array())
    {
        $data  = pack("CCC", 0xef, 0xbb, 0xbf); // utf-8 bom.
        $data .="<?xml version='1.0' encoding='UTF-8'?>";

        $data .= '<graph';
        foreach($chartOptions as $key => $value) $data .= " $key='$value'";
        $data .= ">";

        if(empty($colors)) $colors = $this->lang->report->colors;
        $colorCount = count($colors);
        $i = 0;
        foreach($sets as $set)
        {
            if($i == $colorCount) $i = 0;
            $color = $colors[$i];
            $i ++;
            $data .= "<set name='$set->name' value='$set->value' color='$color' />";
        }
        $data .= "</graph>";
        return $data;
    }

    public function createSingleJSON($sets, $dateList)
    {
        $data = '[';
        foreach($dateList as $i => $date)
        {
            $date = date('Y-m-d', strtotime($date));
            if(isset($sets[$date]))$data .= "[$i, {$sets[$date]->value}],";
        }
        $data = rtrim($data, ',');
        $data .= ']';
        return $data;
    }

    /**
     * Create the js code to render chart.
     * 
     * @param  int    $chartCount 
     * @access public
     * @return string
     */
    public function renderJsCharts($chartCount)
    {
        $js = '<script language="Javascript">';
        for($i = 1; $i <= $chartCount; $i ++) $js .= "createChart$i()\n";
        $js .= '</script>';
        return $js;
    }

    /**
     * Compute percent of every item.
     * 
     * @param  array    $datas 
     * @access public
     * @return array
     */
    public function computePercent($datas)
    {
        $sum = 0;
        foreach($datas as $data) $sum += $data->value;
        foreach($datas as $data) $data->percent = $sum == 0 ? 1 : round($data->value / $sum, 2);
        return $datas;
    }

    /**
     * Compute sum of datas.
     * 
     * @param  array    $datas 
     * @access public
     * @return array
     */
    public function computeSum($datas)
    {
        $sum = 0;
        foreach($datas as $data) $sum += $data->value;
        return $sum;
    }

    /**
     * Get System URL.
     * 
     * @access public
     * @return void
     */
    public function getSysURL()
    {
        /* Ger URL when run in shell. */
        if(PHP_SAPI == 'cli')
        {
            $url = parse_url(trim($this->server->argv[1]));
            $port = (empty($url['port']) or $url['port'] == 80) ? '' : $url['port'];
            $host = empty($port) ? $url['host'] : $url['host'] . ':' . $port;
            return $url['scheme'] . '://' . $host;
        }
        else
        {
            return common::getSysURL();
        }
    }

    /**
     * getChartData 
     * 
     * @param  string $module 
     * @param  string $chart 
     * @param  string $tableName 
     * @param  string $groupBy 
     * @param  string $currency '' 
     * @access public
     * @return void
     */
    public function getChartData($module, $chart, $tableName, $groupBy, $currency = '')
    {
        list($groupBy, $field, $func) = explode('|', $groupBy);
        if(empty($field)) $field = $groupBy;
        if(empty($func))  $func = 'count';

        /* process lang list. */
        if(isset($this->config->report->{$module}->listName[$chart]))
        {
            $this->app->loadLang($module);
            $listName = $this->config->report->{$module}->listName[$chart];

            /* Set list. */
            if($listName == 'USERS')      $list = $this->loadModel('user')->getPairs('noempty');
            if($listName == 'AREA')       $list = $this->loadModel('tree')->getOptionMenu('area');
            if($listName == 'PRODUCTS')   $list = $this->loadModel('product', 'crm')->getPairs();
            if($listName == 'CUSTOMERS')  $list = $this->loadModel('customer', 'crm')->getPairs();
            if($listName == 'DEPOSITORS') $list = $this->loadModel('depositor')->getPairs();
            if($listName == 'DEPTS')      $list = $this->loadModel('tree')->getOptionMenu('dept', 0);
            if($listName == 'CATEGORIES_TRADE') $list = $this->lang->trade->categoryList + $this->loadModel('tree')->getOptionMenu('out', 0, $removeRoot = true) + $this->loadModel('tree')->getOptionMenu('in', 0);
            if(!isset($list)) $list = $this->lang->{$module}->{$listName};
        }

        if(strpos($groupBy, '_multi') !== false and !empty($list))
        {
            $datas   = array();
            $groupBy = str_replace('_multi', '', $groupBy);
            $field   = str_replace('_multi', '', $field);
            foreach($list as $key => $value)
            {
                $count = $this->dao->select("$func($field) as value")->from($tableName)
                    ->where($groupBy)->like("%$key%")
                    ->beginIf($currency != '')->andWhere('currency')->eq($currency)->fi()
                    ->fetch('value');

                $data = new stdclass();
                $data->name  = $key;
                $data->value = $count; 
                if($count != 0) $datas[$key] = $data;
            }
        }
        else
        {
            $datas = $this->dao->select("$groupBy as name, $func($field) as value")->from($tableName)
                ->beginIf($currency != '')->where('currency')->eq($currency)->fi()
                ->groupBy($groupBy)
                ->orderBy('value_desc')
                ->fetchAll('name');
        }

        /* Add names. */
        if(isset($this->config->report->{$module}->listName[$chart]))
            foreach($datas as $name => $data) $data->name = isset($list[$name]) ? $list[$name] : $this->lang->report->undefined;

        return $datas;
    }
}

function sortSummary($pre, $next)
{
    if($pre['validRate'] == $next['validRate']) return 0;
    return $pre['validRate'] > $next['validRate'] ? -1 : 1;
}
