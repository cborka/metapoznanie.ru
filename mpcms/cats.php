<?php
require_once "../php/init_php.php";
require_once "../php/init_db.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Категории</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="stylesheet" href="../css/mp.css?<?php echo $ver; ?>">

	<script type="text/javascript" language="javascript" src="/js/a-lib.js?<?php echo $ver; ?>"></script>
</head>
<body>


<!-- =================================== ШАПКА ===================================== -->
<div class="head"> <!-- ШАПКА -->

<?php include "../mpcms/itis-header.php" ?>

</div> <!-- ШАПКА -->

<!-- ================================ СЕРЕДИНА ПО ВЕРТИКАЛИ ======================== -->
<div class="wrapper_1">
<div class="leftcol"> <!-- ЛЕВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-left-index.php" ?>

</div> <!-- ЛЕВАЯ КОЛОНКА -->


<!-- =============================== ЦЕНТР, ОСНОВНАЯ ИНФА ========================== -->
<div class="center"> 


<h2>Категории</h2>

<div id="cats"></div>

<?php	if ($ss_nick == 'Admin') { ?>
<script type="text/javascript"> 

	var catRf = "";

	function writeOK()
	{ 
		document.getElementById("err").innerHTML = xmlhttp.responseText;
		show();
	};
	
	function catShow()
	{ 
		document.getElementById("cats").innerHTML = xmlhttp.responseText;
	};

	function catFolders()
	{ 
//		alert(xmlhttp.responseText);
		document.getElementById("folder").innerHTML = xmlhttp.responseText;
//		document.getElementById("folder").innerHTML = '2222222222222222222222222222';
	};
	
	//
	// Записать категорию в БД
	//
	function save() {

		document.getElementById("err").innerHTML = "";

		onOK=writeOK;
		
		var params = 
			'&mode=' + encodeURIComponent("write")+
			'&cat_id=' + encodeURIComponent(document.getElementById("cat_id").value)+
			'&category=' + encodeURIComponent(document.getElementById("category").value)+
			'&folder=' + encodeURIComponent(document.getElementById("folder").value)+
			'&about=' + encodeURIComponent(document.getElementById("about").value)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		;
//	 alert(params);				 
		q_is_async = false; 
		doquery ("../php/do-cats.php", params, deftimeout);
		
		return false;
    }
   
	//
	// Вывод всех категорий для просмотра
	//
	function show() 
	{
		onOK=catShow;

		document.getElementById("cats").innerHTML = "";

		var params = 
			'&mode=' + encodeURIComponent("show")
		 ;
		 
		q_is_async = false; 
		doquery ("../php/do-cats.php", params, deftimeout);
		
		return false;
    }

	//
	// Формирование опции select для выбора категории
	//
	function getCats() 
	{
		onOK=catFolders;

		document.getElementById("folder").innerHTML = "";

		var params = 
			'&category=' + encodeURIComponent(catRf)+
			'&mode=' + encodeURIComponent("select")
		 ;
//		 alert(params);
		q_is_async = false; 
		doquery ("../php/do-cats.php", params, deftimeout);
		
		return false;
    }
    
	//
	// Редактировать категорию
	//
	function edit_cat(id, cname, cfolder) 
	{
		newcat.cat_id.value = id;		
		newcat.category.value = cname;	
		catRf = cfolder;

		getCats();	
		show_cat_about(id);	
    }

  	function aboutCatShow() 
	{ 
		document.getElementById("about").value = xmlhttp.responseText;
	};
	function show_cat_about(id) // Вывожу краткую инфу о тексте
	{
		ero("");
		onOK=aboutCatShow;
		
		var params = 
			'&mode=show_cat_about'+
			'&cat_id=' + encodeURIComponent(id)
		;
				 
//		q_is_async = false; 
		doquery ("/php/do-cats.php", params, deftimeout);
		return false;
    }
   
//  show(); 
//	setTimeout('getCats()', 3000); 
     
</script>

<br/>
<form name="newcat" action="" method="post" onsubmit="return save()">

    <table class="ed"> <col width="25%">
		<tr><td class="l">Категория</td>
		<td class="r">
		<input class='text' type='text' name='category' id='category' value='' maxlength='80' required />
		</td></tr>
		
		<tr><td class="l">Id</td>
		<td class="r">
		<input class='num ro' type='text' name='cat_id' id='cat_id' value='0' maxlength='5' readonly="true" />
		</td></tr>
		<tr><td class="l">Входит в</td><td class="r"><select size="1" name='folder' id='folder'></select>
		</td></tr>
		
		<tr><td class="l">О категории</td>
		<td class="r">
<!--		<input class='text' type='text' name='about' id='about' value='' maxlength='100' />-->
            <textarea class="ed2" id="about" name="about" maxlength="4096" placeholder="О категории">
            </textarea>

		</td></tr>

		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd' id='passwd' value='' maxlength='80' required /></td></tr>
		
		<tr><td class="l">&nbsp;</td><td class="r"></td></tr>
		
		<tr><td class="l" colspan="2"> 	
			<input type="submit" value="Записать" />
<!--			<input type="button" value="Обновить список" onclick="return show()"/>-->
			<input type="button" value="Новая"  title="Добавить новую категорию" onclick="edit_cat(0, '', '')"/>
			&nbsp;<span id="err"></span>
		</td></tr>

	</table>
</form>
<?php	} ?>
<br/>
<br/ >
<a href="/">[ На главную ]</a>
<br/>




</div> <!-- СЕРЕДИНА -->

<!-- ================================ ПРАВАЯ КОЛОНКА =============================== -->

<div class="rightcol"> <!-- ПРАВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-right-blog.php" ?>

</div> <!-- ПРАВАЯ КОЛОНКА -->

</div> <!-- WRAPPER -->

<!-- ================================ НИЗ ========================================== -->
<script type="text/javascript"> 
    show(); 
//	getCats(); 
</script>

<div class="footer">

<?php include "../mpcms/itis-footer.php" ?>

</div>



</body>
</html>