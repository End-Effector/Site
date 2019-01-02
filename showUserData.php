<?php
	
	require 'core.php';
	
	require 'connect.php';
	
	if(loggedin()){
		//Está logged in.
		//Têm de aparecer duas coisas o menu de logout e o botão de comprar(buy.php)
		echo '<a class="button" id="userdata-1" href="logout.php">Log Out</a>';
		echo '<a class="button" id="userdata-2" href="shop.php">Back to Shop</a>';
	}else{
		// Não está logged in. Este caso não acontece nesta página.
		echo '<a href="signUp.php">Create an account here.</a><br><br>';
		echo 'If you already have an account please log in here.';
		include 'loginform.php';
	}
	

	/************************************************************************************/
	@$search_name = $_SESSION[user_id];
	
	echo $search_name;
	
	$query = "SELECT email FROM info_de_utilizadores WHERE email LIKE '$search_name'";
		
	if ($query_run = mysqli_query($mysqlcon,$query)){
		//echo 'Query Sucess';
						
		$query_num_rows = mysqli_num_rows($query_run);
						
		//Only prints out info if it finds any
						
		if($query_num_rows== NULL){
			//echo 'No results found in the database';
		}else{
			
			foreach($query_run as $query_row){
				$name = $query_row['email'];
				if(strcmp($name,$search_name)== 0){
					echo $name.'<br>';
					// Meter a linha em variaveis!
					// que são bastantes.
					//ver como mostrar a foto vai demorar talvez.
					//também pode-se fazer download talvez.
					$age = $query_row['age'];
		$height = 
		$weight = test_input($_POST['weight']);
		$weightUnits = $_POST['weightUnits'];
		$sexo = test_input($_POST['sexo']);
		$exercise = test_input($_POST['exercise']);
		$workouts = test_input($_POST['workouts']);
		$objective = test_input($_POST['objective']);
		$health = test_input($_POST['health']);
		$supplements = test_input($_POST['supplements']);
		$contact_text 
				}
			}
		}
	}else {
		//mysql_error() doesnt work;
		echo 'Query Fail';
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
        
        <!--Faltam aqui elementos: autor, palavras-chave -->
        
        <!-- JQuery para o slider-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidertron-1.1.js"></script>
        <script type="text/javascript" src="js/countries.js"></script>
    </head>
    <body>
        <header id="quesepassa2">
            <a href="index.html" class="logo1"><img src="images/ga.png" alt="Gains Anatomy Logo"></a>
            <h1 id="logo0"> Gains Anatomy</h1>
            <nav>
                <ul >
                    <li><a href="index.html"> Home</a></li>
                    <li><a href="articles.html"> Articles</a></li>
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
            
            <div id="form2">
                <form id=wtf action="shop.html" method="POST">
	               <input type="text" name="search" maxlength="25">
	               <input type="submit" value="Search">
                </form>
            </div>
        </div>
		
		<!-- enctype="multipart/form-data"-->
		
        <form id="userdata0" method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            
			<p id="userdata1">Please fill your details so we can build you your plan.</p>
			
			<div id="userdata2">
                <input title="Only letters please." type="text" name="age" maxlength="50" required pattern="\w+"
				placeholder="Your Age"> 
            </div>
			
			<div id="userdata3">
                <input title="Only numbers please." type="text" name="height" maxlength="50" required pattern="[0-9, \.]+"
				placeholder="Your Height"> 
            </div>
			
			<div id="userdata16">
				<select name="heightUnits">
				<option value=" ">Select</option>
				<option value="Metric">m</option>
				<option value="Imperial">in</option>
			  </select>
            </div>
			
			<div id="userdata4">
                <input title="Only numbers please." type="text" name="weight" maxlength="50" required pattern="[0-9, \.]+" 
				placeholder="Your Weight">
            </div>
			
			<div id="userdata17">
				<select name="weightUnits">
				<option value=" ">Select</option>
				<option value="Metric" required>kg</option>
				<option value="Imperial">lbs</option>
			  </select>
            </div>
			
			<fieldset id="userdata5">
                <legend>What is your Gender?</legend>
                <input type="radio" name="sexo" value="male" required> Male<br>
                <input type="radio" name="sexo" value="female"> Female<br>
            </fieldset>
            
			<fieldset id="userdata6">
                <legend>What is your daily activity level(Excluding Exercise)</legend>
                <input type="radio" name="exercise" value="sedentary" required> Sedentary <br>
                <input type="radio" name="exercise" value="lightlyActive"> Lightly Active <br>
				<input type="radio" name="exercise" value="active"> Active <br>
				<input type="radio" name="exercise" value="veryActive"> Very Active <br>
            </fieldset>
			
			<div id="userdata7">
                How many times do you workout per week?:<br>
                <input title="Only a number please." type="text" name="workouts" maxlength="4" required pattern="\d+"> 
            </div>
            
			<div id="userdata8">
				<legend>Tell us more about the execises you pratice:</legend>
				<input type="checkbox" name="gym"><lable> Gym(Hipertrophy, Strenght, Powerlifting, Resistance, etc) </lable><br>
				<input type="checkbox" name="endu"><lable> Endurance(Running, Cycling, etc) </lable><br>
				<input type="checkbox" name="group"><lable> Groupclass </lable><br>
				<input type="checkbox" name="calis"><lable> Calisthenics </lable><br>
				<lable> Other </lable>
				<input title="Only a word/letters please." type="text" name="other" pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<fieldset id="userdata9">
                <legend>What is your Objective?</legend>
                <input type="radio" name="objective" value="losefat" required> Lose Fat <br>
                <input type="radio" name="objective" value="IncMuscleMass"> Increase Muscle Mass <br>
				<input type="radio" name="objective" value="maintWeight"> Maintain Weight(Body Recomposition) <br>
            </fieldset>
			
			<div id="userdata10">
				<legend>Any Health Issues?</legend>
				<input title="Only letters please." type="text" name="health" placeholder="Please Specify" 
	pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<div id="userdata11">
				<legend>Do you take any supplements?</legend>
				<input title="Only letters please." type="text" name="supplements" placeholder="Please Specify" 
	required pattern="[a-zA-Z0-9, #\.\-ªº]+" maxlength="80"><br>
			</div>
			
			<div id="userdata12">
				<legend>Add a full body picture to evaluate your current stats and future progression.</legend>
				<!-- <form action="index2.php" method="POST" enctype="multipart/form-data"> -->
				<input type="file" name="file"><br><br>
			</div>
			
			<div id="userdata13">
				<legend>Any revelant information or questions you would like to ask?</legend>
				<textarea title="Only letters/words and numbers please." name="contact_text" rows="6" cols="30 maxlength="1000" 
				pattern="[a-zA-Z0-9, #\.\-ªº]+"></textarea><br><br>
			</div>
			
			<div id="userdata14">
				<p><img id="captcha" src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
				<small><a href="#" onclick="
					  document.getElementById('captcha').src = 'captcha.php?' + Math.random();
					  document.getElementById('captcha_code').value = '';
					  return false;
				">refresh</a></small></p>
				<p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');" required> 
				<small>copy the digits from the image into this box</small></p>
            </div>
			
	        <input id="userdata15" type="submit" value="Finished!">
        </form>
        
        <footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
    </body>
</html>