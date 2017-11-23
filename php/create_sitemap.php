<?php
/**
 * Created by PhpStorm.
 * User: bor
 * Date: 23.11.2017
 * Time: 15:16
 *
 * Формирование карты сайта /sitemap.xml
 *
 */


require_once "../php/init_php.php";
require_once "../php/init_db.php";

// TODO При редактировании текстов сделать поля: добавлять ли текст в карту сайта, приоритет, частоту индексации
// TODO сделать поля для тегов description и keywords, хотя в качестве последнего можно использовать теги
//<meta name="description" content="Общая культура приводит к большему взаимопониманию и таким образом делает жизнь более безопасной и комфортной.">
//<meta name="keywords" content="пересказы, популяризация, взаимопонимание, культура">

function format1($text_id, $dt, $url)
{
    return	'<tr>
		<td>&nbsp;'.$text_id. '</td>
		<td>'.$dt. '</td>
		<td>'.$url. '</td>
		</tr> ';
}

$sql = "SELECT text_id, dt, url 
			FROM mp_texts 
		WHERE cat_rf NOT IN (10, 15)
		ORDER BY 1 DESC"
;
echo $sql;


if (!($q=mysql_query($sql)))
{
    ero('get_dir: Ошибка: ' . mysql_error() . "\n<br>");
}
$ret = '<table class="t"><tr>
	<td><b>id</b></td>
	<td><b>Дата</b></td>
	<td><b>Адрес</b></td>
	</tr>';

for ($c=0; $c<mysql_num_rows($q); $c++)
{
    $f = mysql_fetch_array($q);
    $ret = $ret . format1($f[text_id], $f[dt], $f[url]);
}
$ret = $ret ."</table> ";

echo $ret;




/*



$source = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';

$xml=new DomDocument('1.0','utf-8');
$xml->loadXML( $source );

$urlset = $xml->getElementsByTagName("urlset")->item(0);

$url = $urlset->appendChild($xml->createElement('url'));
$loc = $url->appendChild($xml->createElement('loc'));
$loc->appendChild($xml->createTextNode('http://metapoznanie.ru/o-temah-etogo-saita'));
$lastmod = $url->appendChild($xml->createElement('lastmod'));
$lastmod->appendChild($xml->createTextNode('2016-12-13'));
$changefreq = $url->appendChild($xml->createElement('changefreq'));
$changefreq->appendChild($xml->createTextNode('monthly'));
$priority = $url->appendChild($xml->createElement('priority'));
$priority->appendChild($xml->createTextNode('0.8'));

$url = $urlset->appendChild($xml->createElement('url'));
$loc = $url->appendChild($xml->createElement('loc'));
$loc->appendChild($xml->createTextNode('http://metapoznanie.ru/virtualbox--Ubuntu--2'));
$lastmod = $url->appendChild($xml->createElement('lastmod'));
$lastmod->appendChild($xml->createTextNode('2017-01-10'));
$changefreq = $url->appendChild($xml->createElement('changefreq'));
$changefreq->appendChild($xml->createTextNode('monthly'));
$priority = $url->appendChild($xml->createElement('priority'));
$priority->appendChild($xml->createTextNode('0.5'));

$xml->formatOutput = true;
$xml->save('../sitemap.xml');




header("Location: /sitemap.xml");

*/
