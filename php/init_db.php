<?php 
	global $squery_count;
	global $tstart;

	$squery_count =0;
	$tstart = microtime(true);

// TODO Скрыть данные ввода и не сохранять их в ГИТ

define("DBName","...");
define("HostName","localhost");
define("UserName","...");
define("Password","...");

if (!mysql_connect(HostName,UserName,Password)) {
//if (!mysql_connect("localhost","vh181957_cborka","123123123","vh181957_cborka_mp1")) {
 echo "<br>Ошибка подключения к серверу MySQL";
 exit;
}

if(!mysql_select_db("vh181957_cborka_mp1")) {
    echo 'Ошибка: ' . mysql_error() . "n<br>";
}

// mysql_query('SET names "cp1251"');
mysql_query('SET names "utf8"');


function mysql_query_s($sql)
{
	$GLOBALS['squery_count']++; 
	return mysql_query($sql);
}


function do_update_sql($sql)
{
	$GLOBALS['squery_count']++; 
 	if (mysql_query($sql))
 	{
		return "1";
	}
	else
	{
    	return 'Error (ошибка): do_update_sql: ' . mysql_error() . "\n<br>";
	}	
}
 
function do_sql($sql)
{
	$GLOBALS['squery_count']++; 
	if (!($q=mysql_query($sql)))
	{
    	return 'Error (ошибка): ' . mysql_error() . "\n<br>";
	}

	if (mysql_num_rows($q) == 1)
	{
		$f = mysql_fetch_array($q, MYSQL_NUM);
		return "$f[0]";
	}
	else
	{
		return 'Error (ошибка): do_sql: возвращено '.mysql_num_rows($q).' строк. Не равно 1.';
	}
	
}

function do_sql_a($sql)
{
	$GLOBALS['squery_count']++; 
	if (!($q=mysql_query($sql)))
	{
    	return 'Error (ошибка): ' . mysql_error() . "\n<br>";
	}

	if (mysql_num_rows($q) == 1)
	{
		$f = mysql_fetch_array($q, MYSQL_NUM);
		return $f;
	}
	else
	{
		return 'Error (ошибка): do_sql: возвращено '.mysql_num_rows($q).' строк. Не равно 1.';
	}
	
}

?>