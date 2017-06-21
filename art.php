<?php
	require ('./lib/init.php');
		$art_id = $_GET['art_id'];
		$sql = "select title,content,pubtime,comm,thumb,author from art where art_id = '$art_id'";
		$cfg = require(ROOT . '/lib/config.php');
		$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
		mysqli_select_db($con,$cfg['db']);
		mysqli_set_charset( $con,$cfg['charset']);
		$rs = mysqli_query($con,$sql);
		if(!$rs){
		echo "huoqu art shibai";
		}else{
			$row = mysqli_fetch_assoc($rs);
			$art = $row;
		}
		// require(ROOT . '/blog/art.html');
		if(!acc()){
			$login = 0;
		}else{
			$login = 1;
		}
		require(ROOT . '/blog/art.html');
?>