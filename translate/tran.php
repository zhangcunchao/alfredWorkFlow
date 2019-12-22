<?php
//$query = "{query}";

$_app_id = 20191221000368407;
$_scre   = 'EISndCulRNgL3_1XvA8I';

$q    = "{query}";
$salt = time();
$post_data = [
    'from'  => 'auto',
    'to'    => 'auto',
    'q'     => $q,
    'appid' => $_app_id,
    'salt'  => $salt,
    'sign'  => md5($_app_id.$q.$salt.$_scre)
];

$return = [
   'items' => [
      [
      	'titile' => '请检查网络或者百度开发平台',
      	'网址已复制，请打开浏览器粘贴',
      	'arg'    => 'http://fanyi-api.baidu.com/api/trans/product/desktop?req=developer',
      ],
   ],

];


$curl = curl_init();
//设置抓取的url
curl_setopt($curl, CURLOPT_URL, 'http://api.fanyi.baidu.com/api/trans/vip/translate');
//设置头文件的信息作为数据流输出
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_TIMEOUT, 15); 
//设置获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//设置post方式提交
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
//执行命令
$data = curl_exec($curl);
//关闭URL请求
curl_close($curl);

if(!empty($data)){
	$data = json_decode($data,true);
	$rs   = $data['trans_result'] ?? '';
    if(!empty($rs)){
    	$items = [];
    	foreach ($rs as $key => $value) {
    		$items[] = [
    			'title'  => ' '.$value['dst'],
    			'subtitle'  => '选择自动复制'.$value['dst'],
    			'arg'  => $value['dst'],
    		];
    	}
    	$return['items'] = $items;
    }else{
    	$return['items'][0]['title'] = json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}

echo json_encode($return,JSON_UNESCAPED_UNICODE);


