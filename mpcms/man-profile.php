<!DOCTYPE html>
<html>
<head>
	<title>Пользователь</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="stylesheet" href="../css/mp.css">

	<script type="text/javascript" src="/js/a-lib.js"></script>
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
<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";


//
// Получение сведений о пользователе
//
    global $n, $uid, $mail, $info;


	if (! isset($_SESSION['ss_user_id']))
		$uid = '0';
	else
		$uid = $_SESSION['ss_user_id'];
	
	$sql = "
		SELECT  email, info 
			FROM mp_users
			WHERE user_id = ". $uid 	
	;
	if (!($q=mysql_query($sql))) 
	{
		$txt = 'get_user_for_edit: Ошибка: ' . mysql_error();
		return;
	}
	$n = mysql_num_rows($q);

	if ($n != 1)
	{
		$uid = '0';
		$info = '';
	}
	else
	{
		$f = mysql_fetch_array($q);
		
		$mail = $f[email];
		$info = $f[info];
	}
?>
<div class="center"> 


<div class="divtxt">
<h2>Личный кабинет</h2>
</div>

<?php	if (true) { ?>
<script type="text/javascript"> 

	var catRf = "";

   
	function writeOK()
	{ 
		document.getElementById("err").innerHTML = xmlhttp.responseText;
	};
	onOK=writeOK;
	
	function save() 
	{
		ero("");

		if (!check_passwd()) return false;
		if (!check_email()) return false;
		
		var params = 
			'&mode=' + encodeURIComponent("update")+
			'&nik=' + encodeURIComponent(document.getElementById("nik").value)+
			'&passwd1=' + encodeURIComponent(document.getElementById("passwd1").value)+
			'&email=' + encodeURIComponent(document.getElementById("email").value)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)+
			'&info=' + encodeURIComponent(document.getElementById("info").value)
		;
		doquery ("../php/do-mans.php", params, deftimeout);
		
		return false;
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
		if (userform.passwd1.value != userform.passwd2.value)
		{
			ero("Пароли не совпадают.");
			return false;
		}
		return true;
	} 
     
</script>

<br/>
<form name="userform" action="" method="post" onsubmit="return save()">

    <table class="ed"> <col width="35%">
    
		<tr><td class="l">Ник</td><td class="r"><input class='text' type='text' name='nik' id='nik' value='<?php echo $_SESSION['ss_nick']; ?>' maxlength='32' readonly /></td></tr>
		
		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd1' id='passwd1' value='' maxlength='64' /></td></tr>
		
		<tr><td class="l">Подтверждение пароля</td><td class="r"><input class='text' type='password' name='passwd2' id='passwd2' value='' maxlength='64' onchange="check_passwd()" /></td></tr>

		<tr><td class="l">Почта</td><td class="r"><input class='text' type='text' name='email' id='email' value='<?php echo $mail; ?>' maxlength='80' required  onchange="check_email()"/></td></tr>
		
		<tr><td class="l">Информация</td><td class="r"><input class='text' type='text' name='info' id='info' value='<?php echo $info; ?>' maxlength='2048' required /></td></tr>

		<tr><td class="l">Два умножить на два (цифра)</td><td class="r"><input class='text' type='text' name='passwd' id='passwd' value='9' maxlength='80' required /></td></tr>
		
		<tr><td class="l">&nbsp;</td><td class="r"></td></tr>
		
		<tr><td class="l" colspan="2"><input type="button" value="Отправить" onclick="return save()" />&nbsp;<span id="err"></span></td></tr>

		</table>
		
</form>
<?php	} ?>
<br/>
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