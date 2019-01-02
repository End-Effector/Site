<?php
	/*Para criar o form de log in.*/
	/*No form a action vai usar uma variavel diferente.*/
	
	if(isset($_POST['email']) && isset($_POST['pwd'])){
		/*Segurança*/
		$email = $_POST['email'];
		$pwd = $_POST['pwd'];
		
		/*Usar o salt & Hash em vez do md5*/
		$password_hash = md5($pwd);
		
		if(!empty($email) && !empty($pwd)){
			
			/* Acrescentar segurança, ".VARIAVEL AQUI." e depois usar mysqli_real_escape_string */
			$query = "SELECT email FROM registo_de_utilizadores  
			WHERE email='".mysqli_real_escape_string($mysqlcon,$email)."' 
			AND password='".mysqli_real_escape_string($mysqlcon,$password_hash)."'";
			
			/*Corre-se a Query*/
			if ($query_run = mysqli_query($mysqlcon,$query)){
				
				$query_num_rows = mysqli_num_rows($query_run);
						
				//Only prints out info if it finds any		
				if($query_num_rows== NULL){
					echo 'Invalid username/Password Combination.';
					echo '<br>'.$email.'<br>';
					echo $password_hash.'<br>';
					
				}else if($query_num_rows== 1){
					/*Log in user.*/
					
					/*Encontra o id.*/
					foreach($query_run as $query_row){
						$user_id = $query_row['email'];
					}
					
					$_SESSION['user_id'] = $user_id;
					
					header('Location: services.php');
				}		
			}else {
				//mysql_error() doesnt work;
				echo 'Query Fail';
			}
			
		}else{
			echo 'You must supply a username and password';
		}
	}
?>

<form id="loginform" action="<?php echo $current_file; ?>" method="POST" onsubmit="return validateLoginForm(this)">
	<input title="Use @, small letters can have numbers." id="loginform1" type="email" name="email" maxlength="50" required pattern="[a-z0-9!#$%&'*+/=?^_`{|}~.-]+@[a-z0-9-]+(\.[a-z0-9-]+)*" placeholder="Email">
	<input title="Must have a small/capital letters and numbers" id="loginform2" type="password" name="pwd" maxlength="25" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password">
	<input id="loginform3" type="submit" value="Log in">
</form>