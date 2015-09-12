<?php
include('mpdf.php');

include('sdba/sdba.php');
//類型
$from_type = array(
    'boiler' => "熱水鍋爐",
    'sboiler'=>"蒸氣鍋爐",
    'oboiler'=>"燃油熱水鍋爐",
    'heat' => "熱交換器",
    'chimney' => "煙囪",
    'cpump'=>"熱煤循環泵",
    'calorifier'=>"熱水加熱器",
    'opump'=>"供油泵"
);
				/*
				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('id',$_GET['id']);
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $maintain_froms_list[0]['report_id']);
  				$reports_list = $reports->get();
  				$type=$maintain_froms_list[0]['from_type'];
  				*/
  				$setpershow =3;
  				
  				$reports = Sdba::table('reports');
  				$reports ->where('id', $_GET['id']);
  				$total_reports = $reports->total();
  				$reports_list = $reports->get();
  				//$maintain_froms_list[0]['report_id']
  				
  				$maintain_froms = Sdba::table('maintain_froms');
  				$maintain_froms->where('report_id',$reports_list[0]['id'])->and_where('from_type',$_GET['ft']);;
  				$total_maintain_froms = $maintain_froms->total();
  				$maintain_froms_list = $maintain_froms->get();
  				
  				$type=$maintain_froms_list[0]['from_type'];
  				$page = ceil($total_maintain_froms / $setpershow);
$footers = '
<table width="100%" style="border-top: 1px solid #000000; vertical-align: bottom; font-family:
serif; font-size: 9pt; color: #000;"><tr>
 
<td width="60%" > </td>
<td width="40%" style="text-align: right;">'.$reports_list[0]['name_cn'].'<br>'.$from_type[$type].'系統('.$_GET["p"].' / '.$page.')</td>
</tr></table>
'; 

//$mpdf=new mPDF('+aCJK','A4');
$mpdf=new mPDF('UTF-8','A4','','',6,6,32,32,10,10);
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
$mpdf->SetHTMLFooter($footers);
$stylesheet = file_get_contents('css/bootstrap.css');
//$stylesheet = file_get_contents('../css/style.css');
//$mpdf->watermark_font = 'GB';
//$mpdf->SetWatermarkText('中国水印',0.1);
$url = 'http://uniquecode.net/job/ms/pdf_mfr_all.php?id='.$_GET['id'].'&ft='.$_GET['ft'].'&p='.$_GET['p'];
$strContent = file_get_contents($url);
//print_r($strContent);die;
$mpdf->showWatermarkText = true;
$mpdf->SetAutoFont();

//$mpdf->SetHTMLHeader( '头部' );


$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($strContent);
//$mpdf->Output();
$mpdf->Output('maintenance_reports'.$_GET['id'].'_'.$_GET['ft'].'_'.$_GET['p'].'-'.$page.'.pdf',true);
//$mpdf->Output('tmp.pdf','d');
//$mpdf->Output();
exit;
?>

 