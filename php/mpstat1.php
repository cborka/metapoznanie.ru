<?php

require_once "init_php.php";
require_once "init_db.php";

function get_dayly_stat()
{
	
	$hits = array();
	$hosts = array();
	
	$sql = "
		SELECT FROM_DAYS(TO_DAYS(dtb)) AS d, count(*) AS n 
			FROM mpstat
			GROUP BY TO_DAYS(dtb) 
		UNION ALL
		SELECT 'ИТОГО' AS d, count(*) AS n 
			FROM mpstat
		ORDER BY 1 desc
		LIMIT 0, 35
	";
	if (!($q=mysql_query($sql))) 
	{
    	echo 'get_dayly_stat: Ошибка: ' . mysql_error() . "\n<br>";
	}
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$hits[$f[d]] = $f[n];
//		echo $f[d]." = ". $f[n]."<br/>";
	}

	$sql = "
		SELECT FROM_DAYS(TO_DAYS(dtb)) AS d, count(distinct ip) AS n 
			FROM mpstat
			GROUP BY TO_DAYS(dtb) 
		UNION ALL
		SELECT 'ИТОГО' AS d, count(distinct ip) AS n 
			FROM mpstat
		ORDER BY 1 DESC
		LIMIT 0, 35
	";
	if (!($q=mysql_query($sql))) 
	{
    	echo 'get_dayly_stat: Ошибка: ' . mysql_error() . "\n<br>";
	}
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$hosts[$f[d]] = $f[n];
	}

	$ret = '<br/><br/>Статистика по дням<br/><table border="1"><tr><td><b>ДАТА</b></td><td><b>Hits</b></td><td><b>Hosts</b></td></tr>';
	foreach ($hits as $key => $avalue) {
		if ($key == 'ИТОГО')
		$ret = $ret . '<tr><td><b>'. $key.'</b></td><td><b>'.$avalue. '</b></td><td><b>'.$hosts[$key].'</b></td></tr> ';
		else
		$ret = $ret . '<tr><td>'. $key.'</td><td>'.$avalue. '</td><td>'.$hosts[$key].'</td></tr> ';
	}
	$ret = $ret ."</table> ";
 
	return $ret;
}

function get_ip_stat() //=========================================================
{
	$hits = array();
	
	$sql = "
		SELECT ip AS d, count(*) AS n 
			FROM mpstat
			GROUP BY ip 
		UNION ALL
		SELECT 'ИТОГО' AS d, count(*) AS n 
			FROM mpstat
		ORDER BY 2 DESC, 1
		LIMIT 0, 30
	";
	if (!($q=mysql_query($sql))) 
	{
    	echo 'get_ip_stat: Ошибка: ' . mysql_error() . "\n<br>";
	}
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$hits[$f[d]] = $f[n];
	}


	$ret = '<br/><br/>Статистика по IP<br/><table border="1"><tr><td><b>IP</b></td><td><b>Hits</b></td></tr>';
	foreach ($hits as $key => $avalue) {
		if ($key == 'ИТОГО')
		$ret = $ret . '<tr><td><b>'. $key.'</b></td><td><b>'.$avalue. '</b></td></tr> ';
		else
		$ret = $ret . '<tr><td>'. $key.'</td><td>'.$avalue. '</td></tr> ';
	}
	$ret = $ret ."</table> ";
 
	return $ret;
}


function get_page_stat() //=========================================================
{
	$hits = array();
	
	$sql = "
		SELECT cname AS d, count(*) AS n 
			FROM mpstat
			GROUP BY cname 
		UNION ALL
		SELECT 'ИТОГО' AS d, count(*) AS n 
			FROM mpstat
		ORDER BY 2 DESC, 1
		LIMIT 0, 30
	";
	if (!($q=mysql_query($sql))) 
	{
    	echo 'get_page_stat: Ошибка: ' . mysql_error() . "\n<br>";
	}
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$hits[$f[d]] = $f[n];
	}


	$ret = '<br/><br/>Статистика по страницам (счётчикам)<br/><table border="1"><tr><td><b>Страница</b></td><td><b>Hits</b></td></tr>';
	foreach ($hits as $key => $avalue) {
		if ($key == 'ИТОГО')
		$ret = $ret . '<tr><td><b>'. $key.'</b></td><td><b>'.$avalue. '</b></td></tr> ';
		else
		$ret = $ret . '<tr><td>'. $key.'</td><td>'.$avalue. '</td></tr> ';
	}
	$ret = $ret ."</table> ";
 
	return $ret;
}
//=========================================================
function get_last_stat() 
{
	$sql = "
		SELECT ip, dtb, dte, cname  
			FROM mpstat
		ORDER BY 2 DESC
		LIMIT 0 , 70
	";
	if (!($q=mysql_query($sql))) 
	{
    	echo 'get_last_stat: Ошибка: ' . mysql_error() . "\n<br>";
	}
	$ret = 'Статистика последняя<br/><table border="1"><tr><td><b>Страница</b></td><td><b>Страница</b></td><td><b>Страница</b></td><td><b>Hits</b></td></tr>';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);

		$ret = $ret . '<tr><td>'. $f[ip].'</td><td>'.$f[dtb]. '</td><td>'.$f[dte]. '</td><td>>'.$f[cname]. '</td></tr> ';
	}
	$ret = $ret ."</table> ";
 
	return $ret;
}

echo '<a href="/">[ На главную ]</a><br><br/>';

echo get_last_stat();

$s = get_dayly_stat();
echo $s;

echo get_page_stat();

$s = get_ip_stat();
echo $s;

?>