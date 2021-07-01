<?php
header ('Content-Type:text/html; charset=utf-8;');
include 'Connection.php';
/*
*读取服务器本地数据插入数据库
*
*
*/
ignore_user_abort(true);//后台一直运行
set_time_limit(0);//取消脚本运行时间的超时

$conn=new Connection();
$link=$conn->conn();
if (empty($link)){
    exit();
} 
$array = array('5_6235747856104293012.txt','5_6235747856104293063.txt',
  '5_6235747856104293032.txt','5_6235747856104293064.txt',
  '5_6235747856104293054.txt','5_6235747856104293065.txt',
  '5_6235747856104293055.txt','5_6235747856104293066.txt',
  '5_6235747856104293057.txt','5_6235747856104293068.txt',
  '5_6235747856104293062.txt');

$logfile=fopen('/www/wwwroot/ssdlearn.top/qq/ReadFile.log','w');

foreach ($array as $path) {
   fwrite($logfile,'读取'.$path."\n");
$glob = read_file('/www/wwwroot/ssdlearn.top/qq/txt/'.$path);
foreach ($glob as $line) {
/*while($glob->valid()){
  //当前文本行数
  $line=$glob->current();
  */
  $qq_str = substr(strrchr($line,'-'),1);
  $phone_str = strstr($line,'-',true);
   if (isset($qq_str,$phone_str)) {
     $sql = "INSERT INTO QQ_Table (qq,phone)
          VALUES ($qq_str,$phone_str)";
       $result= $link->query($sql);
       if ($result) {
         fwrite($logfile,'['.date("Y-m-d H:i:s").']'.$qq_str.'success!'."\n");
       } 
      /* 关闭打印报错，只打印成功！
        else {
        fwrite($logfile,$link->error."\n");
       }*/
   } else {
   exit (fwrite($logfile,'插入数据为Null！'."\n"));
   }
 // $glob->next();
  }
}

//关闭流；
fclose($logfile);

//关闭数据库连接；
$conn->close();

function read_file($path){
  if ($handle=fopen($path,'r')) {
     while(!feof($handle)){
       yield trim(fgets($handle));
     }
   fclose($handle);
  }
}


//传递数组然后一个一个游历全部读取
function read_AllFile($arr){
   foreach ($arr as $content) {
      $file= new SplFileObject($content);
      $data= $file->fgets();
        // Display result 
        echo $file->ftell() . "</br>"; 
   }

}

function read_file2arr($path, $count, $offset=0) {
         $arr = array();
    if (! is_readable($path))
        return $arr;
      $fp = new SplFileObject($path, 'r');
      // 定位到指定的行数开始读
     if ($offset)
     $fp->seek($offset);
    $i = 0;
     while (! $fp->eof()) {
     // 必须放在开头
      $i++;
     // 只读 $count 这么多行
     if ($i > $count)
       break;
       $line = $fp->current();
       $line = trim($line);
       $arr[] = $line;
      // 指向下一个，不能少
     $fp->next();
     }
    return $arr;
}


?>