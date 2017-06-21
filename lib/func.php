<?php
//jiance denglu

function acc() {
	if(!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])){
		return false;
	}
	return $_COOKIE['ccode'] === cCode($_COOKIE['name']);
}



//yonghu jiami

function cCode($name) {
	$salt = require(ROOT . '/lib/config.php');
	return md5($name . '|' . $salt['salt']);
}


function randStr($num=6) {
	$str = str_shuffle('abcedfghjkmnpqrstuvwxyzABCEDFGHJKMNPQRSTUVWXYZ23456789');

	return substr($str, 0 , $num);
}

//echo randStr();

/**
* ROOT.'/upload/1990/01/01/qwefas.jpg'
* 
*/
function createDir() {
	$path = '/upload/'.date('Y/m/d');
	$fpath = ROOT . $path;
	if(is_dir($fpath) || mkdir($fpath , 0777 , true)) {
		return $path;

	} else {
		return false;
	}
}
//huoqu houzhuiming
function getExt($filename) {
	return strrchr($filename, '.');
}

/**
* 生成缩略图
*
* @param str $oimg /upload/2016/01/25/asdfed.jpg
* @param int $sw 生成缩略图的宽
* @param int $sh 生成缩略图的高
* @return str 生成缩略图的路径 /upload/2016/01/25/asdfed.png
*/

function makeThumb($oimg , $sw=100 , $sh = 100) {
	//缩略图存放的路径的名称
	$simg = dirname($oimg) . '/' . randStr() . '.png';

	//获取大图和缩略图的绝对路径
	$opath = ROOT . $oimg;//原图的绝对路径
	$spath = ROOT . $simg;//最终生成的小图

	//创建小画布
	$spic = imagecreatetruecolor($sw, $sh);

	//创建白色
	$white = imagecolorallocate($spic, 255, 255, 255);
	imagefill($spic, 0, 0, $white);

	//获取大图信息
	list($bw , $bh ,$btype) = getimagesize($opath);
	//1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，
	//7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，
	//11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM
	$map = array(
		1=>'imagecreatefromgif',
		2=>'imagecreatefromjpeg',
		3=>'imagecreatefrompng',
		15=>'imagecreatefromwbmp'
	);
	if(!isset($map[$btype])) {
		return false;
	}
	$opic = $map[$btype]($opath);//大图资源
	//imagecreatefromjpeg(filename)

	//计算缩略比
	$rate = min($sw/$bw , $sh/$bh);
	$zw = $bw * $rate;//最终返回的小图宽
	$zh = $bh * $rate;//最终返回的缩略小图高

	//imagecopyresampled(dst_image, src_image, dst_x, dst_y, 
		//src_x, src_y, dst_w, dst_h, src_w, src_h)
	//echo $rate ,  '<br>' , $zw , '<br>' , $zh ;exit();
	//imagecopyresampled($spic, $opic, 0, 0, 0, 0, $zw, $zh, $bw, $bh);

	imagecopyresampled($spic, $opic, ($sw-$zw)/2, ($sh-$zh)/2, 0, 0, $zw, $zh, $bw, $bh);

	imagepng($spic , $spath);

	imagedestroy($spic);
	imagedestroy($opic);

	return $simg;
}
//fenye 
function getPage($num,$curr,$cnt) {
	$max = ceil($num/$cnt);
	// var_dump($max);
	$left = max(1 , $curr-2);
	$right = min($left+9 , $max);
	$left = max(1 , $right-9);
	$page = array();
	for($i=$left;$i<=$right;$i++) {
		// $_GET['page'] = $i;
 		// $page[$i] = http_build_query($_GET);
 		$page[] = $i;
	}
	return $page;
}
?>