<?php
	/*Ficheiro para conter variaveis.*/
	
	ob_start();
	session_start();
	
	/*Para se conseguir mudar o form de página mais facilmente.
	Assim basta acrescentar este ficheiro ao ficheiro onde se quer ter o form.*/
	$current_file = $_SERVER['SCRIPT_NAME'];
	/*Diz a página de onde viemos.*/
	@$http_referer = $_SERVER['HTTP_REFERER'];
	
	
	function loggedin(){
		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
			return true;
		}else{
			return false;
		}
	}
	
?>