<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";

//
// Вывод каталога текстов в виде таблицы
//
function get_dir() 
{
    $w = mk_where_for_texts();
	$sql = "
		SELECT b.text_id, m.logname, b.dt, c.cat_name, header, url 
			FROM (( mp_texts b
			LEFT JOIN mp_cats c ON c.cat_id = b.cat_rf)
			LEFT JOIN mp_users m ON m.user_id = b.user_rf)
		WHERE text_id > 1".$w
	;

	if (!($q=mysql_query($sql))) 
	{
    	ero('get_dir: Ошибка: ' . mysql_error() . "\n<br>");
	}
	$ret = '<table class="t"><tr>
	<td><b>id</b></td>
	<td><b>Автор</b></td>
	<td><b>Дата</b></td>
	<td><b>Категория</b></td>
	<td><b>Название</b></td>
	<td><b>Кнопки</b></td>
	</tr>';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . format1($f[text_id], $f[logname], $f[dt], $f[cat_name], $f[header], $f[url]);
	}
	$ret = $ret ."</table> ";
  
	return $ret;
}

function format1($text_id, $nik, $dt, $cat_name, $header, $url)
{
	global $ss_nick;
	
	if ($ss_nick == 'Admin')
		return	'<tr>
		<td>&nbsp;'.$text_id. '</td>
		<td>'.$nik. '</td>
		<td>'.$dt. '</td>
		<td>'.$cat_name. '</td>
		<td><a class="btn" href="/'.$url.'">'.$header.'</a></td>
		<td>
			<form name="dir'.$text_id.'" action="../mpcms/blog-editor.php" method="post"">
				<input class="til" type="text" name="tid" hidden value="'.$text_id.'" />
				<input  class="bred" type=submit value="" title="Изменить">
				<input  class="bdel" type="button" value=""  title="Удалить" onclick="del_txt('.$text_id.')" />
			</form> 
		</td>
		</tr> ';
	else	
		return	'<tr>
		<td>&nbsp;'.$text_id. '</td>
		<td>'.$nik. '</td>
		<td>'.$dt. '</td>
		<td>'.$cat_name. '</td>
		<td><a class="btn" href="/'.$url.'">'.$header.'</a></td>
		<td> 
		</td>
		</tr> ';
}

//
// Вывод текстов в виде блога
//
function get_blog($ids, $is_text) 
{
	if (trim($ids) == '') $ids = '0';
	
    $ord = 'DESC';
    if (isset($_SESSION['srtt'])) 
		if ($_SESSION['srtt'] == 'Старые' ) $ord = '';

	$sql = "
		SELECT b.text_id, m.logname, b.dt, c.cat_name, b.header, b.url, b.content AS txt 
			FROM (( mp_texts b
				LEFT JOIN mp_cats c ON c.cat_id = b.cat_rf)
				LEFT JOIN mp_users m ON m.user_id = b.user_rf)
		WHERE b.text_id IN (".$ids.") 	
		ORDER BY dtm ".$ord."
		LIMIT 0 , 3
	";
//	echo $sql."<br/>";
	if (!($q=mysql_query($sql)))
	{
    	ero('get_blog: Ошибка: ' . mysql_error() . "\n<br>".$sql);
	}
//	$ret = '<table class="t"> <col width="23%">';
	$ret = '';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		
		$t = cut_text($f[txt], $is_text, $f[url]);
		
		$ret = $ret . format2($f[text_id], $f[logname], $f[dt], $f[cat_name], $f[header], $f[url], $t);
	}
//	$ret = $ret ."</table> ";
  
	return $ret;
	
}
function cut_text($txt, $is_text, $url)
{
	if ($is_text == 1)
		return $txt;

	$n = strpos ($txt , '<span id="cutt"></span>');
	if ($n == 0)
		return $txt;
		
//	$txt = substr($txt, 0, $n).'&nbsp; <a href="/'.$url.'"> <img src="../img/txt-read.png" title="Читать полностью" /> >>> читать полностью >>> </a>'; 

	$txt = substr($txt, 0, $n).'<a href="/'.$url.'">[читать полностью]</a>'; 

		return $txt;

}

