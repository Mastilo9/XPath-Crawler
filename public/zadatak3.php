<?php

include './Services/DatabaseService.php';
include './Repository/ProductRepository.php';
include './Charts/LoadData.php';

const DB_HOST = 'mysql';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';
const DB_DATABASE = 'webapp';

$dbService = new DatabaseService(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$dbService->connect();

$mostPopularLocations = get10MostPopularLocations($dbService); // a
$mileageChartInfo = getMileageChartInfo($dbService); // b
$ageChartInfo = getAgeChartInfo($dbService); // c
$transmissionTypeChartInfo = getTransmissionTypeChartInfo($dbService); // d
$priceChartInfo = getPriceChartInfo($dbService); // e

echo '
<!DOCTYPE HTML>
<html>
    <head>
    <script>
    window.onload = function() { ' .
        js_inline_function_chart_create_and_render($mostPopularLocations, 'mostPopularLocations', '10 najzastupljenijih lokacija')
    .   js_inline_function_chart_create_and_render($mileageChartInfo, 'mileageChartInfo', 'Broj automobila po kilometraznim opsezima')
    .   js_inline_function_chart_create_and_render($ageChartInfo, 'ageChartInfo', 'Broj automobila po godistima')
    .   js_inline_function_chart_create_and_render($transmissionTypeChartInfo, 'transmissionTypeChartInfo', 'Tip menjaca')
    .   js_inline_function_chart_create_and_render($priceChartInfo, 'priceChartInfo', 'Prikaz po cenovnom rangu')
    . '}
    </script>
    </head>
    <body>
    <div id="mostPopularLocationsChartContainer" style="height: 370px; width: 100%;"></div>
    <br>
    <div id="mileageChartInfoChartContainer" style="height: 370px; width: 100%;"></div>
    <br>
    <div id="ageChartInfoChartContainer" style="height: 370px; width: 100%;"></div>
    <br>
    <div id="transmissionTypeChartInfoChartContainer" style="height: 370px; width: 100%;"></div>
    <br>
    <div id="priceChartInfoChartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>
';

function populateChartData($items) {
    $preparedData = [];
    foreach ($items as $item) {
        $preparedData[] = "
        { y : {$item['value']}, label: \"{$item['label']}\" }";
    }

    return implode(', ', $preparedData);
}

function js_inline_function_chart_create_and_render($preparedValues, $namePrefix, $title) {
    return '
        var ' . $namePrefix . 'Chart = new CanvasJS.Chart("' . $namePrefix . 'ChartContainer", {
            theme: "dark1",
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "' . $title . '"
            },
            data: [{
                type: "pie",
                startAngle: 25,
                toolTipContent: "<b>{label}</b>: {y}",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - {y}",
                dataPoints: [' .
                    populateChartData($preparedValues)
            .   ']
            }]
        });
        
        ' . $namePrefix . 'Chart.render();
    ';
}
