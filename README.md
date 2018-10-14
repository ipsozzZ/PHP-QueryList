# PHP-QueryList
QueryList简洁、优雅的PHP数据采集工具
作为php的数据采集工具
QueryList具有jQuery一样的DOM操作能力、Http网络操作能力、乱码解决能力、内容过滤能力以及可扩展能力；可以轻松实现诸如：模拟登陆、伪造浏览器、HTTP代理等意复杂的网络请求；拥有丰富的插件，支持多线程采集以及使用PhantomJS采集JavaScript动态渲染的页面。
### 一次简单的数据采集示例：
```
<?php
use QL\QueryList;

//采集某页面所有的图片
$data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');
//打印结果
print_r($data->all());

//采集某页面所有的超链接和超链接文本内容
//可以先手动获取要采集的页面源码
$html = file_get_contents('http://cms.querylist.cc/google/list_1.html');
//然后可以把页面源码或者HTML片段传给QueryList
$data = QueryList::html($html)->rules([  //设置采集规则
    // 采集所有a标签的href属性
    'link' => ['a','href'],
    // 采集所有a标签的文本内容
    'text' => ['a','text']
])->query()->getData();
//打印结果
print_r($data->all());
```
### 功能强大的扩展插件和API支持
有使用jquery选择器一样的DOM元素查找操作，还可以带着头信息或者是cookie去采集网页，也可以采用代理，模拟浏览器采集

### 关于代码
这是一个简单源生php的QueryList数据采集案例，采集的是伯乐在线中的职场页面，采集的数据保存到数据库中，当然也提供了将数据写入文件、用curl将将图片下载到本地的的函数
使用到的第三方工具：composer(下载安装QueryList)、git(下载仓库源码)、medoo(高效的轻量级php数据库框架)
