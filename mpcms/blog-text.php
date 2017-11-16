
<!-- Это часть страницы blog-index2.php  -->


<div class="divtxt">
	<br/><span class="p mes" id="cats_chain"></span><br/>
</div>

<span id="err"></span>
<div id="cats"></div>

<h3 id="msg">Новый комментарий</h3>

<div id="comments"></div>

<div class="alignleft">
<input type="button" class="aslink11" title="" value="Показать больше комментариев" onclick="return show_comms()"/>
</div>

<div class="alignright">		
<a class="btn11" href="../mpcms/index.php">На главную</a>
</div>

<br/ >
<br/ >
  


<div class="divtxt">
<h3 id="newc">Новый комментарий</h3>
</div>

<form name="edform">

	<span id="cat_name" hidden><?php echo $cat_name; ?></span>
<div class="divtxt">
    <table class="ed"> <col width="25%">

		<tr><td class="l">
			<input class='inf1' type='text' name='tid' id='tid' 
    		value='<?php echo $tid; ?>' 
    		maxlength='5' readonly /><input class='inf1' type='text' name='user_id' id='user_id' 
    		value='<?php echo $_SESSION['ss_user_id']; ?>' 
    		maxlength='5' readonly /><input class='inf1' type='text' name='cid' id='cid' 
    		value='0' maxlength='5' readonly />
 		</td><td class="r">
		
	<!--// Вывод кнопок редактирования-->
  	<input class="btn" type='button' value='к' onclick='insert_tag("txt", "[к]", "[/к]")' title='Курсив' /><input 
  	class="btn" type='button' value='ж' onclick='insert_tag("txt", "[ж]", "[/ж]")' title='Жирный шрифт' /><input 
  	class="btn" type='button' value='п' onclick='insert_tag("txt", "[п]", "[/п]")' title='Подчёркнуть' /><input
  	 class="btn" type='button' value='з' onclick='insert_tag("txt", "[з]", "[/з]")' title='Зачёркнуть' />
  	 
  	<input class="btn" type='button' value='ц' onclick='insert_tag("txt", "[ц]", "[/ц]")' title='Цитата' /><input 
  	class="btn" type='button' value='ф' onclick='insert_tag("txt", "[ф]", "[/ф]")' title='Форматированный текст' />
  	
  	<input class="btn" type='button' value='Н4' onclick='insert_tag("txt", "[Н4]", "[/Н4]")' title='Название(заголовок) 4' /><input 
  	class="btn" type='button' value='Н5' onclick='insert_tag("txt", "[Н5]", "[/Н5]")' title='Название(заголовок) 5' /><input 
  	class="btn" type='button' value='Н6' onclick='insert_tag("txt", "[Н6]", "[/Н6]")' title='Название(заголовок) 6' />
	
  	</td></tr>
	</table>

<textarea class="ed" id="txt" name="txt" maxlength="65530" placeholder="Текст комментария"></textarea>
</div>

<?php 
echo 
'<script type="text/javascript"> 
    get_cats_chain_for_txt("'.$tid.'");
	show_txt("'.$tid.'");
	show_cats_about("'.$tid.'");
	show_about("'.$tid.'");
	
	
	get_comm_ids();
	show_comms();
</script>';
?>

<script type="text/javascript"> 

	var Msg = "";
	var aMsg;

	//
	// Сохранить комментарий в БД
	//
	function editOK()
	{ 
		document.getElementById("err2").innerHTML = xmlhttp.responseText;
//		location.reload();
	};
	
	function save() 
	{
		onOK=editOK;
		
//		document.getElementById("err2").innerHTML = document.getElementById("txt").value;
//		alert(document.getElementById("err").innerHTML);

		
		var t = document.getElementById("txt").value;
//		t = t.replace(/\n/g, '<br />'); 

		ero("");
	
		dt = new Date();
   	    wdt = formatDate(dt);

		var params = 
			'&mode=write_comment' + 
			'&dt=' + encodeURIComponent(wdt)+
			'&comm_rf=0' + 
			'&comm_id=' + encodeURIComponent(document.getElementById("cid").value)+
			'&user_id=' + encodeURIComponent(document.getElementById("user_id").value)+
			'&tid=' + encodeURIComponent(document.getElementById("tid").value)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)+
			'&nik=' + encodeURIComponent(document.getElementById("ssnick").innerHTML)+
			'&content=' + encodeURIComponent(t)
		;
//		document.getElementById("err2").innerHTML = params;
//		return;
		 
		doquery ("/php/do-blog-editor.php", params, deftimeout);
		
		return false;
    }
	function ed_comm(cid)
	{ 
		document.getElementById("cid").value = cid;
		if (cid == 0)
		{
			document.getElementById("newc").innerHTML = 'Новый комментарий';
			document.getElementById("txt").value = '';
		}
		else
		{
			document.getElementById("newc").innerHTML = 'Редактирование комментария №'+cid;
			get_ctext(cid);
//			document.getElementById("txt").value = document.getElementById("ct"+cid).innerHTML;
		}
	}
	
	function getCtext()
	{ 
		document.getElementById("txt").value = xmlhttp.responseText;
//		location.reload();
	};
	function get_ctext(cid) 
	{
		onOK=getCtext;
		
		var t = document.getElementById("txt").value;
//		t = t.replace(/\n/g, '<br />'); 

		ero("");
	
		var params = 
			'&mode=get_ctext' + 
			'&comm_id=' + encodeURIComponent(cid)
		;
		 
		doquery ("/php/do-blog-editor.php", params, deftimeout);
		
		return false;
    }
   
</script>

<div class="divtxt">
	<table class="ed"> 	<col width="15%">
    	
    	<tr><td class="l">Автор</td>
    	<td class="r">
    	<input class='text ro' type='text' name='user' id='user' value='<?php echo $_SESSION['ss_nick']; ?>' readonly/>
    	</td></tr>

		<tr><td class='l'>Время</td>
		<td class='r'><input class='ro' type='text' name='dt' id='dt' value='<?php echo gmdate("Y-m-d h:i:s", strtotime("+6 hours")); ?>' readonly /></td></tr>

		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd' id='passwd' /></td></tr>
 	
	 	<tr><td class="l">&nbsp;</td><td class="r">
 		<input class="btn" type="button" value="Отправить" onclick="return save()" />
		<input class="btn" type="button" id="edc" value="Новый" title="Добавить новый комментарий" onclick="ed_comm(0)" />

 		</td></tr>
    </table>
 </div>
</form>
<br/>

<div class="divtxt" id="show-txt" hidden="true"></div>

<div id="err2"></div>
<br/>

<script type="text/javascript"> 
//	getCats();
//	get_txt();
</script>
