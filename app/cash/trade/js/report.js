$(document).ready(function()
{
    var colorIndex = 0;
    function nextAccentColor(idx)
    {
        if(typeof idx === 'undefined') idx = colorIndex++;
        return new $.zui.Color({h: idx * 67 % 360, s: 0.5, l: 0.55});
    }
    
    var labels   = [];
    var datasets = [];
    
    var colorIn     = nextAccentColor().toCssStr();
    var colorOut    = nextAccentColor().toCssStr();
    var colorProfit = nextAccentColor().toCssStr();

    var datasetIn     = {label: $('#lineChart').find('thead .chart-label-in').text(), color: colorIn, data: []};
    var datasetOut    = {label: $('#lineChart').find('thead .chart-label-out').text(), color: colorOut, data: []};
    var datasetProfit = {label: $('#lineChart').find('thead .chart-label-profit').text(), color: colorProfit, data: []};
    
    $('#lineChart').find('.chart-color-dot-in').css('color', colorIn);
    $('#lineChart').find('.chart-color-dot-out').css('color', colorOut);
    $('#lineChart').find('.chart-color-dot-profit').css('color', colorProfit);
    $('#lineChart').find('tbody .chart-value-in').each(function(){ datasetIn.data.push(parseInt($(this).text())); })
    $('#lineChart').find('tbody .chart-value-out').each(function(){ datasetOut.data.push(parseInt($(this).text())); })
    $('#lineChart').find('tbody .chart-value-profit').each(function(){ datasetProfit.data.push(parseInt($(this).text())); })
    
    var $rows = $('#lineChart').find('tbody > tr').not(':last').each(function(idx)
    {
        labels.push($(this).find('.chart-label').text());
    });
    
    var data = {labels: labels, datasets: [datasetIn, datasetOut, datasetProfit]};
    
    var options = {};
    chart = $('#myLineChart').lineChart(data, options);
    
    $('#year').change(function()
    {
       var selectYear     = $('#year option:selected').text();
       var selectCurrency = $('#currency').val();
       location.href = createLink('trade', 'report', "date=" + selectYear + "&currency=" + selectCurrency);
    })

    $('#currency').change(function()
    {
       var selectYear     = $('#year option:selected').text();
       var selectCurrency = $('#currency').val();
       location.href = createLink('trade', 'report', "date=" + selectYear + "&currency=" + selectCurrency);
    })

    $('#month').change(function()
    {
       var selectMonth    = $('#year option:selected').text() + $('#month option:selected').text();
       var selectCurrency = $('#currency').val();
       location.href = createLink('trade', 'report', "date=" + selectMonth + "&currency=" + selectCurrency) + '#monthlyChart';
    })
})
