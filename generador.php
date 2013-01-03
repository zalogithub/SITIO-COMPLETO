<?php

/* incluimos primeramente el archivo que contiene la clase fpdf */

include ('fpdf/fpdf.php');



//IN CLUYO OTRO CODIGO.
include_once('general.php');
$con=new conexion();



//queries whose output will be used as report data.
$query_1 = "SELECT * FROM book"; 
$query_2 = "SELECT title,author FROM book"; 
$query_3 = "SELECT book_id,publisher,reader FROM book"; 
$query_4 = "INSERT INTO  `roles`.`book` (`book_id` ,`title` ,`author` ,`publisher` ,`reader`,`path`)VALUES (NULL ,  'ASTERISK2',  'ANDRES',  'DESITEL',  'ASTERISKANDY', 'http://localhost/hpdf/060236341817042012.pdf')";


// FIN OTRO CODIGO.
/* tenemos que generar una instancia de la clase */

$pdf = new FPDF();

$pdf->AddPage();

/* seleccionamos el tipo, estilo y tamaño de la letra a utilizar */

$pdf->SetFont('Helvetica', 'B', 14);

$pdf->Write (7,"HOLA ESTOY GENERANDO MI PRIMER PDF","http://www.espoch.edu.ec");

$pdf->Ln();

$pdf->Write (7,$_POST['nombre']);

$pdf->Ln(); //salto de linea.

$pdf->Cell(60,7,$_POST['direccion'],1,0,'C');
$pdf->Cell(60,7,$_POST['direccion'],1,0,'C');
$pdf->Cell(60,7,$_POST['direccion'],1,0,'C');

$pdf->Ln(15);//ahora salta 15 lineas.

$pdf->SetTextColor('255','0','0');//para imprimir en rojo.

$pdf->Multicell(190,7,$_POST['tel']."\n esta es la prueba del multicell",1,'R');
$pdf->Multicell(190,7,$_POST['tel']."\n esta es la prueba del multicell",1,'R');

$pdf->Line(0,160,300,160);//impresión de linea.

$pdf->Output("060236341817042012.pdf",'F');

$con->insertarBD($query_4);


echo "<script language='javascript'>window.open('060236341813042012.pdf','_self')</script>";//para ver el archivo pdf generado
$con->desconectarBD($query_4);

?>