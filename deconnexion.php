<?php
	session_start();
	session_destroy();
	define('pageprecedente', $_SERVER["HTTP_REFERER"], true);
	if(pageprecedente == "http://localhost/GeekZone/gestions_produits.php" || pageprecedente == "http://localhost/GeekZone/gestions_boutiques.php"){
		header('Location: http://localhost/GeekZone/index.php');
	}else{
		header('Location: ' . pageprecedente);
	}
	exit;
?>