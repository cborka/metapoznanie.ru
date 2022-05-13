<?php
require_once "../php/init_php.php";
require_once "../php/init_db.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Редактор</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	
	<link rel="stylesheet" href="../css/mp.css?<?php echo $ver; ?>">
	
	<script type="text/javascript" language="javascript" src="../js/a-lib.js?<?php echo $ver; ?>"></script>
	<script type="text/javascript" language="javascript" src="../js/text-edit.js?<?php echo $ver; ?>"></script>
</head>
<body>


<!-- =================================== ШАПКА ===================================== -->
<div class="head"> <!-- ШАПКА -->

<?php include "../mpcms/itis-header.php" ?>

</div> <!-- ШАПКА -->

<!-- ================================ СЕРЕДИНА ПО ВЕРТИКАЛИ ========================== -->
<div class="wrapper_1">
<div class="leftcol"> <!-- ЛЕВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-left-index.php" ?>

</div> <!-- ЛЕВАЯ КОЛОНКА -->


<!-- =============================== ЦЕНТР, ОСНОВНАЯ ИНФА ========================================= -->
<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";

//
// Замена HTML в ББ коды в строке текста
//
function html2bb2($txt)
{
	include "../php/bb_html_code.php";

	$t = $txt;

//	$t = addslashes(strip_tags(htmlspecialchars($txt)));
//	$t = strip_tags(htmlspecialchars($txt));
//	$t = nl2br(strip_tags($txt));

	$t = str_replace("<br />", "\r\n", $t);
	$t = str_replace("<br   />", "\r", $t);
	$t = str_replace("<br  />", "\n", $t);

	$t = str_replace ($htmlcodeold, $bbcodeold, $t);
	$t = str_replace ($htmlcode, $bbcode, $t);
	
	$t = htmlspecialchars_decode ($t);
	
	return $t;
}

//
// Получение текста и его атрибутов
//
function get_blog_txt_for_edit() 
{
    global $n, $tid, $man_id, $nik, $dt, $cat_name, $header, $url, $tags, $description, $about, $txt, $stbb, $tositemap;

	$tid = $_POST['tid'];

	$stbb = do_sql("SELECT count(*) FROM mp_text_status WHERE text_rf = ".$tid." AND status_rf = 13");
	if ($stbb == '0') $stbb = "checked";
	else $stbb = "";

    $tositemap = do_sql("SELECT count(*) FROM mp_text_status WHERE text_rf = ".$tid." AND status_rf = 14");
    if ($tositemap != '0') $tositemap = "checked";
    else $tositemap = "";

	if ($tid == '') $tid = '0';
	
	$sql = "
		SELECT b.text_id, b.user_rf, m.logname, b.dt, c.cat_name, b.header, b.url, b.tags, b.description, b.about, b.content AS txt 
			FROM (( mp_texts b
				LEFT JOIN mp_cats c ON c.cat_id = b.cat_rf)
				LEFT JOIN mp_users m ON m.user_id = b.user_rf)
		WHERE b.text_id = ". $tid 	
	;
	if (!($q=mysql_query($sql))) 
	{
		$txt = 'get_blog_txt: Ошибка: ' . mysql_error();
		return;
	}
	$n = mysql_num_rows($q);
	if ($n != 1)
	{
		$tid = 0;
		$man_id = 0;
		$nik = 'Noname';
		$dt = gmdate("Y-m-d h:i:s", strtotime("+7 hours"));
		$cat_name = 'test';
		$header = 'Заголовок';
		$url = 'zagolovok';
		$tags = '';
        $description = '';
		$about = '';
		$txt = '';
		
	}
	else
	for ($c=0; $c<$n; $c++)
	{
		$f = mysql_fetch_array($q);
		
		$man_id = $f[user_id];
		$nik = $f[logname];
		$dt = $f[dt];
		$cat_name = $f[cat_name];
		$header = $f[header];
		$url = $f[url];
		$tags = $f[tags];
        $description = $f[description];

		if ($stbb == 'checked')
		{
			$about = html2bb2($f[about]);
			$txt = html2bb2($f[txt]);
		}
		else
		{
			$about = $f[about];
			$txt = $f[txt];
		}
	}
  
	return "1";
}
$tid = $_POST['tid'];
//echo "tid=".$tid;

