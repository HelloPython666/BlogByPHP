<?php
	require('./lib/init.php');
	if(empty($_POST)){
		require(ROOT . '/blog/register.html');
	}
	else{
		$register['email'] = trim($_POST['email']);
		$register['name'] = trim($_POST['name']);
		$register['password'] = trim($_POST['password']);
		$register['confirmpassword'] = trim($_POST['confirmpassword']);
		if(empty($register['email']) ||empty($register['name'])||empty($register['password']||empty($register['confirmpassword']))){
				echo "bixuanxiang buneng weikong ";
			}else{
			if($register['password']!==$register['confirmpassword']){
				echo "liangci mi ma bu xiangtong";
			}
			$sql = "select * from user where email = '$register[email]' or name = '$register[name]' ";
			$cfg = require(ROOT . '/lib/config.php');
			$conn = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
			mysqli_select_db($conn,'myblog');
			mysqli_set_charset( $conn,'utf8');
			$rs  = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($rs);
			if ($row) {
				echo "youxiang huo yonghuming yi cunzai";
			}else{
				$md5password = md5($register['password'].$cfg['md5salt']);
				$sql="insert into user (name,email,password,salt) values ('$register[name]','$register[email]','$md5password','$cfg[md5salt]')";
				$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
				mysqli_select_db($con,'myblog');
				mysqli_set_charset( $con,'utf8');
				$rs = mysqli_query($con,$sql);
				if(!$rs){
					echo "zhuce shibai";
				}
			}
		}	
	}
?>