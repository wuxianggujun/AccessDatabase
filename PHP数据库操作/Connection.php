<?php 
header ( 'Content-Type:text/html; charset=utf-8;');
/**
 * 封装一个基本连接数据库PHP
 */
class Connection
{
  protected  $link;
  /**
   * 建立服务器的数据库连接
   */
  public function conn()
  {
    $host='ssdlearn.top';
    $user='qqdata';
    $password='3344207732';
    $dbName='qqdata';
    $this->link=new mysqli($host,$user,$password,$dbName);
    if ($this->link->connect_error){
       die("连接失败：".$link->connect_error);
      }else {
      return $this->link;
    }
  }
  
  public function charset($str){
    //设置字符串编码比如 'utf-8'
    $this->link->set_charset($str);
  }
  
 public function close(){
   $this->link ->close();
 }
 
 
  
}
?>