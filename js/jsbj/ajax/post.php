<?php
	header('content-type:text/html;charset="utf-8"');
	$user = $_POST['user'];
	$pw = $_POST['pw'];
	echo "您的用户名是:{$user}, 您的密码是:{$pw}";

?>