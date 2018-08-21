<?php

require('../plot/phpplot/phplot.php');
require('../class/mem_image.php');

require_once("../class/session.php");
require_once '../class/conexao.class.php';

require_once("../class/class.user.php");

$auth_user = new USER();

$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

$imagem = 'C:/xampp/htdocs/nota/images/logo.jpg';

$busca_cliente_mun = $auth_user->runQuery("SELECT municipio.municipio_sigla AS Estado,
   COUNT(*) AS Clientes
FROM municipio, cliente WHERE id_municipio = municipio_id 
GROUP BY municipio.municipio_sigla
 ORDER BY COUNT(*) DESC;");
$busca_cliente_mun->execute();

$busca_cliente_mun2 = $auth_user->runQuery("SELECT municipio.municipio_sigla AS Estado,
   COUNT(*) AS Clientes
FROM municipio, cliente WHERE id_municipio = municipio_id 
GROUP BY municipio.municipio_sigla
 ORDER BY COUNT(*) DESC");
$busca_cliente_mun2->execute();


$total_cli = $auth_user->runQuery("SELECT 
   count(*) as Total
FROM  cliente");
$total_cli->execute();
$tota = $total_cli->fetch(PDO::FETCH_ASSOC);

while ($row = $busca_cliente_mun->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array($row['Estado'], $row['Clientes']);
}

$graph = new PHPlot(600, 250);
$graph->SetDataType('data-data');

$graph->SetDataValues($data);

//Specify plotting area details

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

$pdf->SetHeader('|Relatorio de Clientes|{PAGENO}');

$pdf->AddPage();
$pdf->SetFont('Corier', '', 8);
//for($i=1;$i<=10;$i++){
//    //$pdf->Cell(0,10,'Linha '.$i,0,1);
//}
//$pdf->AddPage();
$pdf->GDImage($graph->img, 20, 20, 170);
$pdf->SetHeader('Document Title|Center Text|{PAGENO}');
$pdf->SetFooter('Relatorio de Clientes por Estado');
$pdf->defaultheaderfontsize = 10;
$pdf->defaultheaderfontstyle = 'B';
$pdf->defaultheaderline = 0;
$pdf->defaultfooterfontsize = 10;
$pdf->defaultfooterfontstyle = 'BI';
$pdf->defaultfooterline = 0;
$pdf->Cell(0, 10, '', 0, 1);

$pdf->WriteHTML("Listando Clientes por Estados <br>");
//for($i=1;$i<=10;$i++){
//    $pdf->Cell(0,10,'Linha '.$i,0,1);
//    
//}
$pdf->Ln(20);

//$pdf->SetFont("Arial", "B", 10); 
   
   //MONTA O CABEÇALHO              
$pdf->Image($imagem, 15, 120);

//$pdf->Cell(15, 8, "", 1, 0, 'C');
$pdf->Cell(15, 8, "ESTADO", 1, 0, 'L');
$pdf->Cell(15, 8, "QUANT.", 1, 1, 'L');

while ($row2 = $busca_cliente_mun2->fetch(PDO::FETCH_ASSOC)) {
    //array($row2['Estado']);
//$pdf->Cell(0,10,'Estado: '.$row2['Estado'].' QTD: '.$row2['Clientes'],0,1);

    //$pdf->Cell(15, 8,'', 1, 0, 'C');
    $pdf->Cell(15, 8, $row2['Estado'], 1, 0, 'L');
    $pdf->Cell(15, 8, $row2['Clientes'], 1, 1, 'L');
    //$pdf->Ln(5);
}
    $pdf->Cell(15, 8, "Total", 1, 0, 'L');
    $pdf->Cell(15, 8, $tota['Total'], 1, 1, 'L');


$pdf->Output();
?>