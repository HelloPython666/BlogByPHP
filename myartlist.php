<?php
	require('./lib/init.php');
	if(!acc()) {
		header('Location: login.php');
	}else{
		$author = $_COOKIE['name'];
		$cfg = require(ROOT . '/lib/config.php');
		$sql = "select title,content,comm,pubtime,thumb,author,art_id from art where author = '$author' order by pubtime desc";
		if(!$author){
			header('Location:login.php');
		}else{
			$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
			mysqli_select_db($con,$cfg['db']);
			mysqli_set_charset( $con,$cfg['charset']);
			$rs = mysqli_query($con,$sql);
			if(!$rs){
				echo "huoqu artlist shibai";
			}else{
				$data = array();
				while($row = mysqli_fetch_assoc($rs)) {
						$data[] = $row;
				}
					$arts = $data;
				}
				// var_dump($arts);
		require(ROOT . '/blog/myartlist.html');
	}
}
?>