//
// Форматировать как БЛОГ
//
function format2($text_id, $nik, $dt, $cat_name, $header, $url, $txt)
{
	global $ss_nick;
	
//	$ret =	' $ss_nick='.$ss_nick.', $nik='.$nik.' 

	$btn = '
		<div class="btntxt">
			<form name="dir'.$text_id.'" action="../mpcms/blog-editor.php" method="post"">
				<input class="til" type="text" hidden name="tid" value="'.$text_id.'" />';
				
	if (($ss_nick == 'Admin') or ($ss_nick == $nik))
		$btn = $btn.'<input class="btn9" type=submit value="Изменить" title="Изменить">';
//		$ret = $ret.'<input class="bred" type=submit value="" title="Изменить"> ';
				
	if ($ss_nick == 'Admin')
			$btn = $btn.'<input class="btn9" type="button" value="Удалить" title="Удалить" onclick="del_txt('.$text_id.')" />';
			
	$btn = $btn.'</form></div>';

	$ft3 = '
	Просмотров: <span>'.counts($text_id).'</span> &nbsp; 
	Оценка: <span id=like'.$text_id.'  title="Оценка">'.likes_txt($text_id).'</span> &nbsp; Оценить: 
    <input class="lnk2" title="Положительно" type="button" value=" + " onclick="lkt('.$text_id.',1)" />
    <input class="lnk2" title="Всё равно" type="button" value=" = " onclick="lkt('.$text_id.',0)" />
    <input class="lnk2" title="Отрицательно" type="button" value=" - " onclick="lkt('.$text_id.',-1)" />
    ';

	$ft = ' <span title="Просмотров / комментариев"> '.counts($text_id).' / '. comments($text_id). ' </span>|
    <input class="btn" title="Нравится" type="button" value=" + " onclick="lkt('.$text_id.',1)" />
    <input class="btn" title="Не нравится" type="button" value="- " onclick="lkt('.$text_id.',-1)" />
    <input class="btn" title="Всё равно" type="button" value="= " onclick="lkt('.$text_id.',0)" />
    <span id=like'.$text_id.' title="Оценка">'.likes_txt($text_id).'</span> |  
    ';
    
    $ft2 = '';
			
	$hd = '	<div  class="hdtxt">'
			.$text_id.' | '.f46($nik, "Автор").' | '.f46($dt, "Дата").' | 
			 <a href="/cat/'.$cat_name.'" title="Категория">'.$cat_name.'</a> | '
			 .$ft.$btn.			
			'</div>';

	$ret =	'
		<div  class="divtxt">'.
		$btn.$hd.
		'<a class="tdnone" href="/'.$url.'"><h2 class="h3hdr">'.$header.'</h2></a>
		<br/>'.$txt.
		$ft2.
		'<br/></div>';
		
	$ret ='<div class="bordered">'.
		$hd.'<div class="divtxt">'.
		'<a class="tdnone" href="/'.$url.'"><h2 class="h3hdr">'.$header.'</h2></a>
		<br/>'.$txt.'</div>'.
		$ft2.
		'</div><br/>';

	return $ret;	
}
function f46($t, $c)
{
	return '<span class="hdtxt2" title="'.$c.'">'.$t.'</span>';
	
}

//
// Получить краткую инфу о тексте 
//
function get_about($ids) 
{
	$txt2 = do_sql("SELECT about FROM mp_texts WHERE text_id = ".$ids);
	if (substr($txt2, 0, 5) == "Error")
	{
		ero($txt2);
		return "";
	}

	if ($txt2 == '')
		echo '';
	else	
		echo '<div class="divcomm"><h4>Кратко</h4>'.$txt2.'</div>';
}

//
// Оценить текст 
//
function like_txt($txt_id, $lk)
{
	global $ss_nick, $ss_uid;

	if (! isset($ss_nick))
	{
		ero('like_txt: Зайдите на сайт, чтобы оценивать тексты');
		return "0";
	}

	// Удаляю из базы
	$sql = 'DELETE FROM mp_text_likes WHERE text_rf = '.$txt_id.' AND user_rf = '.$ss_uid;
	$res = do_update_sql($sql);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}

	// Записываю
	if ($lk != 0)
	{
		$sql = "INSERT INTO mp_text_likes (user_rf, text_rf, danet)  VALUES (".	$ss_uid.",".$txt_id.",".$lk.")";
		$res = do_update_sql($sql);
		if (substr($res, 0, 5) == "Error")
		{
			ero($res);
			return "0";
		}
	}
   
   	// Подсчитываю оценку
	$sql = "SELECT SUM(danet) FROM mp_text_likes WHERE text_rf = ".$txt_id;
	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm.$sql);
		return "0";
	}
	return $sm;
}

