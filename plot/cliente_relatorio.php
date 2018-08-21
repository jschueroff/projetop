<?php
require('phpplot/phplot.php');
require('mem_image.php');

require_once("../class/session.php");
require_once '../class/conexao.class.php';

require_once("../class/class.user.php");

$auth_user = new USER();

$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);



$busca_cliente_mun = $auth_user->runQuery("SELECT municipio.municipio_sigla AS Estado,
   COUNT(*) AS Clientes
FROM municipio, cliente WHERE id_municipio = municipio_id 
GROUP BY municipio.municipio_sigla
 ORDER BY COUNT(*) DESC;");
$busca_cliente_mun->execute();

while ($row = $busca_cliente_mun->fetch(PDO::FETCH_ASSOC)) {
$data[] = array($row['Estado'], $row['Clientes']);

//  array('China', 1306.31),          
//  array('India', 1080.26),
//  array('United States',  295.73),  
//  array('Indonesia', 241.97),
//  array('Brazil', 186.11),  
//  array('Pakistan', 162.42),
//  array('Bangladesh', 144.32),  
//  array('Russia', 143.42),
    
} 

$graph = new PHPlot(600,250);
$graph->SetDataType('data-data');

//Specify some data
//$data = array(
//    array('', 2000,  750),
//    array('', 2010, 1700),
//    array('', 2015, 2000),
//    array('', 2020, 1800),
//    array('', 2025, 1300),
//    array('', 2030,  400)
//);
$graph->SetDataValues($data);

//Specify plotting area details
//$graph->SetPlotType('lines');
//$graph->SetTitleFontSize('2');
//$graph->SetTitle('Social Security trust fund asset estimates, in $ billions');
//$graph->SetMarginsPixels(null,null,40,null);
//$graph->SetPlotAreaWorld(2000,0,2035,2000);
//$graph->SetPlotBgColor('white');
//$graph->SetPlotBorderType('left');
//$graph->SetBackgroundColor('white');
//$graph->SetDataColors(array('red'),array('black'));
//
////Define the X axis
//$graph->SetXLabel('Year');
//$graph->SetXTickIncrement(5);
//
////Define the Y axis
//$graph->SetYTickIncrement(500);
//$graph->SetPrecisionY(0);
//$graph->SetLightGridColor('blue');
//
////Disable image output
//$graph->SetPrintImage(false);
////Draw the graph
//$graph->DrawGraph();

$legend = array('Estado');

$graph->SetTitle("Quantidade de Clientes por Estado");
$graph->SetImageBorderType('plain');
$graph->SetDataValues($data);
$graph->SetDataType('text-data');
$graph->SetPlotType('bars');
$graph->SetXTickPos('none');
$graph->SetPlotAreaWorld(NULL, 0, NULL, 30);
$graph->SetLegend($legend);
//$plot->SetOutputFile('testeImagem.png');
$graph->DrawGraph();

$pdf = new PDF_MemImage();
$pdf->AddPage();
$pdf->GDImage($graph->img,20,20,170);
$pdf->Output();
?>