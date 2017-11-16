<?php 

require_once "../php/init_php.php";
require_once "../php/init_db.php";

//
// Получить три последних записи
//
function get_last3t()
{
	$sql = "
		SELECT b.dt, header, m.logname, url 
			FROM  mp_texts b
				LEFT JOIN mp_users m ON m.user_id = b.user_rf
		WHERE text_id > 1
		  AND b.cat_rf != 2
		  AND b.cat_rf != 9
		ORDER BY  b.dt DESC
		LIMIT 0 , 3
	";

	if (!($q=mysql_query($sql))) 
	{
    	ero('get_last3t: Ошибка: ' . mysql_error() . "\n<br>");
	}

	$ret = '';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . last3_format($f[dt], $f[logname], $f[url], $f[header]);
	}
  
	return $ret;
}

//
// Получить три последние комментария
//
function get_last3c()
{
	$sql = "
		SELECT c.dt, b.header, m.logname, b.url 
			FROM (( mp_comms c
				LEFT JOIN mp_users m ON m.user_id = c.user_rf)
				LEFT JOIN mp_texts b ON b.text_id = c.text_rf)
		ORDER BY c.dt DESC 
		LIMIT 0 , 3
	";

	if (!($q=mysql_query($sql))) 
	{
    	ero('get_last3c: Ошибка: ' . mysql_error() . "\n<br>");
	}

	$ret = '';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . last3_format($f[dt], $f[logname], $f[url], $f[header]);
	}
  
	return 	$ret;
}

function last3_format($dt, $logname, $url, $header)
{
	if ($logname == 'Admin')
	  $ncolor = 'red';
	else
	  $ncolor = 'green';
		
	$ret = substr($dt, 2, 14).' '.
		'<span class="'.$ncolor.'">'.$logname.'</span>'.
		' <a href="/'.$url.'">'.$header.'</a><br/>';
		
	return $ret;
}


//
// Получить случайный твит (короткий текст)
//
function get_tvit()
{
	$cnt = do_sql("SELECT max(tvit_id) FROM mp_tvits");
	if (substr($cnt, 0, 5) == "Error")
		$cnt = 1;
	
	$tid = rand(1, $cnt);

	$tvit = do_sql("SELECT tvit	FROM mp_tvits WHERE tvit_id = ". $tid);
	if (substr($tvit, 0, 5) == "Error")
		$tvit = 'Кто ищет не всегда находит, а кто не ищет - никогда';
		
	return $tvit;		
}

//
// Получить события СЕГОДНЯ
//
function get_today()
{
	$td = do_sql("SELECT DATE_FORMAT(CURDATE( ), '%m-%d')");
	if (substr($td, 0, 5) == "Error")
		$td = "";
	

	$today = do_sql("SELECT `about` FROM `mp_texts` WHERE `header` = 'День ". $td. "'");
	if (substr($today, 0, 5) == "Error")
		$today = "";

	if ($today <> "")
		$today = 
		'<div class="divtxtb"><span id="today">'.$today.'</span></div>';
		
	return $today;		
}



?>