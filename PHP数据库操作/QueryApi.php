<?php
header('Content-type:text/json');
header('Access-Control-Allow-Origin:*');//指定允许其他域名访问
include 'Connection.php';

$conn=new Connection();
$link=$conn->conn();
if (empty($link)){
    exit();
} 
$output = array();
$qq=$_POST['qq'];
$phone=$_POST['phone'];
$sql = null;

if (empty($sql) && isset($qq)) {
    $sql = "SELECT * FROM QQ_Table WHERE qq = '{$qq}'";
}else {
    $sql = "SELECT * FROM QQ_Table WHERE phone = '{$phone}'";
}
if (isset($sql)) {
  
  $result = $link->query($sql);
  
  if ($result) {
    
  if ($row = $result->fetch_array()){
     $output = array('msg' =>'查询成功!','code'=>0,'data'=>array('qq' =>$row['qq'],'phone'=>$row['phone']));
     exit(json_encode($output));
  }else {
     $output = array('msg' =>'查询失败!','code'=>-1,'data'=>null);
     exit (json_encode($output));
  }
  }else {
       $output = array('msg' =>'查询失败!','code'=>-1,'data'=>null);
      exit(json_encode($output));
  }
}

$conn->close();
?>