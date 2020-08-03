<?php

	require_once("config.php");

	$volcan = new Usuario();

	$volcan->loadById(10);

	echo $volcan;

?>