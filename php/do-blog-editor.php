<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php"; 

// require_once "../php/bb_html_code.php";


//
// Статус текста
//
function unset_text_status($tid, $stid)
{
	do_update_sql("DELETE FROM mp_text_status WHERE text_rf = ".$tid." AND status_rf = ".$stid);
}
function set_text_status($tid, $stid)
{
	unset_text_status($tid, $stid);
	do_update_sql("INSERT INTO mp_text_status (text_rf, status_rf) VALUES (".$tid.", ".$stid.")");
}

//
//  Записать/обновить тэги
//
function write_tags($text_id, $tags)
{
	global $ss_nick;
	
	if (! isset($ss_nick))
	{
		ero('update_txt: Не имеете права.');
		return "0";
	}

	// Удаляю из базы
	$res = do_update_sql("DELETE FROM mp_tags WHERE text_rf = ".$text_id);
	if (substr($res, 0, 5) == "Error")
	{
		ero($res);
		return "0";
	}
   
	// Записываю в массив  
	$tag = explode(",", $tags);
	$n = count($tag);
	for($i=0; $i<$n;$i++) 
	  $tag[$i] = trim($tag[$i]);// Убираю начальные и конечные пробелы

	$tag = array_unique($tag);	// Убираю повторы
	
	// Записываю в базу
	foreach ($tag as $t) 
	{
		$res = do_update_sql("INSERT INTO mp_tags (text_rf, tag) VALUES (".$text_id.",\"".$t."\")");
		if (substr($res, 0, 5) == "Error")
		{
			ero($res);
			return "0";
		}
	}
    return "1";
}
//==============


