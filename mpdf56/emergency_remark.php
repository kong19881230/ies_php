<?php
include('mpdf.php');

include('sdba/sdba.php');
//類型


//$mpdf=new mPDF('+aCJK','A4');
$mpdf=new mPDF('UTF-8','A4','','',8,8,32,32);
$mpdf->useAdobeCJK = true;
$mpdf->SetAutoFont(AUTOFONT_ALL);
$mpdf->SetDisplayMode('fullpage');

$header = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family:
serif; font-size: 9pt; color: #000088;"><tr>
 
<td width="60%" ><img src="img/ies_logo.png" width="380px" /></td>
<td width="40%" style="text-align: right;"><span style="font-weight: bold;"> </span></td>
</tr></table>
';

$mpdf->SetHTMLHeader($header);
$stylesheet = file_get_contents('css/bootstrap.css');
//$stylesheet = file_get_contents('../css/style.css');
//$mpdf->watermark_font = 'GB';
//$mpdf->SetWatermarkText('中国水印',0.1);
$url = 'http://uniquecode.net/job/ms/pdf_erm.php?id='.$_GET['id'];
$strContent = file_get_contents($url);
//print_r($strContent);die;
$mpdf->showWatermarkText = true;
$mpdf->SetAutoFont();
//$mpdf->SetHTMLHeader( '头部' );
//$mpdf->SetHTMLFooter( '底部' );
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($strContent);
//$mpdf->Output();
$mpdf->Output('emergency_remark'.$_GET['id'].'.pdf',true);
//$mpdf->Output('tmp.pdf','d');
//$mpdf->Output();
exit;
?>

 