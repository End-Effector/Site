<?php
	
	/*Fichero que liga à base de dados.*/
	require 'connect.php';
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		//$data = strtolower($data); dá problemas
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if(isset($_POST['captcha']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['pwd1']) && isset($_POST['pwd2']) &&
isset($_POST['email']) && isset($_POST['email2']) && isset($_POST['country']) && isset($_POST['state'])){
	
		/*Inicializar variaveis*/
		$firstName = $lastName = $pwd1 = $email = "";
	
		/*Falta segurança. htmlentities, fazer match das passwords e emails.*/
		$captcha = test_input($_POST['captcha']);
		$firstName = test_input($_POST['firstName']);
		$lastName = test_input($_POST['lastName']);
		$pwd1 = md5(test_input($_POST['pwd1']));
		$pwd2 = md5(test_input($_POST['pwd2']));
		$email = test_input($_POST['email']);
		$email2 = test_input($_POST['email2']);
		$country = test_input($_POST['country']);
		$state = test_input($_POST['state']);
		
		if(!empty($_POST['captcha']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['pwd1']) && 
!empty($_POST['pwd2']) && !empty($_POST['email']) && !empty($_POST['email2']) && !empty($_POST['country']) &&
!empty($_POST['state'])){
		
		echo 'CHEGA AKI!!!!';
		
			/*Tests com regular expressions.*/
			if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			if(strcmp($pwd1,$pwd2) != 0){
				echo "Passwords need to match.";
				die();
			}else{
				if (!preg_match("/[a-z0-9]+/",$pwd1)) {
					echo "Invalid Password.";
					die();
				}
			}
			
			if( strcmp($email,$email2) != 0){
				echo "Emails need to match.";
				die();
			}else{
				if (!preg_match("/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/",$email)) {
					echo "Invalid Email.";
					die();
				}
			}
			
			session_start();
			if(	$captcha != $_SESSION['digit']) 
				die("Sorry, the CAPTCHA code entered was incorrect!");
			session_destroy();
			
			/***********************************************************************/
			//Falta segurança nas variáveis!
			//criação de query:
			
				
			$query = "INSERT INTO 
registo_de_utilizadores(email, firstName, lastName, password, country, state)
VALUES('$email','$firstName','$lastName','$pwd1','$country','$state')";
			
			if ($query_run = mysqli_query($mysqlcon,$query)){
					echo 'Query Sucess';

					header('Location: services.php');
						
			}else {
					die((mysqli_error($mysqlcon)));
			}
			
		}
	}
	

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Gains Anatomy: Shop</title>
        <link href='https://fonts.googleapis.com/css?family=Kurale|Numans|Oleo+Script' rel='stylesheet' type='text/css'>
        <link href="styles/normalize.css" rel="stylesheet">
        <link href="styles/main.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/countries.js"></script>

        </head>
    <body>
        
        <header>
            <a href="index.html" class="logo1"><img src="images/GA_new.png" alt="Gains Anatomy Logo" width="150vw" height="150vw"></a>
            <h1 id="logo0"> Gains Anatomy</h1>
            <nav>
                <ul >
                    <li><a href="index.html"> Home</a></li>
                    <li><a href="articles.php"> Articles</a></li>
                    <li><a href="food.html"> Food</a></li>
                    <li class="fix"><a href="services.php"> Services</a></li>
                </ul>
                <div id="aki" class="handle">&#9776; Menu</div>
            </nav>
        </header>
        
        <div id="barra">
            <h2 id="titulo">Sign-up!</h2>
                
            <div id="icons">
                <ul>
                    <!-- Faltam os links de referência.-->
                    <li><img src="images/facebook.png"/></li>
                    <li><img src="images/twitter.png"/></li>
                    <li><img src="images/YouTube.png"/></li>
                </ul>
			</div>
        </div>
		
        <form id=teste0 method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateSignIn(this)">
            
            <div id="teste1">
                <input title="Only letters please." type="text" name="firstName" maxlength="50" required pattern="\w+" placeholder="First Name"> 
            </div>
            
            <div id="teste1">
                <input title="Only letters please." type="text" name="lastName" maxlength="50" required pattern="\w+" placeholder="Last Name">
            </div>
            
            <div id="teste1">
                <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers. No special characters" type="password" name="pwd1" maxlength="25" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"  
			onchange="form.pwd2.pattern = this.value;" placeholder="Password">
            </div>
            
            <div id="teste1">
                <input title="Please enter the same Password as above" type="password" name="pwd2" maxlength="25" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password Confirm"><br>
            </div>
            
            <div id="teste1">
                <input type="email" name="email" maxlength="50" required pattern="[a-z0-9!#$%&'*+/=?^_`{|}~.-]+@[a-z0-9-]+(\.[a-z0-9-]+)*" placeholder="Email Address">
            </div>    
            
            <div id="teste1">
                <input type="email" name="email2" maxlength="50" required placeholder="Confirm Email">
            </div>
            
            <div id="teste1">
                Select Country (with states):   <select id="country" name ="country" required></select>
            </div>
            <div id="teste11">
                Select State: <select name ="state" id ="state" required></select>
            </div>
            <script language="javascript">
                populateCountries("country", "state");
            </script>
			
			<div id="teste16">
				<p><img id="captcha" src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
				<small><a href="#" onclick="
					  document.getElementById('captcha').src = 'captcha.php?' + Math.random();
					  document.getElementById('captcha_code').value = '';
					  return false;
				">refresh</a></small></p>
				<p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" 
				onkeyup="this.value = this.value.replace(/[^\d]+/g, '');" required > 
				<small>copy the digits from the image into this box</small></p>
            </div>
			
	        <input id="teste14" type="submit" value="Submit">
        </form>
        
        <footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
            
    </body>
</html>



