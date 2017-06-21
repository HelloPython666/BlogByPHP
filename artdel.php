<?php 
	
	require('./lib/init.php');
	if(!acc()) {
		header('Location: login.php');
	}else{
		// $author = $_COOKIE['name'];
		$cfg = require(ROOT . '/lib/config.php');
		$art_id = $_GET['art_id'];
		$sql = "delete from art where art_id = $art_id ";
		var_dump($sql);
		$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
		mysqli_select_db($con,$cfg['db']);
		mysqli_set_charset( $con,$cfg['charset']);
		$rs = mysqli_query($con,$sql);
		if(!$rs){
			echo "shanchu shi bai";
		}else{
			echo "shanchu chenggong";
		}
		require(ROOT . '/blog/artdel.html');
		// sleep(3);
		// header('Location:index.php');
}
?>