<?php
	
	require 'core.php';
	
	require 'connect.php';
	
	if(loggedin()){
		//Está logged in.
		//Têm de aparecer duas coisas o menu de logout e o botão de comprar(buy.php)
		echo '<div id="userDataLoggedIn"><p id="userdata-3">You\'re logged in.</p>';
		echo '<a class="button" id="userdata-1" href="logout.php">Log Out</a><br>';
		echo '<a class="button" id="userdata-2" href="shop.php">Back to Shop</a>';
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
	
	if(isset($_POST['captcha']) && isset($_POST['age']) && isset($_POST['height']) && isset($_POST['weight']) && isset($_POST['weightUnits']) &&
isset($_POST['sexo']) && isset($_POST['exercise']) && isset($_POST['workouts']) && isset($_POST['objective']) && isset($_POST['health'])
&& isset($_POST['supplements']) && isset($_POST['contact_text'])){
	
		/*Inicializar variaveis*/
		$age= $height = $address = $weight = $weightUnits = $sexo = $exercises = $workouts = $objective = $health =
$supplements  = $contact_text = $tipoExercicio1 = $tipoExercicio2 = $tipoExercicio3 = $tipoExercicio4 =
 $tipoExercicio5 = "";
		
		$captcha = test_input($_POST['captcha']);
		$age = test_input($_POST['age']);
		$height = test_input($_POST['height']);
		$weight = test_input($_POST['weight']);
		$weightUnits = $_POST['weightUnits'];
		$sexo = test_input($_POST['sexo']);
		$exercise = test_input($_POST['exercise']);
		$workouts = test_input($_POST['workouts']);
		$objective = test_input($_POST['objective']);
		$health = test_input($_POST['health']);
		$supplements = test_input($_POST['supplements']);
		$contact_text = test_input($_POST['contact_text']);
		
		if(!empty($_POST['age']) && !empty($_POST['height']) && !empty($_POST['weight']) 
	&& !empty($_POST['weightUnits']) && !empty($_POST['sexo']) && !empty($_POST['exercise']) && !empty($_POST['workouts']) 
&& !empty($_POST['objective']) && !empty($_POST['supplements'])){
		
			/*Tests com regular expressions.*/
			if (!preg_match("/^[\d+]*$/",$age)) {
				echo "Only numbers";
				die();
			}
				
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$height)) {
				echo "Only letters and white space allowed";
				die();
			}
				
			if (!preg_match("/^[\d+]*$/",$weight)) {
				echo "Only letters and white space allowed";
				die();
			}
				
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$workouts)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$health)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$supplements)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$contact_text)) {
				echo "Only letters and white space allowed1";
				die();
			}
			
			/*parte das checkboxes*/
			// Mistake, because you can do several.
			if(isset($_POST['gym'])){
				if($_POST['gym'] == 'on'){
					$tipoExercicio1 = 'gym';
				}
			}
			
			if(isset($_POST['endu'])){
				if($_POST['endu'] == 'on'){
					$tipoExercicio2 = 'endu';
				}
			}
			
			if(isset($_POST['group'])){
				if($_POST['group'] == 'on'){
					$tipoExercicio3 = 'group';
				}
			}
			
			if(isset($_POST['calis'])){
				if($_POST['calis'] == 'on'){
					$tipoExercicio4 = 'calis';
				}
			}
			
			if(isset($_POST['other'])){
				$other = test_input($_POST['other']);
				$tipoExercicio5 = $other;
			}
			
			//Pode haver problemas de espaço na base de dados.
			//Confimar!
			$tipoExercicio = $tipoExercicio1."#".$tipoExercicio2.
			"#".$tipoExercicio3."#".$tipoExercicio4."#".$tipoExercicio5;
			
			if (!preg_match("/^[a-zA-Z0-9, '\"#.\-ªº]*$/",$tipoExercicio)) {
				echo "Only letters and white space allowed";
				die();
			}
			
			//session_start();
			if(	$captcha != $_SESSION['digit']) 
			die("Sorry, the CAPTCHA code entered was incorrect!");
			session_destroy();
			
			//Ficheiro, imagens**************************************************************************

			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			$type = $_FILES['file']['type'];
			$tmp_name= $_FILES['file']['tmp_name'];
			//$error = $_FILES['file']['error'];

			/*Encontra a extensão do ficheiro.*/
			/*Para simplificar os testes.*/
			$extension = strtolower(substr($name, strpos($name, '.')+ 1));

			/*Tamanho máximo do ficheiro.*/
			$max_size = 2097152;
			
			//Para mudar a query se tiver imagem
			$flag_image = 0;
			
			if(isset($name)){
				if(!empty($name)){
				
				@$name = $_SESSION[user_id].'.'.$extension;

					if(($extension=='jpg' || $extension=='jpeg') && ($type=='image/jpeg' || $type=='image/jpg') && $size<=$max_size){

						$location = 'uploads/';
						if (move_uploaded_file($tmp_name, $location.$name)){
							
							$flag_image = 1;
						}
					}else{
						echo 'File must be jpeg or jpg and must be less then 2MB.';
					}
				}else{
					echo 'please choose file';
				}
			}
			
			/***********************************************************************/
			//criação de query:
			
			if($flag_image == 1){
				
				$query = "INSERT INTO 
info_de_utilizadores(email, idade, altura, peso, uniPeso, sexo, nivelActividade, numeroTreinos, tipoExercicio, objectivos, problemasSaude
, suplementos, infoExtra, Imagens)
			VALUES(
				'$_SESSION[user_id]',
				'$age',
				'$height',
				'$weight',
				'$weightUnits',
				'$sexo',
				'$exercise',
				'$workouts',
				'$tipoExercicio',
				'$objective',
				'$health',
				'$supplements',
				'$contact_text',
				'true')";
				
			}else{
				
			$query = "INSERT INTO 
info_de_utilizadores(email, idade, altura, peso, uniPeso, sexo, nivelActividade, numeroTreinos, tipoExercicio, objectivos, problemasSaude
, suplementos, infoExtra, Imagens)
			VALUES(
				'$_SESSION[user_id]',
				'$age',
				'$height',
				'$weight',
				'$weightUnits',
				'$sexo',
				'$exercise',
				'$workouts',
				'$tipoExercicio',
				'$objective',
				'$health',
				'$supplements',
				'$contact_text',
				'false')";
			}
			
			if ($query_run = mysqli_query($mysqlcon,$query)){

					header('Location: index.html');
						
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
        <header id="quesepassa2">
            <!-- <a href="index.html" class="logo1"><img src="images/ga.png" alt="Gains Anatomy Logo"></a> -->
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
            <h2 id="titulo">Your Profile</h2>
                
            <div id="icons">
                <ul>
                    <!-- Faltam os links de referência.-->
                    <li><img src="images/facebook.png"/></li>
                    <li><img src="images/twitter.png"/></li>
                    <li><img src="images/YouTube.png"/></li>
                </ul>
            </div>
        </div>
		
		<!-- enctype="multipart/form-data"-->
		
        <form id="userdata0" method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            
			<p id="userdata2">Please fill your details so we can build you your plan.</p>
			
			<div id="userdata2">
                <input title="Only letters please." type="text" name="age" maxlength="50" required pattern="\w+"
				placeholder="Your Age"> 
            </div>
			
			<div id="userdata2">
                <input title="Only numbers please." type="text" name="height" maxlength="50" required pattern="[0-9, \.]+"
				placeholder="Your Height"> 
            </div>
			
			<div id="userdata2">
				<select name="heightUnits">
				<option value=" ">Select</option>
				<option value="Metric">m</option>
				<option value="Imperial">in</option>
			  </select>
            </div>
			
			<div id="userdata2">
                <input title="Only numbers please." type="text" name="weight" maxlength="50" required pattern="[0-9, \.]+" 
				placeholder="Your Weight">
            </div>
			
			<div id="userdata2">
				<select name="weightUnits">
				<option value=" ">Select</option>
				<option value="Metric" required>kg</option>
				<option value="Imperial">lbs</option>
			  </select>
            </div>
			
			<fieldset id="userdata4">
                <legend>What is your Gender?</legend>
                <input type="radio" name="sexo" value="male" required> Male<br>
                <input type="radio" name="sexo" value="female"> Female<br>
            </fieldset>
            
			<fieldset id="userdata4">
                <legend>What is your daily activity level(Excluding Exercise)</legend>
                <input type="radio" name="exercise" value="sedentary" required> Sedentary <br>
                <input type="radio" name="exercise" value="lightlyActive"> Lightly Active <br>
				<input type="radio" name="exercise" value="active"> Active <br>
				<input type="radio" name="exercise" value="veryActive"> Very Active <br>
            </fieldset>
			
			<div id="userdata2">
                How many times do you workout per week?:<br>
                <input title="Only a number please." type="text" name="workouts" maxlength="4" required pattern="\d+"> 
            </div>
            
			<div id="userdata2">
				<legend>Tell us more about the execises you pratice:</legend>
				<input type="checkbox" name="gym"><lable> Gym(Hipertrophy, Strenght, Powerlifting, Resistance, etc) </lable><br>
				<input type="checkbox" name="endu"><lable> Endurance(Running, Cycling, etc) </lable><br>
				<input type="checkbox" name="group"><lable> Groupclass </lable><br>
				<input type="checkbox" name="calis"><lable> Calisthenics </lable><br>
				<lable> Other </lable>
				<input title="Only a word/letters please." type="text" name="other" pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<fieldset id="userdata4">
                <legend>What is your Objective?</legend>
                <input type="radio" name="objective" value="losefat" required> Lose Fat <br>
                <input type="radio" name="objective" value="IncMuscleMass"> Increase Muscle Mass <br>
				<input type="radio" name="objective" value="maintWeight"> Maintain Weight(Body Recomposition) <br>
            </fieldset>
			
			<div id="userdata2">
				<legend>Any Health Issues?</legend>
				<input title="Only letters please." type="text" name="health" placeholder="Please Specify" 
	pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<div id="userdata2">
				<legend>Do you take any supplements?</legend>
				<input title="Only letters please." type="text" name="supplements" placeholder="Please Specify" 
	required pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<div id="userdata2">
				<legend>Add a full body picture to evaluate your current stats and future progression.</legend>
				<!-- <form action="index2.php" method="POST" enctype="multipart/form-data"> -->
				<input id="userdata18" type="file" name="file"><br><br>
			</div>
			
			<div id="userdata2">
				<legend>Any revelant information or questions you would like to ask?</legend>
				<textarea id="userdata19" title="Only letters/words and numbers please." name="contact_text" rows="6" cols="30 maxlength="1000" 
				pattern="[a-zA-Z0-9, #\.\-ªº]+"></textarea><br><br>
			</div>
			
			<div id="userdata2">
				<p><img id="captcha" src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
				<small><a href="#" onclick="
					  document.getElementById('captcha').src = 'captcha.php?' + Math.random();
					  document.getElementById('captcha_code').value = '';
					  return false;
				">refresh</a></small></p>
				<p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');" required> 
				<small>copy the digits from the image into this box</small></p>
            </div>
			
	        <input id="userdata3" type="submit" value="Finished!">
        </form>
        
        <footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
    </body>
</html>