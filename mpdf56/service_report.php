<?php
include('mpdf.php');
include('sdba/sdba.php');

$mpdf=new mPDF('UTF-8','A4','','',16,16,30,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetAutoFont(AUTOFONT_ALL);
$mpdf->SetDisplayMode('fullpage');

$stylesheet = file_get_contents('css/bootstrap.css');
//$stylesheet = file_get_contents('../css/style.css');
//$mpdf->watermark_font = 'GB';
//$mpdf->SetWatermarkText('中国水印',0.1);
$header = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family:
serif; font-size: 9pt; color: #000088;"><tr>
 
<td width="60%" ><img src="img/ies_logo.png" width="380px" /></td>
<td width="40%" style="text-align: right;"><span style="font-weight: bold;"> </span></td>
</tr></table>
';

$mpdf->SetHTMLHeader($header);
$url = 'http://uniquecode.net/job/ms/ed_pdf.php?id='.$_GET['id'];
$strContent = file_get_contents($url);
//print_r($strContent);die;
$mpdf->showWatermarkText = true;
$mpdf->SetAutoFont();
//$mpdf->SetHTMLHeader( '头部' );
//$mpdf->SetHTMLFooter( '底部' );
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($strContent);
//$mpdf->Output();
$mpdf->Output('service_report'.$_GET['id'].'.pdf',true);
//$mpdf->Output('tmp.pdf','d');
//$mpdf->Output();
exit;
?>

 