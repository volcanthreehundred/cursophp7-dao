<?php

	require_once("config.php");

	$volcan = new Usuario();

	$volcan->loadByName("luiz");

	echo $volcan;

?>