get_blog_txt_for_edit();
//echo $nik.$man_id.$tags;
?>

	
<div class="center"> 

<div class="divtxt">
<h2 id="h21">Новая запись</h2>
</div>

<form name="edform">

	<span id="cat_name" hidden><?php echo $cat_name; ?></span>
<div class="divtxt">
    <table class="ed"> <col width="15%">
    
   		<tr><td class="l">Категория</td><td class="r">
				<select size="1" name='category' id='category'></select>
		</td></tr>

		<tr><td class="l">Заголовок</td><td class="r"><input class='text rq909' type='text' name='header' id='header' value='<?php echo $header; ?>' maxlength='250' required onchange='setURL()'/></td></tr>
		
		<tr><td class="l">&nbsp;</td><td class="r"></td></tr>
		
		<tr><td class="l">
			<input class='inf1' type='text' name='tid' id='tid' 
    		value='<?php echo $tid; ?>' 
    		maxlength='5' readonly /><input class='inf1' type='text' name='man_id' id='man_id' 
    		value='<?php echo $man_id; ?>' 
    		maxlength='5' readonly />
 		</td><td class="r">
		
	<!--// Вывод кнопок редактирования-->
  	<input class="btn" type='button' id='edb101' value='i' onclick='insert_tag("txt", "<i>", "</i>")' title='Курсив' /><input 
  	class="btn" type='button' id='edb102' value='b' onclick='insert_tag("txt", "<b>", "</b>")' title='Жирный шрифт' /><input 
  	class="btn" type='button' id='edb103' value='u' onclick='insert_tag("txt", "<u>", "</u>")' title='Подчёркнуть' /><input
  	 class="btn" type='button' id='edb104' value='з' onclick='insert_tag("txt", "<del>", "</del>")' title='Зачёркнуть' />
  	<input class="btn" type='button' id='edb105' value='ц' onclick='insert_tag("txt", "<blockquote class=\"bctxt\">", "</blockquote>")' title='Цитата' /><input 
  	class="btn" type='button' id='edb106' value='§' onclick='insert_tag("txt","<p class=\"txt\">","</p>")' title='Параграф' /><input
  	class="btn" type='button' id='edb107' value='ф' onclick='insert_tag("txt", "<pre class=\"pretxt\">", "</pre>")' title='Форматированный текст' /><input 
  	class="btn" type='button' id='edb108' value='~' onclick='insert_tag("txt","<span id=\"cutt\"></span>","")' title='Точка обрезки' />
     
  	<input class="btn" type='button' id='edb109' value='A' onclick='insert_tag("txt", "<a  class=\"atxt\" target=\"_blank\"" href=http://metapoznanie.ru  >", "</a>")' title='Ссылка' />
  	<input class="btn" type='button' id='edb116' value='<' onclick='insert_tag("txt", "<span >", "</span>")' title='span' />

    <input class="btngrey" type='button' id='edb117' value=' <' onclick='insert_tag("txt", "<span class=grey >", "</span>")' title='grey' />
    <input class="btnred" type='button' id='edb118' value=' <' onclick='insert_tag("txt", "<span class=red >", "</span>")' title='red' />
    <input class="btnmaroon" type='button' id='edb119' value=' <' onclick='insert_tag("txt", "<span class=maroon >", "</span>")' title='maroon' />
    <input class="btnindigo" type='button' id='edb120' value=' <' onclick='insert_tag("txt", "<span class=indigo >", "</span>")' title='indigo' />

     <!--&nbsp;<input class="btn" type='button' value='br' onclick='insert_tag("txt", "<br />", "")' title='Новая строка' />-->

  	<input class="btn" type='button' id='edb110' value='Н1' onclick='insert_tag("txt", "<h1 class=\"h1txt\">", "</h1>")' title='Название(заголовок) 1' /><input 
  	class="btn" type='button' id='edb111' value='Н2' onclick='insert_tag("txt", "<h2 class=\"h2txt\">", "</h2>")' title='Название(заголовок) 2' /><input 
  	class="btn" type='button' id='edb112' value='Н3' onclick='insert_tag("txt", "<h3 class=\"h3txt\">", "</h3>")' title='Название(заголовок) 3' /><input 
  	class="btn" type='button' id='edb113' value='Н4' onclick='insert_tag("txt", "<h4 class=\"h4txt\">", "</h4>")' title='Название(заголовок) 4' /><input 
  	class="btn" type='button' id='edb114' value='Н5' onclick='insert_tag("txt", "<h5 class=\"h5txt\">", "</h5>")' title='Название(заголовок) 5' /><input 
  	class="btn" type='button' id='edb115' value='Н6' onclick='insert_tag("txt", "<h6 class=\"h6txt\">", "</h6>")' title='Название(заголовок) 6' />


  	<input class="btn" type='button' id='edb1' value='к' onclick='insert_tag("txt", "[к]", "[/к]")' title='Курсив' /><input 
  	class="btn" type='button' id='edb2' value='ж' onclick='insert_tag("txt", "[ж]", "[/ж]")' title='Жирный шрифт' /><input 
  	class="btn" type='button' id='edb3' value='п' onclick='insert_tag("txt", "[п]", "[/п]")' title='Подчёркнуть' /><input
  	 class="btn" type='button' id='edb4' value='з' onclick='insert_tag("txt", "[з]", "[/з]")' title='Зачёркнуть' />
  	<input class="btn" type='button' id='edb5' value='ц' onclick='insert_tag("txt", "[ц]", "[/ц]")' title='Цитата' /><input 
  	class="btn" type='button' id='edb6' value='§' onclick='insert_tag("txt","[§]","[/§]")' title='Параграф' /><input
  	class="btn" type='button' id='edb7' value='ф' onclick='insert_tag("txt", "[ф]", "[/ф]")' title='Форматированный текст' /><input 
  	class="btn" type='button' id='edb8' value='~' onclick='insert_tag("txt","[~]","")' title='Точка обрезки' />
     
  	<input class="btn" type='button' id='edb9' value='A' onclick='insert_tag("txt", "[адрес=http://metapoznanie.ru  /]", "[/a]")' title='Ссылка' />
     <!--&nbsp;<input class="btn" type='button' value='br' onclick='insert_tag("txt", "<br />", "")' title='Новая строка' />-->
     <input class="btn" type='button' id='edb16' value='<' onclick='insert_tag("txt", "[span  /]", "[/span]")' title='span' />
     <input class="btngrey" type='button' id='edb17' value=' ' onclick='insert_tag("txt", "[span class=grey /]", "[/span]")' title='grey' />
     <input class="btnred" type='button' id='edb18' value=' ' onclick='insert_tag("txt", "[span class=red /]", "[/span]")' title='red' />
     <input class="btnmaroon" type='button' id='edb19' value=' ' onclick='insert_tag("txt", "[span class=maroon /]", "[/span]")' title='maroon' />
     <input class="btnindigo" type='button' id='edb20' value=' ' onclick='insert_tag("txt", "[span class=indigo /]", "[/span]")' title='indigo' />

  	<input class="btn" type='button' id='edb10' value='Н1' onclick='insert_tag("txt", "[Н1]", "[/Н1]")' title='Название(заголовок) 1' /><input 
  	class="btn" type='button' id='edb11' value='Н2' onclick='insert_tag("txt", "[Н2]", "[/Н2]")' title='Название(заголовок) 2' /><input 
  	class="btn" type='button' id='edb12' value='Н3' onclick='insert_tag("txt", "[Н3]", "[/Н3]")' title='Название(заголовок) 3' /><input 
  	class="btn" type='button' id='edb13' value='Н4' onclick='insert_tag("txt", "[Н4]", "[/Н4]")' title='Название(заголовок) 4' /><input 
  	class="btn" type='button' id='edb14' value='Н5' onclick='insert_tag("txt", "[Н5]", "[/Н5]")' title='Название(заголовок) 5' /><input 
  	class="btn" type='button' id='edb15' value='Н6' onclick='insert_tag("txt", "[Н6]", "[/Н6]")' title='Название(заголовок) 6' />
	<input class="btn" type='button' id='edb16' value='Дата' onclick='insert_tag("txt", formatDate(new Date()), "")' title='Дата' />
	  	
	<input id="ck_bb" class="btn" type='checkbox' value='ББ?' title='Заменять ББ коды?' onclick='rpl_buttons()' <?php echo $stbb; ?> /> 
  	</td></tr>
	</table>

