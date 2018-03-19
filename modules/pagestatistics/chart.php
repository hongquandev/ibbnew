<?php
/*
  Author : StevenDuc
  Company: GOS
 */
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
require_once ROOTPATH.'/includes/functions.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="jslang/highcharts.js"></script>

<?php
$sql = "SELECT title as t, views as s from cms_page where views > 0  or views >= 1  and month(dateviews) =" . date('m');
$sumviews = "SELECT sum(views) as sumc from cms_page where month(dateviews)=" . date('m');
$result = mysql_query($sql);
$resultsum = mysql_query($sumviews);

$totalrows = 0;
$totalrows = mysql_fetch_row($resultsum);
?>
<?php
while ($row = mysql_fetch_array($result)) {

    $categories[] = array('categories' => array($row['t']));
    $data[] = array('name' => array($row['t']), 'data' => array((int) $row['s']));
}

//echo (json_encode($data));
//echo (json_encode($categories));
//echo (json_encode($totalrows));
?>


<script type="text/javascript">
        
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'bar'
            },
            title: {
                text: 'Report View Number Page With Month'
            },
            subtitle: {
                text: 'bidRhino.com'
            },
            xAxis: {
                categories: null,
                title: {
                    text: 'Reports View Number Page With Month'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php //echo json_encode($totalrows)  ?> ',
                    align: 'high'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +' views';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series:  
<?php echo json_encode($data) ?>
                                            
            });
                    
                    
        });
                    
                    
</script>


<div id="container" style="width: 800px; height: 500px; margin: 0 auto"> </div>
