<!DOCTYPE html>
<html>
<head>
	<title>Пользователи</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="stylesheet" href="/css/mp.css">
	<style>	</style>

	<script type="text/javascript" language="javascript" src="/js/a-lib.js"></script>
</head>
<body>


<!-- =================================== ШАПКА ===================================== -->
<div class="head"> <!-- ШАПКА -->

<?php include "../mpcms/itis-header.php" ?>

</div> <!-- ШАПКА -->

<!-- ================================ СЕРЕДИНА ПО ВЕРТИКАЛИ ======================== -->
<div class="wrapper_1">
<div class="leftcol"> <!-- ЛЕВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-left.php" ?>

</div> <!-- ЛЕВАЯ КОЛОНКА -->


<!-- =============================== ЦЕНТР, ОСНОВНАЯ ИНФА ========================== -->
<div class="center"> 


<h2>Пользователи</h2>

<div id="cats"></div>

<script type="text/javascript"> 

	function manShow()
	{ 
		document.getElementById("cats").innerHTML = xmlhttp.responseText;
	};

	//
	// Вывод всех пользователей для просмотра
	//
	function show_mans() 
	{
		onOK=manShow;
//alert("hhh");
		document.getElementById("cats").innerHTML = "";

		var params = 
			'&mode=' + encodeURIComponent("show")+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		 ;
		 
		q_is_async = false; 
		doquery ("/php/do-mans.php", params, deftimeout);
		
		return false;
    }

     
</script>

<br/>
<?php	if ($ss_nick == 'Admin') { ?>
<form name="mansss">

    <table class="ed"> <col width="25%">
	
		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd' id='passwd' /></td></tr>

	 	<tr><td class="l">&nbsp;</td><td class="r">
 		<input type="button" class="lnk2" value="[Показать]" onclick="show_mans()" />
  		</td></tr>

	</table>
</form>
<?php	} ?>



<br/>
<br/ >
<a href="/index.php">[На главную]</a>
<br/>




</div> <!-- СЕРЕДИНА -->

<!-- ================================ ПРАВАЯ КОЛОНКА =============================== -->

<div class="rightcol"> <!-- ПРАВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-right.php" ?>

</div> <!-- ПРАВАЯ КОЛОНКА -->

</div> <!-- WRAPPER -->

<!-- ================================ НИЗ ========================================== -->

<div class="footer">

<?php include "../mpcms/itis-footer.php" ?>

</div>

</body>
</html>