<textarea class="ed" id="txt" name="txt" maxlength="65530" placeholder="Текст сообщения">
<?php echo $txt; ?>
</textarea>


<br/><br/>
   <table class="ed"> <col width="25%">

		<tr><td class="l"><h3>Кратко</h3>
 		</td><td class="r">
		
	<!--// Вывод кнопок редактирования-->

  	<input class="btn" type='button' id='edb151' value='i' onclick='insert_tag("txt2", "<i>", "</i>")' title='Курсив' /><input 
  	class="btn" type='button' id='edb152' value='b' onclick='insert_tag("txt2", "<b>", "</b>")' title='Жирный шрифт' /><input 
  	class="btn" type='button' id='edb153' value='u' onclick='insert_tag("txt2", "<u>", "</u>")' title='Подчёркнуть' /><input
  	 class="btn" type='button' id='edb154' value='з' onclick='insert_tag("txt2", "<del>", "</del>")' title='Зачёркнуть' />
  	 
  	<input class="btn" type='button' id='edb155' value='ц' onclick='insert_tag("txt2", "<blockquote class=\"bctxt\">", "</blockquote>")' title='Цитата' /><input 
  	class="btn" type='button' id='edb156' value='ф' onclick='insert_tag("txt2", "<pre class=\"pretxt\">", "</pre>")' title='Форматированный текст' />
  	
  	<input class="btn" type='button' id='edb157' value='Н4' onclick='insert_tag("txt2", "<h4 class=\"h4txt\">", "</h4>")' title='Название(заголовок) 4' /><input 
  	class="btn" type='button' id='edb158' value='Н5' onclick='insert_tag("txt2", "<h5 class=\"h5txt\">", "</h5>")' title='Название(заголовок) 5' /><input 
  	class="btn" type='button' id='edb159' value='Н6' onclick='insert_tag("txt2", "<h6 class=\"h6txt\">", "</h6>")' title='Название(заголовок) 6' />



  	<input class="btn" type='button' id='edb51' value='к' onclick='insert_tag("txt2", "[к]", "[/к]")' title='Курсив' /><input 
  	class="btn" type='button' id='edb52' value='ж' onclick='insert_tag("txt2", "[ж]", "[/ж]")' title='Жирный шрифт' /><input 
  	class="btn" type='button' id='edb53' value='п' onclick='insert_tag("txt2", "[п]", "[/п]")' title='Подчёркнуть' /><input
  	 class="btn" type='button' id='edb54' value='з' onclick='insert_tag("txt2", "[з]", "[/з]")' title='Зачёркнуть' />
  	 
  	<input class="btn" type='button' id='edb55' value='ц' onclick='insert_tag("txt2", "[ц]", "[/ц]")' title='Цитата' /><input 
  	class="btn" type='button' id='edb56' value='ф' onclick='insert_tag("txt2", "[ф]", "[/ф]")' title='Форматированный текст' />
  	
  	<input class="btn" type='button' id='edb57' value='Н4' onclick='insert_tag("txt2", "[Н4]", "[/Н4]")' title='Название(заголовок) 4' /><input 
  	class="btn" type='button' id='edb58' value='Н5' onclick='insert_tag("txt2", "[Н5]", "[/Н5]")' title='Название(заголовок) 5' /><input 
  	class="btn" type='button' id='edb59' value='Н6' onclick='insert_tag("txt2", "[Н6]", "[/Н6]")' title='Название(заголовок) 6' />
  	
  	</td></tr>
	</table>

