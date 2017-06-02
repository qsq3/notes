<?php
	header('content-type:text/html;charset="utf-8"');
	
	$arr = array(
		array('name'=>'阿飞','age'=>'15'),
		array('name'=>'空山','age'=>'18'),
		array('name'=>'无敌','age'=>'8')
	
	);
	echo json_encode($arr);

?>