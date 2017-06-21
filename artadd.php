<?php 

	require('./lib/init.php');
	if(!$_COOKIE['name']){
		header('Location:login.php');
	}else{
		if(empty($_POST)) {
			require(ROOT . '/blog/artadd.html');
		}else {

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

		$art['pubtime'] = time();
		$art['author'] = $_COOKIE['name'];
		// if(!$art['author']){
		// 	header('Location:login.php');
		// }else{
		$cfg = require(ROOT . '/lib/config.php');
		$sql = "insert into art(author,title,content,pubtime,pic,thumb) 
			values ('$art[author]','$art[title]','$art[content]',$art[pubtime],'$art[pic]','$art[thumb]')";
		$con = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
				mysqli_select_db($con,'myblog');
				mysqli_set_charset( $con,'utf8');
				$rs = mysqli_query($con,$sql);
				if(!$rs){
					echo "fabu shibai";
				}else{
					echo "fabu chenggong";
				}
	
	}
}
// }
?>