<textarea class="ed" id="txt2" name="txt2" maxlength="2048" placeholder="Кратко">
<?php echo $about; ?>
</textarea>
    <br/>
    <br/>

<h3>Краткое описание</h3>
 <textarea class="ed2" id="txt3" name="txt3" maxlength="250" placeholder="Description">
<?php echo $description; ?>
</textarea>


</div>
<script type="text/javascript"> 

	var Tid = 0;
	var Msg = "";
	var aMsg;


	//
	// Сохранить текст в БД
	//
	function editOK()
	{ 
		Msg = xmlhttp.responseText;
//		alert(Msg);
		
		if (Tid == 0)
		{
			aMsg = Msg.split(',');
			document.getElementById("tid").value = aMsg[1];
			document.getElementById("err").innerHTML = aMsg[0];
		}
		else
			document.getElementById("err").innerHTML = Msg;
	};
	
	function save() 
	{
		onOK=editOK;
		
		nik = document.getElementById("ssnick").innerHTML;
		
		var t = document.getElementById("txt").value;
		var t2 = document.getElementById("txt2").value;
        var t3 = document.getElementById("txt3").value;
//		t = t.replace(/\n/g, '<br />');

		ero("");

		Tid = document.getElementById("tid").value;
		if (Tid == 0)
		{
			dt = new Date();
    	    wdt = formatDate(dt);
			document.getElementById("dt").value = wdt;
		}
		else
		{
			wdt = document.getElementById("dt").value;
		}

		// Заменять ли бб-коды при записи
		if (document.getElementById("ck_bb").checked == true)
			bb = "BBYes";
		else	
			bb = "BBNo";

        // Помещать ли текст в карту сайта
        if (document.getElementById("ck_tositemap").checked == true)
            sm = "1";
        else
            sm = "0";

        var params =
			'header=' + encodeURIComponent(document.getElementById("header").value)+
			'&dt=' + encodeURIComponent(wdt)+
			'&user=' + encodeURIComponent(document.getElementById("user").value)+
			'&user_id=' + encodeURIComponent(document.getElementById("man_id").innerHTML)+
			'&category=' + encodeURIComponent(document.getElementById("category").value)+
			'&url=' + encodeURIComponent(document.getElementById("url").value)+
			'&tags=' + encodeURIComponent(document.getElementById("tags").value)+
            '&description=' + encodeURIComponent(t3)+
			'&tid=' + encodeURIComponent(Tid)+
			'&bb=' + encodeURIComponent(bb)+
            '&sm=' + encodeURIComponent(sm)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)+
			'&nik=' + encodeURIComponent(nik)+
			'&about=' + encodeURIComponent(t2)+
			'&content=' + encodeURIComponent(t)
		;

        doquery ("/php/do-blog-editor.php", params, deftimeout);
		
		return false;
    }
   
	//
	// Показать как будет выглядеть текст
	//
	function testTxt() 
	{
		document.getElementById("show-txt").innerHTML = xmlhttp.responseText;
		document.getElementById("show-edtxt").innerHTML = xmlhttp.responseText;
		document.getElementById("show-txt").hidden = false;
		document.getElementById("show-edtxt").hidden = false;
	}
	function txtShow(mode) {

		onOK=testTxt;

		document.getElementById("btnRet").hidden = false;

		var t = document.getElementById("txt").value;
//		t = t.replace(/\n/g, '<br />');
		if (!document.getElementById("ck_bb").checked) 
	 		if (mode == 'check') 
				mode = 'asis';
		
		var params = 
			'&tid=' + encodeURIComponent(mode)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)+
			'&content=' + encodeURIComponent(t)
		;
		 
		doquery ("/php/do-blog-editor.php", params, deftimeout);
		return;
		
		document.getElementById("show-txt").innerHTML = 
			'БУДЕТ ТАК:<h2>'+document.getElementById("header").value+'</h2>'+t;

		document.getElementById("show-txt").hidden = false;
    }
	function txtHide() {
		document.getElementById("show-edtxt").hidden = true;
		document.getElementById("show-txt").hidden = true;
		document.getElementById("btnRet").hidden = true;
    }


	//
	//
	//
	function setURL() {
		document.getElementById("url").value = mkURL(document.getElementById("header").value);
	}

	//
	// Изготовить список категорий для выбора
	//
	function catFolders()
	{ 
		document.getElementById("category").innerHTML = xmlhttp.responseText;
	};
	function getCats() 
	{
		onOK=catFolders;

		document.getElementById("category").innerHTML = "";
		var params = 
			'&mode=' + encodeURIComponent("select")+
			'&category=' + encodeURIComponent(document.getElementById("cat_name").innerHTML)
		 ;
		 
		doquery ("/php/do-cats.php", params, deftimeout);
		
		return false;
    }
     
	//
	// Новый или корректировка?
	// Инициализировать переменную и заголовок страницы
	// неудачно функция названа, а как лучше незвать не придумал
	//
	function get_txt()
	{
		if (edform.tid.value == "") 
			Tid = 0;	
		else	
			Tid = edform.tid.value;	
			
		if (Tid == 0)
			document.getElementById("h21").innerHTML = "Новая запись";
		else
			document.getElementById("h21").innerHTML = "Изменение записи";
	}
     
	//
	// Заменять ББ коды и т.д. или оставить текст КАК ЕСТЬ
	//
	function asis2()
	{
		v = document.getElementById("btnasis").Value;
		alert(v);
		if (v = "Как есть")
			document.getElementById("btnasis").Value = "Заменять ББ коды";
		else	
			document.getElementById("btnasis").Value = "Как есть";
	}
     
