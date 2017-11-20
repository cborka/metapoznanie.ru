<?php
$value = 'qwerty asdf zxcv jkl';
//setcookie("TestCookie9", $value, time()+3600);  /* срок действия 1 час */
//setcookie("TestCookie7", '12345', time()+3600);  /* срок действия 1 час */

require "../php/init_php.php";

//
// Здесь тестировал работу сессий и работу с куками,
// выяснил, что сессии испльзуют куки, а куки должны ставится в самом начале страницы
//



$mode = $_GET["mode"];

if ($mode == "start")
{
    session_start();

//    setcookie("TestCookie5", '12345', time()+3600);  /* срок действия 1 час */

    echo "session_status = ".session_status().".<br/>";
    echo "PHP_SESSION_DISABLED = ".PHP_SESSION_DISABLED.".<br/>";
    echo "PHP_SESSION_NONE  = ".PHP_SESSION_NONE .".<br/>";
    echo "PHP_SESSION_ACTIVE = ".PHP_SESSION_ACTIVE.".<br/>";

    echo "session_id = ".session_id().".<br/>";
    echo "session_status = ".session_status().".<br/>";

    $_SESSION['name'] = "boriska";
    $_SESSION['zxcv'] = "zxcv";

    echo 'Привет, '.$_SESSION['name']." это начало сессии.<br/>";

//    echo "phpinfo = ".phpinfo().".<br/>";
}

if ($mode == "cont")
{
    session_start();

    echo "session_status = ".session_status().".<br/>";
    echo "session_id = ".session_id().".<br/>";

echo 'Привет, '.$_SESSION['name']." это продолжение сессии.<br/>";
echo  "zxcv = ".$_SESSION['zxcv']."<br/>";
echo  "username = ".$_SESSION['username']."<br/>";
//echo  $_COOKIE['TestCookie']."<br/>";
//echo  $_COOKIE['TestCookie2']."<br/>";
}



if ($mode == "end")
{
session_start();

echo 'Привет, '.$_SESSION['name']." это завершение сессии.<br/>";
echo  "zxcv = ".$_SESSION['zxcv']."<br/>";
echo  "username = ".$_SESSION['username']."<br/>";

session_destroy();


//    unset($_COOKIE['PHPSESSID']);
    setcookie("PHPSESSID", "", time() - 3600);
    //unset($_SESSION['name']);
echo 'Пока, '.$_SESSION['name'].".<br/>";
}

if ($mode == "empt")
{
    echo "session_status = ".session_status().".<br/>";
    echo "session_id = ".session_id().".<br/>";

    echo 'Привет, '.$_SESSION['name']." здесь нет сессии.<br/>";
}


echo "<pre>";
  print_r($_SESSION);
echo "</pre>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
echo "<pre>";
//print_r($_SERVER);
echo "</pre>";


//echo 'session.use_cookies = ' . ini_get('session.use_cookies') . "<br/>";
//echo 'session.use_trans_sid = ' . ini_get('session.use_trans_sid') . "<br/>";
//print_r(ini_get_all("session"));
//print_r($_REQUEST);



/*

if (isset($_POST['auth_name'])) {
  $name=mysql_real_escape_string($_POST['auth_name']);
  $pass=mysql_real_escape_string($_POST['auth_pass']);


  $query = "SELECT * FROM users WHERE name='$name' AND pass='$pass'";
  $res = mysql_query($query) or trigger_error(mysql_error().$query);
  if ($row = mysql_fetch_assoc($res)) {
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

	echo "Имя = ".$name;

  exit;
}

if (isset($_GET['action']) AND $_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: http://".$_SERVER['HTTP_HOST']."/");

  echo "Имя = ".$name;

  exit;
}

if (isset($_REQUEST[session_name()])) session_start();

if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {
?>
<form method="POST">
<input type="text" name="auth_name"><br>
<input type="password" name="auth_pass"><br>
<input type="submit"><br>
</form>
<? 
}
exit;
*/




/*
$t = 'А это сам текст, ну тут много не напишешь, это же не клава :) 	<br /><a href="http:\//sibmail.com" target="_blank">sibmail</a><br /><br />xx<b onclick="alert(document.cookie)">yy';

echo '<span style="font-size:35;">Размер текста</span>';
//echo $t;
echo "-----<br a />1<br b />2<br/>--§--&sect;--<br/>";
//echo strip_tags($t, '<a>');
echo "<br/>------------<br/>";
//echo mysql_escape_string ($t);
echo "<br/>------------<br/>";
//echo htmlspecialchars ($t);
echo "<br/>------------<br/>";
echo addslashes ($t);
echo "<br/>------------<br/>";
//echo mysql_escape_string ($t);
echo "<br/>------------<br/>";
echo "<br/>------------<br/>";
//echo 'xx<b onclick="alert(document.cookie)">yy';

*/



/*
<?php  
  $user = $_POST['user'];  
  $pass = $_POST['pass'];  
  $sql = "SELECT user, pass FROM users WHERE user = '$user'";  
  list($m_user, $m_pass) = mysql_fetch_row( mysql_query($sql) );  
  if ( $pass != $m_pass or  // даст TRUE, если пароли не равны  
     $user != $m_user // данная проверка даст TRUE, если была sql инъекция  
  )  
  {  
        die("die");  
  }  
?>


*/


?>

<a href="/test/sess.php?mode=start" title="Сессии">[Старт]</a><br/>
<a href="/test/sess.php?mode=cont" title="Сессии">[Продолжение]</a><br/>
<a href="/test/sess.php?mode=end" title="Сессии">[Завершение]</a><br/>
<a href="/test/sess.php?mode=empt" title="Сессии">[Без сессии]</a><br/>
<br/>
<a href="/" title="Сессии">[На главную]</a><br/>


