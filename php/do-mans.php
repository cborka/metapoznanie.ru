<?php

require_once "../php/init_php.php";
require_once "../php/init_db.php";


//
// Вывод всех категорий для просмотра
//
function get_mans() 
{
	$sql = "
		SELECT user_id, logname, password, reg_dt, reg_ip, email, info 
			FROM mp_users
		ORDER BY reg_dt
	";
	
	if (!($q=mysql_query($sql))) 
	{
    	ero('get_mans: Ошибка: ' . mysql_error() . "\n<br>");
	}
	$ret = '<table class="t"><tr>
	<td><b>ид</b></td>
	<td><b>ник</b></td>
	<td><b>пароль</b></td>
	<td><b>рег-дата</b></td>
	<td><b>рег-ип</b></td>
	<td><b>почта</b></td>
	<td><b>инфо</b></td>
	</tr>';
//	<td><b>пароль</b></td>
//	$ret = '<table class="t"><tr><td><b>id</b></td><td><b>Категория</b></td><td><b>Входит в</b></td></tr>';
	for ($c=0; $c<mysql_num_rows($q); $c++)
	{
		$f = mysql_fetch_array($q);
		$ret = $ret . format4($f[user_id], $f[logname], $f[password], $f[reg_dt], $f[reg_ip], $f[email], $f[info]);
	}
	$ret = $ret ."</table> ";
 
	return $ret;
}

function format4($man_id, $nik, $parol, $reg_date, $reg_ip, $email, $info)
{
	return	'<tr>
		<td>&nbsp;'.$man_id. '</td>
		<td>'.$nik. '</td>
		<td>'.$parol. '</td>
		<td>'.$reg_date. '</td>
		<td>'.$reg_ip. '</td>
		<td>'.$email. '</td>
		<td>'.$info. '</td>
		</tr> ';
//		<td>'.$parol. '</td>
}

function check_ip($ip)
{
	$cnt = do_sql("SELECT count(*) FROM mp_users WHERE reg_ip = '".$ip."' AND reg_dt > CURDATE()");
//	$cnt = 0;
	if ($cnt == "0") 
	{
		if ($_POST['mode'] != "write")
			oke("Ip '".$ip."' годится. ОК.");
		return "1";
	}
	
	if (substr($cnt, 0, 5) == "Error")
	{
		ero($cnt);
		return "0";
	}
	
	ero("Отказано. IP '".$ip."' использовался для регистрации менее суток назад.");
	return "0";
}

function check_nik($nik)
{
	$cnt = do_sql("SELECT count(*) FROM mp_users WHERE logname = '".$nik."'");
	
	if ($cnt == "0")  
	{
		if ($_POST['mode'] != "write")
			oke("Ник '".$nik."' свободен. ОК.");
		return "1";
	}
	
	if (substr($cnt, 0, 5) == "Error")
	{
		ero($cnt);
		return "0";
	}
	
	ero("Ник '".$nik."' занят.");
	return "0";
}

function check_email($email)
{
	$sql = "SELECT count(*) FROM mp_users WHERE email = '".$email."'";
	
	$cnt = do_sql($sql);
	
	if ($cnt == "0") 
	{
		return "1";
	}
	
	if (substr($cnt, 0, 5) == "Error")
	{
		ero($cnt);
		return "0";
	}
	
	ero("Уже есть регистрация с адресом '".$email."'.");
	return "0";
}

//
// Запись новой категории в БД
//
function writenewman()
{
	$nik = $_POST['nik'];
	$passwd = $_POST['passwd1'];
	$email = $_POST['email'];
	$regdate = gmdate("Y-m-d h:i:s", strtotime("+7 hours"));
	$regip = $_SERVER["REMOTE_ADDR"];

	if ("0" == check_nik($nik))  return "0";
	if ("0" == check_email($email))  return "0";
	if ("0" == check_ip($regip))  return "0";
	
	$hpass = md5($passwd.$regdate.$regip);
	$sql = "
		INSERT INTO mp_users (user_id, logname, password, reg_dt, reg_ip, email, info) 
			VALUES (0, '".$nik."','".$hpass."','".$regdate."','".$regip."','".$email."','')"
	;
//	mes($sql);
	$ret = do_update_sql($sql);
	
	if ($ret == "1") { oke("ЗАПИСАНО"); }
	else { ero($ret); }
}

//
// Обновление сведений о пользователе
//
function updateman()
{
	$nik = $_POST['nik'];
	$passwd = $_POST['passwd1'];
	$email = $_POST['email'];
	$info = $_POST['info'];

	if ($passwd <> '')
	{
		$regdate = do_sql("SELECT reg_dt FROM mp_users WHERE logname = '".$nik."'");
		$regip = do_sql("SELECT reg_ip FROM mp_users WHERE logname = '".$nik."'");

		$hpass = md5($passwd.$regdate.$regip);
		$sql = "
			UPDATE mp_users 
				SET password = '".$hpass."', email = '".$email."', info = '".$info."' 
			WHERE logname = '".$nik."'"
		;
	}
	else
	{
		$sql = "
			UPDATE mp_users 
				SET email = '".$email."', info = '".$info."' 
			WHERE logname = '".$nik."'"
		;
	}
	$ret = do_update_sql($sql);
	
	if ($ret == "1") { oke("Обновлено"); }
	else { ero($ret); }
}

//=========================================

$mode = input_filter($_POST['mode']);
$pass = input_filter($_POST['passwd']);

if ($mode == "show")
{
	if ($pass != "432")
		ero("Пароль не верен.");	
	else
		echo get_mans();
}
else if ($mode == "write")
{
	if ($_POST['passwd'] != "4")
		ero("Учи дважды два ...");	
	else
		writenewman();
}
else if ($mode == "update")
{
	if ($_POST['passwd'] != "4")
		ero("Учи дважды два ...");	
	else
		updateman();
}
else if ($mode == "check_nik")
{
	check_nik($_POST['nik']);
}
else if ($mode == "check_email")
{
	check_email($_POST['email']);
}


?>

