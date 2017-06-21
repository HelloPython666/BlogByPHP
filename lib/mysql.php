<?php
//shujuku lianjie hanshu
	function mConn() {
	static $conn = null;
	if($conn === null) {
		$cfg = require(ROOT . '/lib/config.php');
		$conn = mysqli_connect($cfg['host'] , $cfg['user'] , $cfg['pwd']);
		mysqli_select_db($conn,$cfg['db']);
		mysqli_set_charset( $conn,$cfg['charset']);
	}

	return $conn;
}

//chaxun hanshu 
function mQuery($sql) {
	$rs  = mysqli_query($sql , mConn());
	if($rs) {
		mLog($sql);
	} else {
		mLog($sql. "\n" . mysqli_error());
	}

	return $rs;
}
//ri zhi hanshu
function mLog($str) {
	$filename = ROOT . '/log/' . date('Ymd') . '.txt';
	$log = "-----------------------------------------\n".date('Y/m/d H:i:s') . "\n" . $str . "\n" . "-----------------------------------------\n\n";
	return file_put_contents($filename, $log , FILE_APPEND);
}

//chaxun duohang shuju 
function mGetAll($sql) {
	$rs = mQuery($sql);
	if(!$rs) {
		return false;
	}

	$data = array();
	while($row = mysqli_fetch_assoc($rs)) {
		$data[] = $row;
	}

	return $data;
}

//chaxun danhang shuju 
function mGetRow($sql) {
	$rs = mQuery($sql);
	if(!$rs) {
		return false;
	}

	return mysqli_fetch_assoc($rs);
}

//zhixing shujuku caozuo
function mExec($table , $data , $act='insert' , $where=0) {
	if($act == 'insert') {
		$sql = "insert into $table (";
		$sql .= implode(',' , array_keys($data)) . ") values ('";
		$sql .= implode("','" , array_values($data)) . "')";
		return mQuery($sql);
	} else if ($act == 'update') {
		$sql = "update $table set ";
		foreach($data as $k=>$v) {
			$sql .= $k . "='" . $v . "',";
		}

		$sql = rtrim($sql , ',') . " where ".$where;
		return mQuery($sql);
	}
}
?>