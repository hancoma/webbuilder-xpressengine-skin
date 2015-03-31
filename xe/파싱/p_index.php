<?php
if(!defined("__ZBXE__")) exit();
define('__ZBXE__', true);
require_once './modules/document/document.class.php';
require_once './modules/document/document.model.php'; 
require_once './modules/document/document.controller.php';

$oDocumentController = &getController('document');
include "db_config.php";
include 'snoopy/Snoopy.class.php'; 
$s=new snoopy; 
$url="http://www.bobaedream.co.kr/list?code=best"; 
$s->fetch($url); 
$txt=$s->results; 

$p_list=explode('<td class="pl14">',$txt);
 for($xx=sizeof($p_list);$xx>=1;$xx--){ 
$p_list2=explode('</a>',$p_list[$xx]); 
$p_list3=explode('itemprop="name">',$p_list2[0]); 

$subject=strip_tags($p_list2[0]);
$link=explode('href="',$p_list2[0]); 
$p_list4=explode('"',$link[1]);
$p_link=$p_list4[0];


$s2=new snoopy; 
$url2="http://www.bobaedream.co.kr".$p_link; 
$s2->fetch($url2); 
$txt2=$s2->results; 
$contents=explode('<div class="bodyCont">',$txt2); 
$contents=explode('</div>',$contents[1]); 
$contents2=str_replace('alt="클릭하시면 원본 이미지를 보실 수 있습니다."', '', $contents[0]);
$contents2=str_replace('rel="xe_gallery"', '', $contents[0]);

$images=explode('src="',$contents2); 

 for($ic=1;$ic<=sizeof($images);$ic++){ 
 
$images_name=explode('"',$images[$ic]); 
$img_url=$images_name[0];
$img_name=basename($images_name[0]);
$images_ext=explode('.',$img_name); 
if (strstr('[gif][jpg][png]',$images_ext[1]))
{

$fp = fopen("images/".$img_name, "w");
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $img_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)");
curl_setopt($ch, CURLOPT_FILE, $fp);
 
curl_exec($ch);
 
fclose($fp);
curl_close($ch);
$chg_url="http://rforun.cafe24.com/images/".$img_name;
$contents2=str_replace($img_url, $chg_url, $contents2);
}
 }

 $data=mysql_fetch_array(mysql_query("select * from xe_documents where tags like '%".$url2."%' and module_srl=109 "));

 if (!$data[document_srl]) {
echo $data[document_srl];
$obj->title =strip_tags($subject);
$obj->content = $contents2;
$obj->tags = $url2;
$obj->module_srl = "109";  
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
?>