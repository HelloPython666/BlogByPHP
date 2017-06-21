<?php
	require('./lib/init.php');
	if(empty($_POST)) {
		require(ROOT . '/blog/login.html');
	} 
	else {
			$user['name'] = trim($_POST['name']);
	if(empty($user['name'])) {
		echo "用户名不能为空";
	}

	$user['password'] = trim($_POST['password']);
	if(empty($user['password'])) {
		echo "密码不能为空";
	}
	$sql = "select * from user where name='$user[name]'";
	$cfg = require(ROOT . '/lib/config.php');
	$conn = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
	mysqli_select_db($conn,'myblog');
	mysqli_set_charset( $conn,'utf8');
	$rs  = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($rs);
	if(!$row) {
		echo "用户名错误";
	} else {
		if(md5($user['password'].$cfg['md5salt']) === $row['password']){
			setcookie('name' , $user['name'],time()+300);
			setcookie('ccode' , cCode($user['name']),time()+300);
			header('Location: index.php');
		} else {
			echo "密码错误";
		}
	}
	}
?>