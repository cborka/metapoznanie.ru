<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";

//echo "Abs:".$_SERVER['DOCUMENT_ROOT'].".<br/>";
//exit;

// global $ss_nick;

$ss_out1 = "
	<form name=\"reg\" method=\"post\" \>";
$ss_out2 = "<input class='logname' type='text' hidden='hidden' name='ss_logout' id='ss_logout' value='ss_logout' />
	<br />
	<input class='aslink' type=\"submit\" value=\"Выйти\"  />
	| <a class='btn' href=\"/mpcms/man-profile.php\" title=\"Личный кабинет\">ЛК</a></form>
	";	
$ss_in = "
	<form name=\"reg\" method=\"post\" \>
		<input class='logname' type='text' name='ss_nick' id='ss_nick' placeholder='Имя' />
<br />		
		<input class='logname' type='password' name='ss_passwd' id='ss_passwd' placeholder='Пароль'/>
<br />
<div class='logbuttons'>
		<span class='logname' id='ssnick'></span>
		<input class='aslink' type=\"submit\" value=\"Войти\" /> | <a class='btn' href=\"/mpcms/man-reg.php\" title=\"Зарегистрироваться на сайте\">Регистрация</a>
</div>
	</form>
	";

function nik($nick)
{
	if ($nick == 'Admin')
	{
		return '<br /><span class="lognameadmin" id="ssnick">'.$nick.'</span>';
	}
	else
	{
		return '<br /><span class="lognameuser" id="ssnick">'.$nick.'</span>';
	}
}

//	session_start(); // Должна быть до того как что-то ещё выводится, поэтому перенёс в itis-header.php
	
if (isset($_POST['ss_nick']))  // Отправлено из формы, заходим на сайт
{
//	echo "Отправлено из формы";
	$ss_nick = input_filter($_POST['ss_nick']);
	$ss_passwd = input_filter($_POST['ss_passwd']);
	$okey = TRUE;
	
	// Проверка
	$ss_msg = "";
	$sql = "
		SELECT user_id, logname, password, reg_dt, reg_ip, email 
			FROM mp_users
			WHERE logname = \"".$ss_nick."\"
	";
	if (($okey) && (!($q=mysql_query($sql))))
	{
	  	$ss_msg = "<span class='err'>log-in: Ошибка: ".mysql_error()."</span>";
		$okey = FALSE;
	}
	if (($okey) && (mysql_num_rows($q) == 0))
	{
		$ss_msg = "<span class='err'>Неверное имя или пароль.</span>";
		$okey = FALSE;
	}

	if ($okey)
	{
		$f = mysql_fetch_array($q);

		$true_pass = $f[password];
		if (($true_pass != md5($ss_passwd.$f[reg_dt].$f[reg_ip])) and ($true_pass != $ss_passwd))
		{
			$ss_msg = "<span class='err'>-Неверное имя или пароль.</span>";
			$okey = FALSE;
		}	
	}

	// УФФ ЗАШЛИ ...
	// $ret = $ret . format4($f[man_id], $f[nik], $f[parol], $f[reg_date], $f[reg_ip], $f[email]);
 
	if ($okey)
	{

		$_SESSION['ss_nick'] = $ss_nick;
//		$_SESSION['ss_passwd'] = $ss_passwd;
	    $_SESSION['ss_man_id'] = $f[user_id];
	    $_SESSION['ss_user_id'] = $f[user_id];
		
	    $_SESSION['ss_ip'] = $_SERVER['REMOTE_ADDR'];
//	    $_SESSION['ss_logintime'] = ;

//echo $_SESSION['dtb'].'-'.$_SESSION['dte']."{{{}}}";
	    $_SESSION['dtb'] = '2014-04-25';
	    $_SESSION['dte'] = date('Y-m-d');;
	    $_SESSION['srtt'] = 'Новые';
	    $_SESSION['srtk'] = 'СКомментариями';

		$ss_msg = $ss_out1.nik($ss_nick).$ss_out2;
	}
	else
	{
		unset($_POST['ss_nick']);
		$ss_msg = $ss_in.$ss_msg;
	}	
}
else if (isset($_POST['ss_logout']))  // Завершение сессии
{
//	echo "Завершение сессии";
	
	unset($_SESSION['ss_nick']);

	$ss_msg = $ss_in;

	session_destroy();
}
else if (isset($_SESSION['ss_nick'])) // Сессия уже открыта
{
//	echo "Сессия уже открыта";
	$ss_nick = $_SESSION['ss_nick'];

	$ss_msg = $ss_out1.nik($ss_nick).$ss_out2;
}
else // Ввод данных из формы, войти на сайт
{
	$ss_msg = $ss_in;
}

$ss_nick = $_SESSION['ss_nick'];


echo "<span id='ssmsg'>".$ss_msg."</span>";
?>

