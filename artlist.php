<?php
	require('./lib/init.php');
	if(!acc()) {
		header('Location: login.php');
	}else{
		$cfg = require(ROOT . '/lib/config.php');
		$sql = "select art_id,title,pubtime,comm,author from art order by pubtime desc";
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
		require(ROOT . '/blog/artlist.html');
	}

?>