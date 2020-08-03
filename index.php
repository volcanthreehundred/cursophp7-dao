<?php

	require_once("config.php");

	$logar = new Usuario();

	$logar->login("luiz", "henrique");

	echo $logar;


?>