<?php
//Include the code
include('phplot.php');

//Define the object
$graph =& new PHPlot(400,250);

$graph->SetPrintImage(0); //Don't draw the image until specified explicitly

$example_data = array(
     array('a',3),
     array('b',5),
     array('c',7),
     array('d',8),
     array('e',2),
     array('f',6),
     array('g',7)
);

$graph->SetDataType("text-data");  //Must be called before SetDataValues

$graph->SetDataValues($example_data);
$graph->SetYTickIncrement(2);  //a smaller graph now - so we set a new tick increment

$graph->SetXLabelAngle(90);
$graph->SetXTitle("");
$graph->SetYTitle("Price");
$graph->SetPlotType("lines");
$graph->SetLineWidth(1);

$graph->SetNewPlotAreaPixels(70,10,375,100);  // where do we want the graph to go
$graph->DrawGraph(); // remember, since we said not to draw yet, PHPlot
                     // still needs a PrintImage command to write an image.


//Now do the second chart on the same image
unset($example_data);  //we are re-using $example_data (to save memory), but you don't have to
$example_data = array(
     array('a',30,40,20),
     array('b',50,'',10),  // here we have a missing data point, that's ok
     array('c',70,20,60),
     array('d',80,10,40),
     array('e',20,40,60),
     array('f',60,40,50),
     array('g',70,20,30)
);

$graph->SetDataType("text-data");  //Must be called before SetDataValues

$graph->SetDataValues($example_data);

$graph->SetXTitle("");
$graph->SetYTitle("Verbal Cues");
$graph->SetYTickIncrement(10);
$graph->SetPlotType("bars");
$graph->SetXLabelAngle(0);  //have to re-set as defined above

$graph->SetNewPlotAreaPixels(70,120,375,220);
$graph->SetPlotAreaWorld(0,0,7,80);
$graph->DrawGraph();

//Print the image
$graph->PrintImage();
?>