//
// Записать текст
//
function write_txt()
{
	global $ss_nick, $ss_man_id;
	
	if (! isset($ss_nick))
	{
		ero('write_txt: Не имеете права.');
		return "0";
	}

	$p_bb = input_filter($_POST['bb']);
	if ($p_bb == 'BBYes')
	{
		$p_content = mysql_escape_string(check_text($_POST['content']));
		$p_about = mysql_escape_string(check_text($_POST['about']));
	}
	else
	{
		$p_content = mysql_escape_string($_POST['content']);
		$p_about = mysql_escape_string($_POST['about']);
	}
	$p_cat = mysql_escape_string(input_filter($_POST['category']));
	$p_url = input_filter($_POST['url']);
	$p_tags = input_filter($_POST['tags']);
    $p_description = input_filter($_POST['description']);
	$p_dt = input_filter($_POST['dt']);
	$p_header = input_filter($_POST['header']);
	
	$sql = "SELECT count(*) FROM mp_texts WHERE url = \"".$p_url."\"";
	$cnt = do_sql($sql);
	if ($cnt != "0")  
	{
		if ($cnt == "1")
			ero("Уже есть такой адрес страницы, поменяйте название темы.");
		else 
			ero($cnt);	
		exit;
	}

	// Ищу ид категории
	$cat_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".$p_cat."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "0";
	}

	// Записываю
	$sql = "
		INSERT INTO mp_texts (text_id, user_rf, dt, dtm, cat_rf, header, url, tags, description, about, content)  
			VALUES (0, ".$ss_man_id.",\""
			.$p_dt."\", \""
			.$p_dt."\", "
			.$cat_id.", \""
			.$p_header."\", \""
			.$p_url."\", \""
			.$p_tags."\", \""
            .$p_description."\", \""
			.$p_about."\", \""
			.$p_content."\")";

	$ret = do_update_sql($sql);
	if ($ret != "1")
	{
		ero($ret.$sql);
		return "0";
	}
		
/*
*/
	oke("ТЕКСТ ЗАПИСАН <a href=\"/".$p_url."\">Перейти</a>");
    ero("еуче_шв = ".$text_id);

    // Ищу ид вновь записанного текста
    $t_id = do_sql("
		SELECT text_id FROM mp_texts WHERE url = \"".$p_url."\"
	");
    if (substr($t_id, 0, 5) == "Error")
    {
        ero("ид вновь записанного текста не найден - ".$t_id);
        return "0";
    }

    // Записывают ТЭГИ
    if ($p_tags != "")
        write_tags($t_id, $p_tags);

	// Не заменять ББ тэги
	if ($p_bb == 'BBYes')
		unset_text_status($t_id, 13);   // Заменять
	else
		set_text_status($t_id, 13);     // Как есть

    // Помещать ли текст в карту сайта
    $p_sm = input_filter($_POST['sm']);
    if ($p_sm == '0')
        unset_text_status($t_id, 14);   // Не помещать
    else
        set_text_status($t_id, 14);	 // Помещать

}

//
// Изменить текст
//
function update_txt($tid)
{
	global $ss_nick, $ss_man_id;

	if (($ss_nick != 'Admin') and ($ss_nick != $_POST['user']))
	{
		ero('update_txt: Не имеете права.');
		return "0";
	}
//		ero($_POST['user'].'=='.$ss_nick.', id='.$ss_man_id.'=='.$_POST['user_id']);
//		return "0";

	$p_bb = input_filter($_POST['bb']);
	if ($p_bb == 'BBYes')
	{
		$p_content = mysql_escape_string(check_text($_POST['content']));
		$p_about = mysql_escape_string(check_text($_POST['about']));
	}
	else
	{
		$p_content = mysql_escape_string($_POST['content']);
		$p_about = mysql_escape_string($_POST['about']);
	}
	$p_cat = mysql_escape_string(input_filter($_POST['category']));
	$p_url = input_filter($_POST['url']);
	$p_tags = input_filter($_POST['tags']);
    $p_description = input_filter($_POST['description']);
//	$p_dt = input_filter($_POST['dt']);
	$p_header = input_filter($_POST['header']);

	// Ищу ид категории
	$cat_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".$p_cat."\"
	");
	if (substr($cat_id, 0, 5) == "Error")
	{
		ero($cat_id);
		return "0";
	}

	// Обновляю инфу о тексте
	$sql = "
		UPDATE mp_texts SET   
			cat_rf = ".$cat_id.", 
			header = \"".$p_header."\", 
			url = \"".$p_url."\",
			tags = \"".$p_tags."\",
			description = \"".$p_description."\",
			about = \"".$p_about."\",
			content = \"".$p_content."\"
		WHERE
			text_id = ". $tid
	;
	$ret = do_update_sql($sql);
	if ($ret == "1")
	{
		oke("ТЕКСТ СОХРАНЁН <a href=\"/".$p_url."\">Перейти</a>");
	}
	else {
		ero($ret);
		return "0";
	}	

	// Записывают ТЭГИ
	write_tags($tid, $p_tags);
	
	// Не заменять ББ тэги
	if ($p_bb == 'BBYes')
		unset_text_status($tid, 13);    // Заменять
	else
		set_text_status($tid, 13); 	 // Как есть

    // Помещать ли текст в карту сайта
    $p_sm = input_filter($_POST['sm']);
    if ($p_sm == '0')
        unset_text_status($tid, 14);   // Не помещать
    else
        set_text_status($tid, 14);	    // Помещать

}


function check_text($txt)
{
	include "../php/bb_html_code.php";

//	$t = addslashes(strip_tags(htmlspecialchars($txt)));
	$t = $txt;
	$t = htmlspecialchars($t);
//	t = nl2br($t);
//	$t = strip_tags($t); // Paranoya setting
	
	$t = str_replace ($bbcode, $htmlcode, $t);

	$t = str_replace("\r\n", "<br />", $t);
	$t = str_replace("\r", "<br   />", $t);
	$t = str_replace("\n", "<br  />", $t);

	return $t;
}

function bb2html($txt)
{
	include "../php/bb_html_code.php";

	$t = $txt;
	
	$t = str_replace ($bbcode, $htmlcode, $t);

	$t = str_replace("\r\n", "<br />", $t);
	$t = str_replace("\r", "<br   />", $t);
	$t = str_replace("\n", "<br  />", $t);

	return $t;
}

function html2bb($txt)
{
	include "../php/bb_html_code.php";

	$t = $txt;

	$t = str_replace("<br />", "\r\n", $t);
	$t = str_replace("<br   />", "\r", $t);
	$t = str_replace("<br  />", "\n", $t);

	$t = str_replace ($htmlcodeold, $bbcodeold, $t);
	$t = str_replace ($htmlcode, $bbcode, $t);

	$t = htmlspecialchars_decode ($t);

	return $t;
}

function html2bb3($txt)
{
	include "../php/bb_html_code.php";

	$t = $txt;

	$t = str_replace("<br>", "\r\n", $t);
	$t = str_replace("<br />", "\r\n", $t);
	$t = str_replace("<br   />", "\r", $t);
	$t = str_replace("<br  />", "\n", $t);

	$t = str_replace ($htmlcodeold, $bbcodeold, $t);
	$t = str_replace ($htmlcode, $bbcode, $t);

	$t = str_replace("/]", ">", $t);

	$t = htmlspecialchars_decode ($t);

	return $t;
}

function check_content_length($txt)
{
	$n = strlen ($txt);
	if ($n < 2100)
		return 1;
	echo $n.'-';

	$n = strpos ($txt , '[~]');
	echo $n.'-';
	if (($n < 2100) && ($n != 0))
		return 1;
		
	return 0;

}

//
// Записать комментарий к тексту
//
function write_comment()
{
	global $ss_nick, $ss_man_id;
	
	if (! isset($ss_nick))
	{
		ero('Войдите на сайт чтобы комментировать.');
		return "0";
	}

	$p_content = mysql_escape_string(check_text($_POST['content']));
	$p_dt = input_filter($_POST['dt']);
	$p_tid = input_filter($_POST['tid']);
	$p_comm_rf = input_filter($_POST['comm_rf']);
	$p_comm_id = input_filter($_POST['comm_id']);
//	$p_user_id = input_filter($_POST['user_id']);
	
	// Записываю 

	if ($p_comm_id == '0')
	{
		$sql = "
		INSERT INTO mp_comms (comm_id, comm_rf, text_rf, user_rf, dt, text)  
			VALUES (0, ".$p_comm_rf.","
			.$p_tid.", "
			.$ss_man_id.", \""
			.$p_dt."\", \""
			.$p_content."\")";
	}
	else
	{
		$sql = "
		UPDATE mp_comms
			SET text = \"".$p_content."\" 
			WHERE comm_id = ".$p_comm_id;
	}

	$ret = do_update_sql($sql);
	if ($ret != "1")
	{
		ero($ret);
		return "0";
	}
	
	// Обновляю дату последнего комментария в таблице текстов
	if ($p_comm_id == '0')
	{
		$res = do_update_sql(
			"UPDATE mp_texts SET dtm = '".$p_dt."' WHERE text_id = ".$p_tid
		);
		if (substr($res, 0, 5) == "Error")
		{
			ero($res);
			return "0";
		}
	}
	
	oke("КОММЕНТАРИЙ ЗАПИСАН");
}

//
// Получить текст комментария для редактирования
//
function get_ctext() 
{
	include "../php/bb_html_code.php";

	$p_comm_id = input_filter($_POST['comm_id']);
	$sql = "
		SELECT c.text AS txt 
			FROM  mp_comms c
		WHERE c.comm_id = ".$p_comm_id;	
	
	// Получаю ид категории
	$ctxt = do_sql($sql);
	if (substr($ctxt, 0, 5) == "Error")
	{
		ero($ctxt);
		return "";
	}

	echo html2bb($ctxt);
}


//====================================================


$tid = input_filter($_POST['tid']);
$pass = input_filter($_POST['passwd']);
$mode = input_filter($_POST['mode']);


if($mode == 'get_ctext')
{
	get_ctext();
	exit;
}

{
//	echo $tid.'-'.$pass;
//	exit;
}



session_start();
$ss_nick = $_SESSION['ss_nick'];
$ss_man_id = $_SESSION['ss_man_id'];

if ($tid == 'check')
{
	echo check_text($_POST['content']);
	exit;
}
else if ($tid == 'asis')
{
	echo $_POST['content'];
	exit;
}
else if ($tid == 'BB')
{
	echo html2bb3($_POST['content']);
	exit;
}
else if ($tid == 'HTML')
{
	echo bb2html($_POST['content']);
	exit;
}

if($mode == 'write_comment')
{
	write_comment();
//	echo check_text($_POST['content']);
	exit;
}

if (!check_content_length($_POST['content']))
{
	ero("Слишком длинный текст, отделите кодом [~] начало, не более ~1000 символов, для показа в каталоге.");
	exit;
}


if ($pass != "432")
	ero("Пароль не верен.");	
else if ($tid == 0)
{
//	if (!isset($_SESSION['ss_nick']))
//	{
//		ero('Для записи текста сначала войдите на сайт.');
//		echo ",-7";
//		exit;
//	}
	
	write_txt();
} 
else 
{
	update_txt($tid);
}

?>