//
// Оценить комментарий 
// $txt_id здесь ид коммента, а не текста, просто не стал переменную переобзывать
//
function like_comm($txt_id, $lk)
{
	global $ss_nick, $ss_uid;

	if (! isset($ss_nick))
	{
		ero('Зайдите на сайт, чтобы оценивать');
		return "0";
	}

	// Удаляю из базы
	$sql = 'DELETE FROM mp_comm_likes WHERE comm_rf = '.$txt_id.' AND user_rf = '.$ss_uid;
	$res = do_update_sql($sql);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
	// Записываю
	if ($lk != 0)
	{
		$sql = "INSERT INTO mp_comm_likes (user_rf, comm_rf, danet)  VALUES (".	$ss_uid.",".$txt_id.",".$lk.")";
		$res = do_update_sql($sql);
		if (substr($res, 0, 5) == "Error")
		{
			ero($res);
			return "0";
		}
	}
   	
   	// Подсчитываю оценку
	$sql = "SELECT SUM(danet) FROM mp_comm_likes WHERE comm_rf = ".$txt_id;
	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm.$sql);
		return "0";
	}
	return $sm;
}

//
// Оценка текста 
//
function likes_txt($txt_id)
{
   	// Подсчитываю оценку
	$sql = "
		SELECT SUM(danet) 
			FROM mp_text_likes
			WHERE text_rf = ".$txt_id
	;

	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm);
		return "0";
	}
	return $sm;
}

//
// Кол-во просмотров текста
//
function counts($txt_id)
{
   
	$sql = "SELECT url FROM mp_texts WHERE text_id = ".$txt_id;
	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm);
		return "0";
	}

	$sql = "SELECT count(*) FROM mpstat WHERE cname = \"".$sm."\"";
	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm);
		return "0";
	}
	return $sm;
}
//
// Кол-во комментариев текста
//
function comments($txt_id)
{
	$sql = "SELECT count(*) FROM mp_comms WHERE text_rf = ".$txt_id;
	$sm = do_sql($sql);
	if (substr($sm, 0, 5) == "Error")
	{
		ero($sm);
		return "0";
	}
	return $sm;
}


//
// Получить список идентификаторов категорий, 
// 		указанной и всех входящих в указанную
//
function get_cats_by_name($cat) 
{
	if ($cat == 'Tексты')	
		return "0";
	
	$cat_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".mysql_escape_string($cat)."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "0";
	}
	$cats = get_cats_by_id($cat_id);
	
	return $cats;
}

function get_cats_by_id($cat_rf) 
{
	$cats = $cat_rf; 

	if (!($q=mysql_query("SELECT cat_id FROM mp_cats WHERE cat_rf = ".$cat_rf))) 
	{
    	ero('get_cats_by_id: Ошибка: ' . mysql_error() . "\n<br>");
	}
	for ($c=0; $c<mysql_num_rows($q); $c++) 
	{
		$f = mysql_fetch_array($q);
		$cats = $cats.",".get_cats_by_id($f[cat_id]);
	}
	
	return $cats;
}

//
// Получить цепочку вложенных категорий с корневой, до заданной
// и их описание
//
function get_cats_chain_for_txt($txt_id) 
{
	global $cats_about;

	$sql = "
		SELECT c.cat_name 
			FROM mp_texts t
				LEFT JOIN mp_cats c ON c.cat_id = t.cat_rf
		WHERE t.text_id IN (".$txt_id.") 	
	";

	$cat_name = do_sql($sql);
	if (substr($cat_name, 0, 5) == "Error")
	{
		ero($cat_name);
		return "/ ";
	}

//	return '->'.$cat_name;
	return get_cats_chain($cat_name);
}

