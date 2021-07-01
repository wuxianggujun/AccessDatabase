# AccessDatabase
向服务区提交社工库信息，本来在JAVA上面写了提交但是因为效率太慢了，要一直挂后台麻烦于是用PHP写了一遍，
QueryApi.php是查询API，
参数方法 post
API参数 qq phone
数据返回类型
    msg | "返回查询成功或查询失败"
    code |0或-1 0是操纵成功，-1操纵失败
    data 返回查询数据 如果数据库没有即Null！
    
 Connection.php
 一个封装的连接数据库类。
 InsertIntoApi.php数据插入数据库
 FileReader.php 读取文件的工具类
 
 ReadFile.php一个在ssh终端运行的脚本，将会自动运行读取txt目录下的TXT文件。并将读取解析的QQ与手机号插入数据库中。
 使用教程 
 建立ssh连接
 nohup php ReadFile.php >/dev/null 2>& 1 &
 让PHP即使在终端连接断开的情况下也能继续运行，直到脚本完成。
 输入完成之后，输入 exit 退出终端。 
 jobs查看工作进程
 ps查看全部进程
 ps -aux |grep 'php'
 这个读取PHP会在工作时打印log，文件在当前目录下的ReadFile.log文件，怕影响效率的可以删除掉写出日志代码。
 