// 	setTimeout('getCats()', 1000); 
</script>






    <div class="divtxt">
	<table class="ed"> 	<col width="15%">
        <tr><td class="l"> ... </td>
        <td class="r">
            <input id="ck_tositemap" class="btn" type='checkbox' value='В карту?' title='Помещать в карту сайта?' <?php echo $tositemap; ?> />
            Поместить текст в карту сайта
        </td></tr>

		<tr><td class="l">Тэги</td>
    	<td class="r"><input class='text' type='text' name='tags' id='tags' value='<?php echo $tags; ?>' maxlength='250' title='Ключевые слова'/></td></tr>
	    
	    <tr><td class="l">Адрес</td>
    	<td class="r"><input class='text ro' type='text' name='url' id='url' value='<?php echo $url; ?>' title='URL' /></td></tr>
    	
    	<tr><td class="l">Автор</td>
    	<td class="r">
    	<input class='text ro' type='text' name='user' id='user' value='<?php echo $nik; ?>' readonly/>
    	</td></tr>

		<tr><td class='l'>Время</td>
		<td class='r'><input class='ro' type='text' name='dt' id='dt' value='<?php echo $dt; ?>' readonly /></td></tr>

		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd' id='passwd' /></td></tr>
 	
	 	<tr><td class="l">&nbsp;</td><td class="r">
 		<input class="btn" type="button" value="Отправить" onclick="return save()" />x
 		<input class="btn" type="button" value="Показать как будет" onclick="txtShow('check')"/>x
 		<input class="btn" type="button" value="BB" onclick="txtShow('BB')"/>x
 		<input class="btn" type="button" value="HTML" onclick="txtShow('HTML')"/>x
 		<input class="btn" type="button" value="Не показывать" onclick="txtHide()" id="btnRet" hidden="false"/>
 		</td></tr>
    </table>
 </div>
</form>
<br/>

<div class="divtxt" id="show-txt" hidden="true"></div>
<textarea class="ed" id="show-edtxt" name="edtxt" maxlength="65530" hidden="true">

<?php echo $txt; ?>
</textarea>
<div id="err" ></div>

</div> <!-- СЕРЕДИНА -->

<!-- ================================ ПРАВАЯ КОЛОНКА ========================================= -->

<div class="rightcol"> <!-- ПРАВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-right-text.php" ?>

</div> <!-- ПРАВАЯ КОЛОНКА -->
</div> <!-- WRAPPER -->

<!-- ================================ НИЗ ========================================= -->

<script type="text/javascript"> 
	getCats();
	get_txt();
	rpl_buttons();
</script>

<div class="footer">

<?php include "../mpcms/itis-footer.php" ?>

</div>



</body>
</html>