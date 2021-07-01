<?php
header('Content-type:text/json');
header('Access-Control-Allow-Origin:*');//指定允许其他域名访问
include 'Connection.php';

/*
*@param qq 要插入的QQ号
*@param phone 要插入的手机号
*将数据插入数据库API，提高给Java客户端使用
*
*/
$conn=new Connection();
$link=$conn->conn();
if (empty($link)){
    exit();
} 
$output = array();
$qq=$_POST['qq'];
$phone=$_POST['phone'];

if (isset($qq,$phone)) {
 $sql = "INSERT INTO QQ_Table (qq,phone)
     VALUES ($qq,$phone)";
  $result= $link->query($sql);
  if ($result) {
    $output = array('msg' =>'数据插入成功！','code'=>0,'data'=> array('qq' =>$qq,'phone'=>$phone));
    exit(json_encode($output));
  } else {
    $output = array('msg' =>$link->error,'code'=>$link->errno,'data'=>null);
    exit(json_encode($output));
  }
       
}else {
  $output = array('msg' =>'数据为Null！','code'=> -1,'data'=>null);
  exit(json_encode($output));
}

$conn->close();
?>