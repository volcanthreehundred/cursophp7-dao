<?php

	require_once("config.php");

	$usuario = new Usuario();

	$usuario->loadById(22);

	$usuario->update("pai", "king");

	echo $usuario;

?>