<?php

	require_once("config.php");

	$volcan = new Usuario();

	$volcan->loadByName("volcan");

	echo $volcan;

?>