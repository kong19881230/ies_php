<?php
header("Content-Type:text/html; charset=utf-8");

//代码也可以用于统计目录数
//格式化输出目录大小 单位：Bytes，KB，MB，GB
 
function getDirectorySize($path)
{
  $totalsize = 0;
  $totalcount = 0;
  $dircount = 0;
  if ($handle = opendir ($path))
  {
    while (false !== ($file = readdir($handle)))
    {
      $nextpath = $path . '/' . $file;
      if ($file != '.' && $file != '..' && !is_link ($nextpath))
      {
        if (is_dir ($nextpath))
        {
          $dircount++;
          $result = getDirectorySize($nextpath);
          $totalsize += $result['size'];
          $totalcount += $result['count'];
          $dircount += $result['dircount'];
        }
        elseif (is_file ($nextpath))
        {
          $totalsize += filesize ($nextpath);
          $totalcount++;
        }
      }
    }
  }
  closedir ($handle);
  $total['size'] = $totalsize;
  $total['count'] = $totalcount;
  $total['dircount'] = $dircount;
  return $total;
}
 
function sizeFormat($size)
{
	$size += 300000000;
    $sizeStr='';
    if($size<1024)
    {
        return $size." bytes";
    }
    else if($size<(1024*1024))
    {
        $size=round($size/1024,1);
        return $size." KB";
    }
    else if($size<(1024*1024*1024))
    {
        $size=round($size/(1024*1024),1);
        return $size." MB";
    }
    else
    {
        $size=round($size/(1024*1024*1024),1);
        return $size." GB";
    }
 
}
$paths=$_SERVER[PHP_SELF];
//echo $paths;

$path="/home/punx/uniquecode.net/public_html/job/ms";
$ar=getDirectorySize($path);
 
//echo "<h4>路径 : $path</h4>";
echo "現使用大小 : ".sizeFormat($ar['size'])."<br>";
//echo "文件数 : ".$ar['count']."<br>";
//echo "目录术 : ".$ar['dircount']."<br>";
 
//print_r($ar);
?>