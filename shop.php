<?php
	
	require 'core.php';
	
	require 'connect.php';
	
	if(loggedin()){
		//Está logged in.
		//Têm de aparecer duas coisas o menu de logout e o botão de comprar(buy.php)
		echo '<div id="shopLoggedIn"><p id="shop12">You\'re logged in.</p>';
		echo '<a class="button" id="shop1" href="logout.php">Log Out</a><br>';
		echo '<a class="button" id="shop2" href="userData.php">Your Personal Profile</a>';
		echo '</div>';
	}else{
		// Não está logged in. Este caso não acontece nesta página.
		echo '<a href="signUp.php">Create an account here.</a><br><br>';
		echo 'If you already have an account please log in here.';
		include 'loginform.php';
	}
	
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		//$data = strtolower($data); dá problemas
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if(isset($_POST['captcha']) && isset($_POST['produto']) && isset($_POST['checkbox_1']) && isset($_POST['VatId']) && isset($_POST['address']) &&
isset($_POST['postalcode']) && isset($_POST['phoneNumber'])){
	
		/*Inicializar variaveis*/
		$produto = $VatId = $address = $postalCode = $phoneNumber = "";
		
		/*Falta segurança. htmlentities, fazer match das passwords e emails.*/
		$captcha = test_input($_POST['captcha']);
		$produto = test_input($_POST['produto']);
		$VatId = test_input($_POST['VatId']);
		$address = test_input($_POST['address']);
		$postalCode = test_input($_POST['postalcode']);
		$phoneNumber = test_input($_POST['phoneNumber']);

		
		if(!empty($_POST['produto'])){
		
			if($_POST['checkbox_1'] == 'on'){
			
				/*Tests com regular expressions.*/
				if (!preg_match("/^[\d+]*$/",$VatId)) {
					echo "Only numbers";
					die();
				}
				
				if (!preg_match("/^[a-zA-Z0-9, #.\-ªº]*$/",$address)) {
					echo "Only letters and white space allowed";
					die();
				}
				
				if (!preg_match("/^[a-zA-Z0-9, #.\-ªº]*$/",$postalCode)) {
					echo "Only letters and white space allowed";
					die();
				}
				
				
				if (!preg_match("/^[a-zA-Z0-9, #.\-ªº]*$/",$phoneNumber)) {
					echo "Only letters and white space allowed";
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
registo_de_compras(email, produto, vat, address, postalCode, contactNumber)
VALUES('$_SESSION[user_id]','$produto','$VatId','$address','$postalCode','$phoneNumber')";
			
			if ($query_run = mysqli_query($mysqlcon,$query)){
					echo 'Query Sucess';

					header('Location: userData.php');
						
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
        <!--Faltam aqui elementos: autor, palavras-chave -->
        
        <!-- JQuery para o slider-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidertron-1.1.js"></script>
		<script type="text/javascript" src="js/countries.js"></script>  
    </head>
    <body>
	
        <header id="quesepassa">
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
            <h2 id="titulo">Shop</h2>
                
            <div id="icons">
                <ul>
                    <!-- Faltam os links de referência.-->
                    <li><img src="images/facebook.png"/></li>
                    <li><img src="images/twitter.png"/></li>
                    <li><img src="images/YouTube.png"/></li>
                </ul>
			</div>
        </div>
		
		<form id="shop3" method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateShop(this)">
            <fieldset id="shop5">
                <legend>What product are you interested in?</legend>
            
                <input type="radio" name="produto" value="basic" required> Basic &ndash; 9,99&euro;<br>
                <input type="radio" name="produto" value="basicPlus4"> BPlus 4 Weeks &ndash; 40&euro;<br>
				<input type="radio" name="produto" value="basicPlus8"> BPlus 8 Weeks &ndash; 68&euro;<br>
				<input type="radio" name="produto" value="basicPlus12"> BPlus 12 Weeks &ndash; 84&euro;<br>
            </fieldset>
            
			<!-- FALTA JAVASCRIPT, é o javascript que vai tornar os campos restantes required, se o cliente 
			quiser factura. Só nesse caso é que ficam required. No html5 não são required, apenas o 
			radio é required.-->
			<div id="shop4">
				Want a detailed bill?<br>
				<input type="checkbox" name="checkbox_1">
			</div>
			
            <div id="shop4">
                <input title="Only Numbers."
type="number" name="VatId" maxlength="9" pattern= "\d+;" min="1" max="999999999999999999" placeholder="Vat Identification">
            </div>
            
            <div id="shop4">
                <input title="Only spaces, numbers and letters allowed. Also only #.\-ªº special characteres are allowed." 
type="text" name="address" maxlength="200" pattern= "[a-zA-Z0-9, #.\-ªº]*" placeholder="Billing Address">
            </div>
            
			<!-- Não é obrigatório o user escrever isto.-->
            <div id="shop4">
                <input title="Only spaces, numbers and letters allowed. Also only #.\-ªº special characteres are allowed." 
				type="text" name="postalcode" maxlength="50" pattern="[a-zA-Z0-9, #.\-ªº]+" placeholder="Postal Code">
            </div>
            <!-- Não é obrigatório o user escrever isto.-->
            <div id="shop4">
                <input title="Only numbers allowed. Also spaces and -()+ special characters are accepted." 
				type="text" name="phoneNumber" maxlength="25" pattern="[0-9, -()+]+" placeholder="Contact Number"/>
            </div>
			
			<div id="shop4">
				<p><img id="captcha" src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
				<small><a href="#" onclick="
					  document.getElementById('captcha').src = 'captcha.php?' + Math.random();
					  document.getElementById('captcha_code').value = '';
					  return false;
				">refresh</a></small></p>
				<p><input id="captcha_code" require type="text" name="captcha" size="6" maxlength="5"
				onkeyup="this.value = this.value.replace(/[^\d]+/g, '');" required >
				
				<small>copy the digits from the image into this box</small></p>
            </div>
			
			<div id="shop4">
				<p>Please transfer the correct amout to our account, 3 days after you will be get an email from us with your detailed plan.</p>
			</div>
			
			<div id="shop4">
				<p>Meanwhile please fill in your details in your profile page.
				You will be sent to your profile page when you submit your info.</p>
			</div>
	        
			<input id="shop11" type="submit" value="Submit">
        </form>
        
            
        <footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
    </body>
</html>