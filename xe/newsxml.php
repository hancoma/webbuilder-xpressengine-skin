<?
header("Content-Type: text/xml; charset=utf-8");
 include "db_config.php"; 
echo '<?xml version="1.0" encoding="utf-8"?>';
$data=@mysql_fetch_array(mysql_query("select * from xe_documents  where document_srl=$srl_no"));
echo '<!DOCTYPE NEWS PUBLIC "-//view.daum.net//DTD NewsML 1.1//EN" "http://cp.news.search.daum.net/resources/dtd/newsxml-1.1.dtd">';
?>
<NEWS ver="1.1" act="C" orgid="182629">

<DATETIME><?=$data[regdate]?></DATETIME>
<WRITER_LIST>
<WRITER>
<NAME><![CDATA[<?=$data[nick_name]?>]]></NAME>
<EMAIL><?=$data[email_address]?></EMAIL>
</WRITER>
</WRITER_LIST>
<CATEGORY_LIST>
<CODE>soccer</CODE>
</CATEGORY_LIST>
<TITLE><![CDATA[<?=$data[title]?>]]></TITLE>
<SUB_TITLE><![CDATA[<?=$data[title]?>]]></SUB_TITLE>
<TEXT><![CDATA[<?=$data[content]?>]]>
</TEXT>
<IMG_LIST>
<IMG>
<URL><![CDATA[http://이미지가/있는/서버/주소/1342968.jpg]]></URL>
<DESC><![CDATA[이미지 설명]]></DESC>
</IMG>
<IMG>
<URL><![CDATA[http://이미지가/있는/서버/주소/1342968.jpg]]></URL>
<DESC><![CDATA[이미지 설명]]></DESC>
</IMG>
</IMG_LIST>
<VOD_LIST>
<VOD><![CDATA[http://동영상이/있는/서버/주소/20070201_13.wmv]]></VOD>
</VOD_LIST>
<EXT>
<OUTLINK><![CDATA[http://www.esportsi.com/xe/<?=$srl_no?>]]></OUTLINK>
<COPYRIGHT><![CDATA[기사의 저작권은 (주)일간연예스포츠의 소유이며 이 기사는 저작권법의 보호를 받습니다.]]></COPYRIGHT>
<RELATED_NEWS_LIST>
<RELATED_NEWS>
<SUBJECT><![CDATA[관련기사제목]]></SUBJECT>
<RELATED_NEWS_URL><![CDATA[http://해당/기사/언론사측/주소/]]></RELATED_NEWS_URL>
</RELATED_NEWS>
<RELATED_NEWS>
<SUBJECT><![CDATA[관련기사제목]]></SUBJECT>
<RELATED_NEWS_URL><![CDATA[http://해당/기사/언론사측/주소/]]></RELATED_NEWS_URL>
</RELATED_NEWS>
</RELATED_NEWS_LIST>
</EXT>
</NEWS>