function get_cats_chain($cat_name) 
{
	global $cats_about;

	$cats_about = '';
	$cids = '';
	
	if ($cat_name == '')	
		return "/ ";
	
	// Получаю ид категории
	$cat_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".mysql_escape_string($cat_name)."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "";
	}
	$cat_chain = cat_ref($cat_name);
	$ab = do_sql("
		SELECT about FROM mp_cats WHERE cat_name = \"".mysql_escape_string($cat_name)."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "";
	}
	$cats_about = cat_ab_format($cat_name, $ab);
	$cnt = 0;
	while (($cat_id != "1") && ($cnt < 12))
	{
		$pcat = do_sql_a("
			SELECT c.cat_rf, p.cat_name, p.about 
				FROM mp_cats c LEFT JOIN mp_cats p ON c.cat_rf = p.cat_id
				WHERE c.cat_id = ".$cat_id."
		");
		if (substr($cat_id, 0, 5) == "Error")
		{
			ero($pcat);
			return "";
		}
		$cat_id = $pcat[0];
//		if ($cat_id != "1")
		$cat_chain = cat_ref($pcat[1])." - ".$cat_chain;
		$cids = ",".$cat_id.$cids;
		$cats_about = cat_ab_format($pcat[1], $pcat[2]).$cats_about;

		$cnt = $cnt + 1;
//			return $cat_chain.$cnt;
	}
//	$cat_chain = $cat_chain + '<span id="cids" hzidden="hidden">'.$cids.'</span>';
	$cat_chain = $cat_chain.'<span id="cids" value="x'.$cids.'x" hidden="hidden">0'.$cids.'</span>';
//*/	
	return $cat_chain;
}

// Сделать кнопку из названия категории
function cat_ref($cat_name)
{
	global $mode;
	
	if($mode == "get_cats_chain_for_txt")
		return	$cat_name;
	else
		return	"<input class='lnk2' type='button' value='".$cat_name."' onclick='change_cats(\"".$cat_name."\")' />";

//	return "<a href=/".urlencode($cat_name).">".$cat_name."</a>";
//	return "<a href=\"/mpcms/blog-dir.php?category=".$cat_name."\">".$cat_name."</a>";
//	return $cat_name;
}
// Форматирование инфы о категории
function cat_ab_format($cat_name, $ab)
{
//	return "<h4>".$cat_name."</h4><div>$ab</div>";
//	if ($ab == '')
//		return '';
		return '<h4>'.$cat_name.'</h4>'.$ab;
//	else	
//		return '<div class="divcomm"><h4>'.$cat_name.'</h4>'.$ab.'</div>';

}


//
// Получить все ид текстов, удовлетворяющих заданным условиям
//
function mk_where_for_texts() 
{
	$cats = get_cats_by_name(input_filter($_POST['cat']));

//return "::".$_POST['cat']."::";


	if ($cats != 0)
		$where_cats = " AND b.cat_rf IN (".$cats.") ";
	else
		$where_cats = "";

	if ($_POST['tag'] != "")
		$where_tags = " AND b.tags LIKE \"%".input_filter($_POST['tag'])."%\" ";
	else
		$where_tags = "";


    $whr = '';
    if (isset($_SESSION['dtb'])) $whr = $whr.' AND b.dt >= "'.$_SESSION['dtb'].'" ';
    if (isset($_SESSION['dte'])) $whr = $whr.' AND DATE_ADD(b.dt, INTERVAL -1 DAY) <= "'.$_SESSION['dte'].'" ';
//    if (isset($_SESSION['dte'])) $whr = $whr.' AND dt <= "'.$_SESSION['dte'].'" ';
//    if (isset($_SESSION['dte'])) $whr = $whr.' AND dt <= DATE_ADD("'.$_SESSION['dte'].'", INTERVAL 1 DAY ';

    $ord = 'DESC';
    if (isset($_SESSION['srtt'])) 
		if ($_SESSION['srtt'] == 'Старые' ) $ord = '';

    $dt = 'dtm';
    if (isset($_SESSION['srtk'])) 
		if ($_SESSION['srtk'] == 'ТолькоТексты' ) $dt = 'dt';
		
	return $where_cats . $where_tags. $whr."ORDER BY ".$dt." ".$ord;
}

