<?php

$headers = array(
    "User-Agent: Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53",
    "Cookie: NNB=;"
);
include "db_config.php";
if(!defined("__ZBXE__")) exit();
define('__ZBXE__', true);
require_once './modules/document/document.class.php';
require_once './modules/document/document.model.php'; 
require_once './modules/document/document.controller.php';

$oDocumentController = &getController('document');

$url = "http://m.slrclub.com/l/free";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response = curl_exec($ch);
curl_close($ch);
$txt=$response;
$txt = iconv("EUC-KR", "UTF-8", $txt);
//echo $txt;
$txt=explode('<ul class="list">', $txt);
$txt=explode("</ul>", $txt[2]);
//echo $txt[0];
$p_all=explode("<li>",$txt[0]);
//echo sizeof($p_all);

for($xx=sizeof($p_all);$xx>=1;$xx--){
		$p_link=explode( "</li>",$p_all[$xx]);
	
		$p_subject=explode('<div class="subject">', $p_link[0]);
		$p_subject=explode('</div>', $p_subject[1]);
		$p_link=explode('<a href="', $p_subject[0]);
		$p_link=explode('">', $p_link[1]);
		$p_subject=explode('</a>', $p_subject[0]);
$save_subject=strip_tags($p_subject[0]);
		// 링크 추출 
		$p_link=$p_link[0];

		// 		본문 가져오기 
		if ($save_subject) {
		$url2="http://m.slrclub.com".$p_link;
		
		$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response2 = curl_exec($ch2);
curl_close($ch2);
$txt2=$response2;
$txt2 = iconv("EUC-KR", "UTF-8", $txt2);

$p_contents=explode('<div class="contents">', $txt2);
$p_contents=explode("</div>", $p_contents[1]);
$save_contents=$p_contents[0]; // 게시물 추출 완료
}

if ($save_subject) {
	 $data=@mysql_fetch_array(mysql_query("select * from xe_documents where tags='$p_link'"));
 if (!$data[document_srl]) {

$obj->title =strip_tags($save_subject);
$obj->content = $save_contents;
$obj->tags = $p_link;
$obj->module_srl = "113";  
$obj->member_srl = "4";
$obj->user_id =  "관리자";
$obj->nick_name =  "관리자";
$obj->allow_comment = 'Y';
$obj->extra_vars1=$url2;
$document_srl = getNextSequence();
$obj->document_srl = $document_srl;
$output=$oDocumentController->insertDocument($obj,true);
}
}

}


?>