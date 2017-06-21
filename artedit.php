<?php
	require ('./lib/init.php');
	if(empty($_POST)){
		if(!$_COOKIE['name']){
			header('Location:login.php');
		}else{
			$art_id = $_GET['art_id'];
			$sql = "select title,content,pic,thumb from art where art_id = $art_id";
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
			// var_dump($art);
			require(ROOT . '/blog/artedit.html');
		}
	}else{

		$art['title'] = trim($_POST['title']);
		if($art['title'] == '') {
			echo "biaoti buneng weikong";
		}

		$art['content'] = trim($_POST['content']);
		if($art['content'] == '') {
			echo "nei rong buneng weikong ";
		}

		if( !($_FILES['pic']['name'] == '' ) && $_FILES['pic']['error'] == 0) {

			$filename = createDir() . '/' . randStr() . getExt($_FILES['pic']['name']);

			if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT .  $filename)){
			$art['pic'] = $filename;
			$art['thumb'] = makeThumb($filename);
				}
		}

		$art['author'] = $_COOKIE['name'];
		$art['pubtime'] = time();
		$art['art_id'] = $_GET['art_id'];

		$sql = "update art set title = '$art[title]',content = '$art[content],',pubtime = '$art[pubtime]',pic = '$art[pic]',thumb = '$art[thumb]' where art_id = '$art[art_id]'";
		$cfg = require(ROOT . '/lib/config.php');
		$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
		mysqli_select_db($con,$cfg['db']);
		mysqli_set_charset( $con,$cfg['charset']);
		$rs = mysqli_query($con,$sql);
		if(!$rs){
			echo "gengxin shibai";
		}else{
			echo "gengxin chenggong";
			sleep(2);
			header('Location:index.php');	
		}
	}
?>