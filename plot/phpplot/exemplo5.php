<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once 'phplot.php';
$data = array(
  array('Jan', 40, 2, 0), array('Feb', 30, 3, 4), array('Mar', 20, 4, 4),
  array('Apr', 10, 5, 4), array('May',  3, 6, 4), array('Jun',  7, 7, 4),
  array('Jul', 10, 8, 4), array('Aug', 15, 9, 4), array('Sep', 80, 5, 4),
  array('Oct', 18, 4, 4), array('Nov', 16, 7, 4), array('Dec', 50, 3, 4),
);
$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
# Main plot title:
$plot->SetTitle('Teste com o PHPPLOT');
# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array('Engenharia', 'Manutencao', 'Administracao'));
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();