<?php
	// require './blog/index.html';
	require ('./lib/init.php');

		$sql = "select count(*) from art";
		$cfg = require(ROOT . '/lib/config.php');
		$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
		mysqli_select_db($con,$cfg['db']);
		mysqli_set_charset( $con,$cfg['charset']);
		$rs = mysqli_query($con,$sql);
		if(!$rs){
			echo "huoqu art shibai";
		}else{
			$row = mysqli_fetch_row($rs);
		}
		$num = $row[0];
		$curr = isset($_GET['page']) ? $_GET['page'] : 1;
		$cnt = 5;
		$page = getPage($num , $curr, $cnt);
		$m = ($curr-1)*$cnt;

		// print_r($page);
		// var_dump($m);
		// $sql = "select art_id,title,author,content,pubtime,comm,thumb from art order by pubtime desc limit ($curr-1)*$cnt , $cnt ";
		$sql = "select art_id,title,author,content,pubtime,comm,thumb from art order by pubtime desc limit $m,$cnt";
		// var_dump($sql);
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
		if(!acc()){
			$login = 0;
		}else{
			$login = 1;
		}

		require(ROOT . '/blog/index.html');

?>