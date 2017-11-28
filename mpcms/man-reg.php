<?php
require_once "../php/init_php.php";
require_once "../php/init_db.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="stylesheet" href="../css/mp.css?<?php echo $ver; ?>">
	<style>	</style>

	<script type="text/javascript" language="javascript" src="../js/a-lib.js?<?php echo $ver; ?>"></script>
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


<h2>Регистрация</h2>

<div id="cats"></div>

<script type="text/javascript"> 

	function writeOK()
	{ 
		document.getElementById("err").innerHTML = xmlhttp.responseText;
	};
	onOK=writeOK;
	
	function save() 
	{
		ero("");
/*		
		if (manreg.nik.value.length < 3)
		{
    		ero("Ник слишком короткий!");
			return false;
		} 
		if (manreg.passwd1.value != manreg.passwd2.value)
		{
			ero("Пароли не совпадают.");
			return false;
		}
*/
		if (!check_passwd()) return false;
		if (!check_nik()) return false;
		if (!check_email()) return false;
		
		var params = 
			'&mode=' + encodeURIComponent("write")+
			'&nik=' + encodeURIComponent(document.getElementById("nik").value)+
			'&passwd1=' + encodeURIComponent(document.getElementById("passwd1").value)+
			'&email=' + encodeURIComponent(document.getElementById("email").value)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		;
		doquery ("../php/do-mans.php", params, deftimeout);
		
		return false;
    }
   
	function check_nik() 
	{
		ero("");

		if (manreg.nik.value.length < 3)
		{
    		ero("Ник слишком короткий!");
			return false;
		} 
/*
		var params = 
			'&mode=' + encodeURIComponent("check_nik")+
			'&nik=' + encodeURIComponent(document.getElementById("nik").value)
		;
		doquery ("../php/do-mans.php", params, deftimeout);
*/
		return true;
	}

	function check_email() 
	{
		ero("");
/*
		var params = 
			'&mode=' + encodeURIComponent("check_email")+
			'&email=' + encodeURIComponent(document.getElementById("email").value)
		;
		doquery ("../php/do-mans.php", params, deftimeout);
*/		
		return true;
	}

	function check_passwd() 
	{
		if (manreg.passwd1.value != manreg.passwd2.value)
		{
			ero("Пароли не совпадают.");
			return false;
		}
		return true;
	} 
     
</script>

<br/>

<!--<form name="manreg" action="" method="post" onsubmit="return save()" >-->
<form name="manreg" >

    <table class="ed"> <col width="35%">
    
		<tr><td class="l">Ник</td><td class="r"><input class='text' type='text' name='nik' id='nik' value='x' maxlength='80' required onchange="check_nik(this.value)" /></td></tr>
		
		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd1' id='passwd1' value='x' maxlength='80' required /></td></tr>
		
		<tr><td class="l">Подтверждение пароля</td><td class="r"><input class='text' type='password' name='passwd2' id='passwd2' value='x' maxlength='80' required onchange="check_passwd()" /></td></tr>

		<tr><td class="l">Почта</td><td class="r"><input class='text' type='text' name='email' id='email' value='x' maxlength='80' required  onchange="check_email()"/></td></tr>
		
		<tr><td class="l">Два умножить на два (цифра) =</td><td class="r"><input class='text' type='text' name='passwd' id='passwd' value='7' maxlength='80' required /></td></tr>
		
		<tr><td class="l">&nbsp;</td><td class="r"></td></tr>
		
		<tr><td class="l" colspan="2"><input type="button" value="Отправить" onclick="return save()" />&nbsp;<span id="err"></span></td></tr>

		</table>

</form>

<br/>

<!--<div id="err" >&nbsp;</div>-->

<br/ >
<a href="/index.php">[ На главную ]</a>
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