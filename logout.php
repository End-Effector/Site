<?php
	/*Para o user poder fazer log out.*/
	
	/*Tem-se de incluir isto porque para destroy de uma session primeiro tem-se de 
	entrar na mesma.*/
	require 'core.php';
	session_destroy();
	
	/*Para mandar o user de volta para onde estava, mas agora logged out.*/
	//header('Location: '.$http_referer);
	header('Location: services.php');
?>