//
// Получить все ид текстов, удовлетворяющих заданным условиям
//
function get_ids() 
{
    $w = mk_where_for_texts();
	$sql = "
		SELECT DISTINCT text_id 
			FROM mp_texts b
			WHERE text_id > 0 ".$w."
		LIMIT 0 , 333"
	;
//		.$where_cats . $where_tags. $whr.
//		"ORDER BY dt ".$ord."
	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_ids: Ошибка: ' . mysql_error() . "\n<br>");
	}
	$ret = '';
	for ($c=1; $c<mysql_num_rows($q); $c++) // с 1 начинаю, чтобы уменьшить кол-во циклов на 1
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . $f[text_id].",";
	}
	$f = mysql_fetch_array($q); // Последний цикл - не ставлю ","
	$ret = $ret . $f[text_id];
  
	return $ret;
}

//
// Удалить текст с заданным ид
//
function delete_txt($txt_id) 
{
	global $ss_nick;
	
	if ($ss_nick != 'Admin')
	{
		ero('delete_txt: Нет прав на удаление текста.');
		return "0";
	}

	//	$sql = "SELECT count(*) AS cnt FROM  mp_comms WHERE text_rf = ".$txt_id;	
	// Кол-во комментариев
	$cnt = do_sql("SELECT count(*) AS cnt FROM  mp_comms WHERE text_rf = ".$txt_id);
	if (substr($cnt, 0, 5) == "Error")
	{
		ero($cnt);
		return "";
	}
	if ($cnt != "0")
	{
		ero("Сначала нужно удалить комментарии");
		return "0";
	}

	// Удаляю текст
	$res = do_update_sql("DELETE FROM mp_texts WHERE text_id = ".$txt_id);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
	
	// Удаляю тэги этого текста
	$res = do_update_sql("DELETE FROM mp_tags WHERE text_rf = ".$txt_id);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
}

//
// Формирование облака ТЭГов
//
function get_tags1() 
{
//	$idss = input_filter($_POST['idss']);
	$idss = get_ids();
	if ($idss == "") $idss = "0";
	$sql = "
		SELECT DISTINCT tag, count(*) AS n 
			FROM mp_tags
		WHERE text_rf IN (".$idss.")	
		GROUP BY tag
		ORDER BY 2 DESC, 1
	";

	if (!($q=mysql_query($sql)))  
	{
    	ero('get_tags1: Ошибка: ' . mysql_error() . "\n<br>");
	}

	$ret = formattag1("", 'все метки'.mysql_num_rows($q));
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . formattag1($f[tag], $f[n]);
	}
	
	return $ret;
}

function formattag1($tag, $n)
{
	return	'<input type="button" class="cloudbuttont" value="'.$tag.'('.$n.') " onclick="change_tags(\''.$tag.'\')" />';
}

//
// Формирование иерархического списка категорий
//
function get_cats1($cat_name, $shft) 
{
	if ($cat_name == "")	
		return "";
//	if (substr($cat_name, 0, 1) == " ")	return "";
	if ($shft == '+++++++')	// от зацикливания
		return "";
	
	// Получаю ид категории
	$cat_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".mysql_escape_string($cat_name)."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "";
	}
	
	$sql = "
		SELECT DISTINCT cat_name 
			FROM mp_cats
		WHERE cat_rf = $cat_id	
		  AND cat_id <> $cat_id	
		  AND cat_name <> ' '	
		ORDER BY 1
	";

	if (!($q=mysql_query($sql)))  
	{
    	ero('get_cats1: Ошибка: ' . mysql_error() . "\n<br />");
	}

   	if ($shft <> "") 
   		$ret = "<br />".$shft.formatcat1($cat_name, $shft);
   	else 
		$ret = $shft.formatcat1($cat_name, $shft);

	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret.get_cats1($f[cat_name], $shft."+");
	}
	
	return $ret;
}
function formatcat1($cat_name, $shft)
{
	$cat = input_filter($_POST['cat']);
	
	if ($cat == $cat_name or $shft == 'xxx')
		return	'<input type="button" class="cloudbuttonb" value=" '.$cat_name.'" onclick="change_cats(\''.$cat_name.'\')" />';
	else
		return	'<input type="button" class="cloudbutton" value=" '.$cat_name.'" onclick="change_cats(\''.$cat_name.'\')" />';

}

