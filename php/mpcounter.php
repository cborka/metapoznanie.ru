<?php 

require_once "init_php.php";
require_once "init_db.php";

$ip = $_SERVER["REMOTE_ADDR"];
$pgname = input_filter($_GET['pgname']);
$isload = input_filter($_GET['isload']);

if ($isload == '1')
{
	$md=do_sql("
		SELECT MAX(dtb) 
			FROM mpstat 
			WHERE ip = '$ip' 
			  AND cname = '$pgname'
	"); 
	$cd=do_sql("SELECT CURRENT_TIMESTAMP FROM mpstat LIMIT 0 , 1"); 
	$dd = strtotime($cd)-strtotime($md);
	
	if ($dd > 1800) /* полчаса */
	{
		do_update_sql("
			INSERT INTO mpstat(ip, dtb, dte, cname) 
				VALUES ('$ip', CURRENT_TIMESTAMP, '0000-00-00 00:00:00','$pgname')
		");
	}
}
else {
	$md=do_sql("
		SELECT MAX(dtb) 
			FROM mpstat 
			WHERE ip = '$ip' 
			  AND cname = '$pgname'
	"); 
	do_update_sql("
		UPDATE mpstat 
			SET dte = CURRENT_TIMESTAMP 
			WHERE ip = '$ip' 
			  AND dtb = '$md'
			  AND cname = '$pgname'
	");
}

?>