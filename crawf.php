<?php
require "vendor/autoload.php";
use QL\QueryList;
use Medoo\medoo;
use QL\Ext\AbsoluteUrl;
use QL\Ext\CurlMulti;

/**
 * 源生php代码编写数据采集器
 * @author ipso
 */

/* 连接数据库 */
global $database;
// global $ql;
$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'reptilian',
    'server'        => 'localhost',
    'username'      => 'root',
    'password'      => 'gqm1975386453',
    'charset'       => 'utf8'
]);

/**
 *主函数，没有使用任何php框架用源生php代码编写,获取伯乐在线 IT职场前40页数据 
 *@$url      需要爬取的网页
 *@list_rule 定义采集规则
 */
function index(){
    echo "爬虫开始……\n";
    
    /* 开始循环20次,获取网页前20页数据 */
    for($i = 31; $i < 35; $i++){
        $url  = "http://blog.jobbole.com/category/career/page/{$i}";
        echo "url为:{$url}\n"; 
        $list_rule = [
            'title'      => ['#archive .archive-title','text'],
            'detail_url' => ['#archive .post-thumb > a:first-child','href'],
            'intro'      => ['#archive .excerpt > p:first-child','text'],
            'thumb'      => ['#archive .post-thumb > a > img','src'],
            'ctime'      => ['#archive .post-meta > p:first-child','text','-a'],
        ];
        $list_data = crawl_data($url,$list_rule);
        foreach($list_data as $k => $v){
            echo "开始获取《{$list_data[$k]['title']}》的详情……\n";
            $detail_rule  = [
                'content' => ['.entry','html']
            ];
            /* 抓取文章详情页带格式 */
            $detail_data  = crawl_data($list_data[$k]['detail_url'],$detail_rule);
            /* 整合数据 */
            $db_data['article_title']   = $list_data[$k]['title'];
            $db_data['article_content'] = $detail_data[0]['content'];
            $db_data['article_instro']  = $list_data[$k]['intro'];
            $db_data['article_thumb']   = $list_data[$k]['thumb'];
            $db_data['article_ctime']   = get_ctime_by_regular($list_data[$k]['ctime']);
            $db_data['article_views']   = 0;
            $db_data['article_uid']     = choose_a_uid();
            /* 写入数据库 */
            echo "开始写入数据库……\n";
            $result = put_data_to_sql($db_data);
            if($result['code'] == 200){
                echo $result['msg'];
            }else{
                echo $result['msg'];
            }
        }
    }
    echo "爬取数据结束……";
    exit;
}

/* 调用index()方法开始抓取内容 */
index();

/****** 函数实现 ******/

/**
 * 将文章缩略图下载到本地
 * @param  $url     图片远程链接地址
 * @param  $picPath 放置图片的本地路径、
 * @return string
 */
function uploadImg($url,$picPath="images")
{
    /* 通过curl获取到地址为$url的图片文件 */
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
    $file = curl_exec($ch);
    curl_close($ch);
    /* 将文件写到本地的images目录下 */
    if(is_dir($picPath) == false){
        mkdir($picPath);
    }
    $fileName = pathinfo($url,PATHINFO_BASENAME);
    $resource = fopen($picPath.'/'.$fileName,'a');
    fwrite($resource,$file);
    fclose($resource);
    return "ok";
}

/**
 * 采集不需要登录就能得到的数据
 * QueryList     爬取网页数据
 * @param  $url  要爬取的网页
 * @param  $rule 爬取规则
 * @return array
 */
function crawl_data($url,$rule){
    $data = QueryList::Query($url,$rule)->data;
    return $data;
}

/**
 * 提取字符串中的时间字符字串(不推荐使用)
 * @param  $str   包含时间字串的字符串,在时间子串之前字符由空格、换行、标点符号和大小写字母组成不包含除时间外的任何数字字符
 * @return string
 */
function get_ctime($str){
    $ctime = '';
    $Tstr  = $str;
    $pos   = 0;
    for($i = 0; $i < strlen($str); $i++){
        if(substr($str,$i,1) >= '0' && substr($str,$i,1) <= '9'){
            $pos = $i;
            break;
        }
    }
    $ctime = substr($Tstr,$pos,10);
    return $ctime;
}

/**
 * 提取字符串中的时间字符串（使用正则表达式实现）(推荐使用)
 * @param  $str    包含时间字串的字符串
 * @return string
 */
function get_ctime_by_regular($str){
    $result = preg_match('/\d{4}\/\d{1,2}\/\d{1,2}/',$str,$new_ctime);
    if($result){
        return $new_ctime[0];
    }else{
        return "2018/10/07";
    }
}

/**
 * 将数据存入数据库时使用
 * 随机为文章表分配用户id
 * @$GLOBALS['database'] 全局变量database 数据库连接信息
 * @return  int          数据库查询结果
 */
function choose_a_uid(){
    $datas        = $GLOBALS['database']->select('user',['user_id']);
    $max_key      = sizeof($datas) - 1;
    $min_key      = 0;
    $key          = rand($min_key,$max_key);
    $rand_user_id = $datas[$key]['user_id'];
    return $rand_user_id;
}

/**
 * 将爬取的数据写入数据库，
 * 在这里使用的数据库工具是Medoo它的官方文档有个错误，插入数据库insert返回的是一个对象，
 * 返回的不是操作id,所以需要用id这个方法获取一下操作id,再获取错误信息
 * @param   $data   需要写入数据库的数据
 * @param   $res_id 获取数据库的操作id
 * @return  array[code：状态码  msg:返回信息]
 */
function put_data_to_sql($data){
    /* $GLOBALS[''database] 全局变量*/
    /* 将文件写入数据库 */
    $GLOBALS['database']->insert('article',$data);
    $res_id = $GLOBALS['database']->id();
    if($res_id){
        return [
            'code' => 200,
            'msg'  => "《{$data['article_title']}》写入数据库成功\n",
        ];
    }else{
        $res = $GLOBALS['database']->error();   // 获取错误信息
        return [
            'code' => 400,
            'msg'  => "写入数据库失败\n".$res[2],
        ];
    }
}

/**
 * 将采集到的数据写入日志文件
 * @param  $data  采集到的数组数据
 * @return string
 */
function put_data_to_file($data){
    /* 判断D盘下是否存在目录myCrawl，不存在就新建一个目录 */
    if(!is_dir('D:/myCrawl')){
        mkdir('D:/myCrawl');
    }
    $file_path = 'D:/myCrawl/data.log'; // 文件路径包含文件名
    /* foreach循环将数组数据存入目录 */
    $file      = fopen($file_path,'w');
    foreach ($data as $key => $value) {
        fwrite($file_path,$value);
    }
    // chmod($filename,$mode) // 更改文件权限
    return "ok";
}