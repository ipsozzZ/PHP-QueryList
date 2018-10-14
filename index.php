<?php
// 如果你使用php的依赖安装。可以使用以下方法自动载入
require 'vendor/autoload.php';
use QL\QueryList;
 
// 或者将你下载的medoo文件拷贝到你相应的目录，然后载入即可
use Medoo\medoo;
 
// 初始化配置
$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'reptilian',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'gqm1975386453',
    'charset' => 'utf8'
]);
 
// 插入数据示例
$database->insert('account', [
    'user_name' => 'foo',
    'email' => 'foo@bar.com',
    'age' => 25,
    'lang' => ['en', 'fr', 'jp', 'cn']
]);
$data = $database->query("select version()")->fetchAll();
var_dump($data);