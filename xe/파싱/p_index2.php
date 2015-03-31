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

$url = "http://www.todayhumor.co.kr/board/list.php?table=bestofbest";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response = curl_exec($ch);
curl_close($ch);
$txt=$response;
$txt=str_replace(" onMouseOver=this.style.backgroundColor='#DEF2FF' ", "", $txt);
$txt=str_replace("onMouseOut=this.style.backgroundColor=''", "", $txt);

$p_all=explode("<tr class = 'list_border_bottom'>",$txt);
echo sizeof($p_all);
//$p_list=explode('target="_top">', $p_all[1]);

for($xx=sizeof($p_all);$xx>=0;$xx--){ 
	$p_subject=explode("</tr>", $p_all[$xx]);
	$p_subject=explode("class='table_list_subject'>", $p_subject[0]);
	$p_link=explode('<a href="', $p_subject[1]);
	$p_link=explode('" target="_top">', $p_link[1]);

	$p_subject=explode("</td>", $p_subject[1]);
	$p_subject=explode("</a>", $p_subject[0]);
		$save_subject=strip_tags($p_subject[0]); // 제목 추출 
		$p_link=$p_link[0];

		$p_num=explode("&s_no=", $p_link);
		$p_num=explode('&', $p_num[1]);
		$p_num=$p_num[0];


// 		본문 가져오기 
		$url="http://www.todayhumor.co.kr".$p_link;
		$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, $url);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response2 = curl_exec($ch2);
curl_close($ch2);
$txt2=$response2;
$p_contents=explode("<!--EAP_CONTENT-->", $txt2);
$p_contents=explode("<!--/EAP_CONTENT-->", $p_contents[1]);
$save_contents=$p_contents[0]; // 게시물 추출 완료



if ($save_subject) {
	 $data=@mysql_fetch_array(mysql_query("select * from xe_documents where tags='$p_num' and module_srl='107' "));
 if (!$data[document_srl]) {

$obj->title =strip_tags($save_subject);
$obj->content = $save_contents;
$obj->tags = $p_num;
$obj->module_srl = "107";  
$obj->member_srl = "4";
$obj->user_id =  "관리자";
$obj->nick_name =  "관리자";
$obj->allow_comment = 'Y';
$obj->extra_vars1=$url;
$document_srl = getNextSequence();
$obj->document_srl = $document_srl;
$output=$oDocumentController->insertDocument($obj,true);
}
}
}

 







?>