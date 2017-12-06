<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";


//
// Вывод всех категорий для просмотра
//
function get_cats() 
{
	$sql = "
		SELECT c.cat_id, c.cat_rf, c.cat_name AS cname, r.cat_name AS cfolder, c.about  
			FROM mp_cats c
			LEFT JOIN mp_cats r ON r.cat_id = c.cat_rf
		WHERE c.cat_id != 00000 	
		ORDER BY r.cat_name, c.cat_name
	";
	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_cats: Ошибка: ' . mysql_error() . "\n<br>");
	}
	$ret = '<table class="t"><tr><td><b>id</b></td><td><b>rf</b></td><td><b>Категория</b></td><td><b>Входит в</b></td><td><b>О категории</b></td><td> </td></tr>';//	$ret = '<table class="t"><tr><td><b>id</b></td><td><b>Категория</b></td><td><b>Входит в</b></td></tr>';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);

//		$ret = $ret . '<tr><td>'. $f[cat_id].'</td><td>'.$f[cat_rf]. '</td><td>'.$f[cname]. '</td><td>'.$f[cfolder]. '</td></tr> ';
//		$ret = $ret . '<tr><td>'. $f[cat_id].'</td><td>&nbsp;'.$f[cname]. '</td><td>'.$f[cfolder]. '</td></tr> ';
		$ret = $ret . format3($f[cat_id], $f[cat_rf], $f[cname], $f[cfolder], $f[about]);

	}
	$ret = $ret ."</table> ";
 
	return $ret;
}

function format3($cat_id, $cat_rf, $cname, $cfolder, $about)
{
	return	'<tr>
		<td>&nbsp;'.$cat_id. '</td>
		<td>'.$cat_rf. '</td>
		<td>'.$cname. '</td>
		<td>'.$cfolder. '</td>
		<td>'.$about. '</td>
		<td>
<input class="bred" type="button" value="" title="Изменить" onclick="edit_cat('.$cat_id.',\''.$cname.'\',\''.$cfolder.'\')" />
		</td>
		</tr> ';
}

//
// Формирование опции select для выбора категории
//
function get_cats_for_select() 
{
	$sql = "
		SELECT cat_name, cat_id  
			FROM mp_cats
		ORDER BY cat_name
	";
//		WHERE cat_name != '' 	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_cats_for_select: Ошибка: ' . mysql_error() . "\n<br>");
	}
	
	$selected_cat = input_filter($_POST['category']);

	$ret = '';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		if ($f[cat_name] == $selected_cat)
	    	$ret = $ret . '<option selected value="'.$f[cat_name].'">'.$f[cat_name].'</option>';
		else
			$ret = $ret . '<option>'.$f[cat_name].'</option>';

	}

	return $ret;
}

//
// Формирование опции select для выбора ТЭГов
//
function get_tags_for_select() 
{
	$sql = "
		SELECT DISTINCT tag  
			FROM mp_tags
		ORDER BY 1
	";
//		WHERE cat_name != '' 	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_tags_for_select: Ошибка: ' . mysql_error() . "\n<br>");
	}

	$selected_tag = input_filter($_POST['tag']);

	$ret = '<option></option>';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		if ($f[tag] == $selected_tag)
	    	$ret = $ret . '<option selected value="'.$f[tag].'">'.$f[tag].'</option>';
		else
			$ret = $ret . '<option>'.$f[tag].'</option>';
	}

	return $ret;
}

//
// Запись новой категории в БД
//
function write_cat($id, $cat, $about, $folder)
{
//	echo "Категория ".$cat." входит в ".$folder."<br/>";
	global $ss_nick;
	
	if ($ss_nick != 'Admin')
	{
		ero('write_cat: Не имеете права.');
		return;
	}
	
	$folder_id = do_sql("
		SELECT cat_id FROM mp_cats WHERE cat_name = \"".$folder."\""
	);
	if (substr($folder_id, 0, 5) == "Error")
	{
		ero($folder_id);
		return;
	}

//	echo "fid=".$folder_id."<br/>";
	
	if ($id == 0)
	{
		$sql = "
			INSERT INTO mp_cats(cat_id, cat_rf, cat_name, about)  
				VALUES (0, ".$folder_id.", \"".$cat."\", \"".$about."\")"
		;
	}
	else
	{
		$sql = "
			UPDATE mp_cats SET 
				cat_name = \"".$cat."\", 
				about = \"".$about."\", 
				cat_rf = ".$folder_id." 
			WHERE
				cat_id = ". $id
		;
	}
	$ret = do_update_sql($sql);
	if ($ret == "1") { oke("ЗАПИСАНО"); }
	else { echo $ret."<br/>".$sql; }
}


//
// Получить инфу о категории 
//
function show_cat_about($id) 
{
	
	if ($id == "0")
		return "";
	
	$txt2 = do_sql("SELECT about FROM mp_cats WHERE cat_id = ".$id);
	if (substr($txt2, 0, 5) == "Error")
	{
		ero($txt2);
		return "";
	}
	return $txt2;
}

//=========================================

$mode = input_filter($_POST['mode']);

session_start();
$ss_nick = $_SESSION['ss_nick'];

//echo $_POST['mode']; //$mode;

if ($mode == "show")
{
	echo get_cats();
//	echo $_POST['mode']."---".input_filter($_POST['mode']); //$mode;

}
else if ($mode == "write")
{
	if (input_filter($_POST['passwd']) != "432")
	{
		ero("Пароль не верен.");	
	}
	else
		write_cat(
			input_filter($_POST['cat_id']), 
			input_filter($_POST['category']), 
			($_POST['about']),
			input_filter($_POST['folder'])
		);
}
else if ($mode == "select")
{
//	echo 'wwwwwwwwww';
	echo get_cats_for_select();
}
else if ($mode == "selecttag")
{
	echo get_tags_for_select();
}
else if ($mode == "show_cat_about")
{
	echo show_cat_about(input_filter($_POST['cat_id']));
//	echo '1234567';
}
?>

