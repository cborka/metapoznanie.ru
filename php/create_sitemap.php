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

$source = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';

$xml=new DomDocument('1.0','utf-8');
$xml->loadXML( $source );

$urlset = $xml->getElementsByTagName("urlset")->item(0);

// Выбор текстов, которые помещаем в карту сайта
// TODO сделать сохранение времени редактирования и поменять здесь дату создания на дату последнего редактирования
$sql = "SELECT text_id, dt, url
			FROM mp_text_status
			  LEFT JOIN mp_texts ON text_rf = text_id 
		WHERE status_rf = 14 
		ORDER BY 1 DESC"
;

if (!($q=mysql_query($sql)))
{
    ero('get_dir: Ошибка: ' . mysql_error() . "\n<br>");
}

for ($c=0; $c<mysql_num_rows($q); $c++)
{
    $f = mysql_fetch_array($q);

    $dt = $f[dt];
    $urls = $f[url];

    $interval = date_diff(date_create($dt), date_create(date("Y-m-d H:i:s")));
    $days = $interval->format('%R%a'); // дней с момента создания

    if ($days < 7) $chfreq = 'daily';
    else if ($days < 30) $chfreq = 'weekly';
    else if ($days < 365) $chfreq = 'monthly';
    else
        $chfreq = 'yearly';

    $ret = '<br><url>\n';

//    echo $urls.'-'.$dt.'-'.$chfreq.'<br>';

    $url = $urlset->appendChild($xml->createElement('url'));

    $loc = $url->appendChild($xml->createElement('loc'));
    $loc->appendChild($xml->createTextNode('http://metapoznanie.ru/'. $urls));

    $lastmod = $url->appendChild($xml->createElement('lastmod'));
    $lastmod->appendChild($xml->createTextNode(substr($dt,0,10)));

    $changefreq = $url->appendChild($xml->createElement('changefreq'));
    $changefreq->appendChild($xml->createTextNode($chfreq));

//    $priority = $url->appendChild($xml->createElement('priority'));
//    $priority->appendChild($xml->createTextNode('0.8'));

}

$xml->formatOutput = true;
$xml->save('../sitemap.xml');

header("Location: /sitemap.xml");

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
