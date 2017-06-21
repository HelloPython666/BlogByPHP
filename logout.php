<?php
	require('./lib/init.php');
	if(acc()) {
		var_dump($_COOKIE['name']);
		setcookie('name',0);
		setcookie('ccode',0);
		header('Location:index.php');

	}

?>