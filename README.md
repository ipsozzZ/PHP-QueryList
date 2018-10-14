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
