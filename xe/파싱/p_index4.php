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

$url = "http://www.ilbe.com/jjal";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response = curl_exec($ch);
curl_close($ch);
$txt=$response;
$p_list=explode('<ul class="lt">', $txt);
$p_list=explode('</ul>', $p_list[1]);
$p_all=explode('<li>', $p_list[0]);
for($xx=sizeof($p_all);$xx>=1;$xx--){ 
		$p_subject=explode('</li>', $p_all[$xx]);
		$p_link=explode('<a href="',$p_subject[0]);
		$p_link=explode('">',$p_link[1]);
		$save_link=$p_link[0];
		$p_subject=explode('<span class="title" >', $p_subject[0]);
		$p_subject=explode('</span>', $p_subject[1]);
			$p_subject=explode('<em>', $p_subject[0]);
			$p_subject=explode('<img',$p_subject[0]);
			$p_subject=explode('&rsaquo;',$p_subject[0]);
			$save_subject=$p_subject[0];
if ($save_subject) {
	
$url2=$save_link;
$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_COOKIEFILE, "/tmp/NNB");
$response2 = curl_exec($ch2);
curl_close($ch2);
$txt2=$response2;
//$txt2 = iconv("EUC-KR", "UTF-8", $txt2);
$txt2=explode('<div id="copy_layer_1">',$txt2);
$txt2=explode('</div>',$txt2[2]);
$save_contents=$txt2[0];

}

if ($save_subject) {
	 $data=@mysql_fetch_array(mysql_query("select * from xe_documents where tags='$save_link'"));
 if (!$data[document_srl]) {

$obj->title =strip_tags($save_subject);
$obj->content = $save_contents;
$obj->tags = $save_link;
$obj->module_srl = "111";  
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