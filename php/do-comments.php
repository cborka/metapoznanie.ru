<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";

//
// Получить все ид текстов, удовлетворяющих заданным условиям
//
function get_comm_ids() 
{
	$tid = input_filter($_POST['tid']);

	$sql = "
		SELECT comm_id FROM mp_comms
		WHERE text_rf = ".$tid.
		" ORDER BY dt DESC 
		LIMIT 0, 333"
	;
	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_comm_ids: Ошибка: ' . mysql_error() . "\n<br>");
	}
	$ret = '';
	for ($c=1; $c<mysql_num_rows($q); $c++) // с 1 начинаю, чтобы уменьшить кол-во циклов на 1
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . $f[comm_id].",";
	}
	$f = mysql_fetch_array($q); // Последний цикл - не ставлю ","
	$ret = $ret . $f[comm_id];
  
	return $ret;
}


//
// Вывод комментариев
//
function show_comms($ids) 
{
	if (trim($ids) == '') $ids = '0';
	
	$sql = "
		SELECT c.comm_id, c.comm_rf, c.user_rf, m.logname, c.dt, c.text AS txt 
			FROM ( mp_comms c
				LEFT JOIN mp_users m ON m.user_id = c.user_rf)
		WHERE c.comm_id IN (".$ids.") 	
		ORDER BY dt DESC 
		LIMIT 0 , 10
	";
//	echo $sql."<br/>";
	if (!($q=mysql_query($sql))) 
	{
    	ero('show_comms: Ошибка: ' . mysql_error() . "\n<br>".$sql);
	}

	$ret = '';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		
		$ret = $ret . formatcomm1($f[comm_id], $f[logname], $f[dt], $f[txt]);
	}
//	$ret = $ret ."</table> ";
  
	return $ret;
	
}

//
// Форматировать
//
function formatcomm1($comm_id, $nik, $dt,  $txt)
{
	global $ss_nick;
	
//	$ret =	' $ss_nick='.$ss_nick.', $nik='.$nik.' 

	$btn = '
		<div  class="btntxt">
			<form name="comm'.$comm_id.'" action="../mpcms/do-comments.php" method="post"">
				
				<input class="til" type="text" hidden name="tid" value="'.$comm_id.'" />';
				
	if (($ss_nick == 'Admin') or ($ss_nick == $nik))
//		$btn = $btn.'<input class="aslink9" type=submit value="Изменить" title="Изменить"> ';
		$btn = $btn.'<input class="btn9" type="button" id="edcomm'.$comm_id.'" value="Изменить" title="Изменить" onclick="ed_comm('.$comm_id.')" />';
//		$ret = $ret.'<input class="bred" type=submit value="" title="Изменить"> ';
				
	if ($ss_nick == 'Admin')
			$btn = $btn.'<input class="btn9" type="button" id="delcomm'.$comm_id.'" value="Удалить" title="Удалить" onclick="del_comm('.$comm_id.')" />';
			
	$btn = $btn.'</form><div id="ercomm'.$comm_id.'"></div></div>';

	$ft3 = '<div class="fttxt">&nbsp;</div>';
	$ft =' |
	<input class="btn" title="Нравится" type="button" value=" + " onclick="lkc('.$comm_id.',1)" />
    <input class="btn" title="Не нравится" type="button" value="- " onclick="lkc('.$comm_id.',-1)" />
    <input class="btn" title="Всё равно" type="button" value="= " onclick="lkc('.$comm_id.',0)" />
    <span id=likec'.$comm_id.' title="Оценка">'.likes_comm($comm_id).'</span> |  
    ';
			
	$hd = '	<div  class="hdtxt">'
			.$comm_id.' | '.f46($nik, "Автор").' | '.f46($dt, "Дата").$ft.$btn. 
			'</div>';
/*
	$ret =	'
		<div  class="divtxt">'.
		$btn.$hd.
		'<br/>'.$txt.
		$ft.
		'</div>';

	$ret =	'
		<div  class="divcomm">'.
		' <table class="ed"> 	<col width="125px">
		<tr><td>'. 
		$hd.
		'</td><td>'.
		$txt.
    	'</td></tr>'.
		'</div>';
*/
	$ret =	'
		<div  class="divcomm">'.
		$hd.
		'<span id="ct'.$comm_id.'">'.$txt.'</span>'.
		$ft2.
		'</div>';

	$ret =	'<div class="bordered">'.
		$hd.
		'<div class="divcomm" id="ct'.$comm_id.'">'.
		$txt.
		'</div></div><br/>';

 
	return $ret;	
}
function f46($t, $c)
{
	return '<span class="hdtxt2" title="'.$c.'">'.$t.'</span>';
	
}

//
// Оценка комментария
//
function likes_comm($txt_id)
{
   	// Подсчитываю оценку
	$sql = "
		SELECT SUM(danet) 
			FROM mp_comm_likes
			WHERE comm_rf = ".$txt_id
	;

	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error") 
	{
		ero($sm.$sql);
		return "0";
	}
	return $sm;
}


//
// Удалить комментарий с заданным ид
//
function delete_comm($comm_id) 
{
	global $ss_nick;
	
	if ($ss_nick != 'Admin')
	{
		ero('delete_comm: Нет прав на удаление комментария.');
		return "0";
	}

	// 
	$sql = "SELECT text_rf FROM mp_comms WHERE comm_id = ".$comm_id;
	$txt_id = do_sql($sql);
	if (substr($txt_id, 0, 5) == "Error")
	{
		ero($txt_id.$sql);
		return "0";
	}

	// Удаляю комментарий
	$res = do_update_sql("DELETE FROM mp_comms WHERE comm_id = ".$comm_id);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
	
	// Обновляю дату последнего комментария в таблице текстов

	$sql = "SELECT MAX(dt) FROM mp_comms WHERE text_rf = ".$txt_id;
	$dt = do_sql($sql);
	if (substr($dt, 0, 5) == "Error")
	{
		ero($dt.$sql);
		return "0";
	}
	
	if ($dt == '')
	{ 
	 $res = do_update_sql("UPDATE mp_texts SET dtm = dt WHERE text_id = ".$txt_id); 
	}
	else
	{ 
	 $res = do_update_sql("UPDATE mp_texts SET dtm = '".$dt."' WHERE text_id = ".$txt_id);
	}  
	
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
	
	echo '- Удалён -';
}



// =======================================

$mode = input_filter($_POST['mode']);
$pass = input_filter($_POST['passwd']);
$ids = input_filter($_POST['ids']);
$idss = input_filter($_POST['idss']);
$txt_id = input_filter($_POST['txt_id']);
$comm_id = input_filter($_POST['comm_id']);


session_start();
$ss_nick = $_SESSION['ss_nick'];
$ss_man_id = $_SESSION['ss_man_id'];


if ($mode == "get_comm_ids")
{
	echo get_comm_ids();
}
else if ($mode == "show_comms")
{
	echo show_comms($ids);
}
else if ($mode == "delete_comm")
{
	if ($pass != "432")
		ero("Пароль не верен.");	
	else
		delete_comm($comm_id);
}


?>