//
// Формирование списка подкатегорий заданной категории
//
function get_subcats($cat_id, $shft) 
{
//	return $cat_id;
    $ret = '';

	if ($cat_id == "0")	
	$sql = "
		SELECT DISTINCT cat_id, cat_name 
			FROM mp_cats
		WHERE cat_rf = 1	
		  AND cat_id = 1	
		  AND cat_name <> ' '	
		ORDER BY cat_name
	";
	else
	$sql = "
		SELECT DISTINCT cat_id, cat_name 
			FROM mp_cats
		WHERE cat_rf = $cat_id	
		  AND cat_id <> $cat_id
		ORDER BY cat_name
	";

	if (!($q=mysql_query($sql)))  
	{
    	ero('get_subcats: Ошибка: ' . mysql_error() . "\n<br />");
	}
	$nn = mysql_num_rows($q);
	for ($c=1; $c<=$nn; $c++)
	{
		$f = mysql_fetch_array($q);
//		if ($c == $nn)	$br = '.';
		$ret = $ret.formatsubcats($f[cat_id], $f[cat_name], $shft);
	}
	
	return $ret;
}
function formatsubcats($cat_id, $cat_name, $shft)
{

	$cat = input_filter($_POST['catm']);

	if ($shft == '+')
		$cls = 'catnm';
	else if ($shft == ' -')
		$cls = 'catnm2';
	else if ($shft == ' - -')
		$cls = 'catnm3';
	else if ($shft == ' - - -')
		$cls = 'catnm4';
	else
		$cls = 'catnm';


	if ($cat == $cat_name)
		$cls = 'catnmb';
//	else
//		$cls = 'catnm';

//	if ($shft == '')	  $shft = '';	else	  $shft = $shft.'*';
	  
return	'<input type="button" class="catplus" value="+'.$shft.'" onclick="show_subcats('.$cat_id.',\''.$shft.' -\')" /> <input type="button" class="'.$cls.'" value="'.$cat_name.'" onclick="change_cats(\''.$cat_name.'\')" /><br /><span class="i" id="cat'.$cat_id.'"> </span>'.
'';
}

// =======================================

$mode = input_filter($_POST['mode']);
$pass = input_filter($_POST['passwd']);
$ids = input_filter($_POST['ids']);
$idss = input_filter($_POST['idss']);
$cat = input_filter($_POST['cat']);
$txt_id = input_filter($_POST['txt_id']);


session_start();
$ss_nick = $_SESSION['ss_nick'];
$ss_uid = $_SESSION['ss_user_id'];

if ($mode == "show_dir")
{
//	if ($pass != "432")
//		ero("Пароль не верен.");	
//	else
		echo get_dir();
}
else if ($mode == "show_blog")
{
//	ero('Записи: '.$_POST['ids'].".<br/>");

	echo get_blog($ids, 3);
//	echo $GLOBALS['squery_count']; 
}
else if ($mode == "show_text")
{
	echo get_blog($ids, 1);
}
else if ($mode == "show_about")
{
	echo get_about($ids);
}
else if ($mode == "get_txt_ids")
{
	echo get_ids();
}
else if ($mode == "delete_txt")
{
	if ($pass != "432")
		ero("Пароль не верен.");	
	else
		delete_txt($txt_id);
}
else if ($mode == "get_all_cat_ids")
{
	echo $cat.":".get_cats_by_name($cat);
}
else if ($mode == "like_comm")
{
	echo like_comm($txt_id, $_POST['like']);
}
else if ($mode == "like_txt")
{
	echo like_txt($txt_id, $_POST['like']);
}
else if ($mode == "get_cats_chain")
{
	echo get_cats_chain($cat);
}
else if ($mode == "get_cats_chain_for_txt")
{
	echo get_cats_chain_for_txt($txt_id);
}
else if ($mode == "get_cats_about")
{
	$cats_about = '';
	get_cats_chain_for_txt($txt_id);
	echo '<div class="divcomm">'.$cats_about.'</div>';
//	echo $cats_about;
}
else if ($mode == "show_tags1")
{
	echo get_tags1();
}
else if ($mode == "show_cats1")
{
	echo get_cats1("Tексты", "");
}
else if ($mode == "show_subcats")
{
   $shft = input_filter($_POST['shft']);

	echo get_subcats($cat, $shft);
}
else if ($mode == "set_sv")
{
	echo input_filter($_POST['nm']).'='.input_filter($_POST['val']);
	if (isset($_SESSION['ss_nick']))
	{
		$_SESSION[input_filter($_POST['nm'])] = input_filter($_POST['val']);
	echo '------------------'.$_SESSION[input_filter($_POST['nm'])].'===================';
	}
}

?>
