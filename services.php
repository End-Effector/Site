<?php
	
	require 'core.php';
	
	require 'connect.php';
	
	if(loggedin()){
		//Está logged in.
		//Têm de aparecer duas coisas o menu de logout e o botão de comprar(buy.php)
		echo '<div id="servicesLoggedIn"><p id="create3">You\'re logged in.</p>';
		echo '<a id="create4" class="button" href="logout.php">Log Out</a><br>';
		echo '<a id="create5" class="button" href="shop.php">Proceed to Shop</a><br>';
		echo '<a id="create6" class="button" href="userData.php">Your Profile</a>';
		echo '</div>';
	}else{
		// Não está logged in.
		// Logo têm de aparecer duas coisas, o botão para o registo(shop2.php) e o menu de log in.
		echo '<div id="servicesNotLoggedIn"><p id= "create2">Please sign in or register.</p>';
		echo '<a id="create" class="button" href="signUp.php">Create an account here.</a>';
		include 'loginform.php';
		echo '</div>';
	}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Gains Anatomy: Services</title>
        <link href='https://fonts.googleapis.com/css?family=Kurale|Numans|Oleo+Script' rel='stylesheet' type='text/css'>
        <link href="styles/normalize.css" rel="stylesheet">
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <!--Faltam aqui elementos: autor, palavras-chave -->
        
        <!-- JQuery para o slider-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidertron-1.1.js"></script>
		<script type="text/javascript" src="js/countries.js"></script>
		<!-- 
        <script type="text/javascript">
            $(window).load(function() {
                
                $( ".handle" ).on( "click", function() {
                    $("nav ul").toggleClass("showing");
                });

            })();
			
        </script> -->   
    </head>
    <body>
	
	<script>
		jQuery('body').css('display','none');
		jQuery(document).ready(function() {
			jQuery('body').fadeIn();
			jQuery('a').on('click',function(event){
				var thetarget = this.getAttribute('target')
				if (thetarget != "_blank"){			
					var thehref = this.getAttribute('href')
					event.preventDefault();
					jQuery('body').fadeOut(function(){
						//alert(thehref)
						window.location = thehref					
					});
				}
			});
		});
		setTimeout(function(){
			jQuery('body').fadeIn();
		},1000)
	</script>
	
        <header>
            <h1 id="logo0"> Gains Anatomy</h1>
            <nav>
                <ul >
                    <li><a href="index.html"> Home</a></li>
                    <li><a href="articles.php"> Articles</a></li>
                    <li><a href="food.php"> Food</a></li>
                    <li class="fix"><a href="services.php"> Services</a></li>
                </ul>
                <div id="aki" class="handle">&#9776; Menu</div>
            </nav>
        </header>
        
        <div id="barra">
            <h2 id="titulo">Services</h2>
                
            <div id="icons">
                <ul>
                    <!-- Faltam os links de referência.-->
                    <li><img src="images/facebook.png"/></li>
                    <li><img src="images/twitter.png"/></li>
                    <li><img src="images/YouTube.png"/></li>
                </ul>
            </div>
        </div>
        
		<div id="box">
			<div id="plan">
				<h3 id="tit-plan">Basic</h3>
				<ul>
					<li> Macros Calculation</li>
					<li> Guide on how to properly configure and use Myfitnesspal website.</li>
					<li> List with suggestions of foods for each macronutrient</li>
				</ul>

				<h3 id="tit-plan2">Basic&ndash;Prices:</h3>
				<ul id="preco">
					<li> 9,99&euro; (Delivered to your email in 24h.) </li>
				</ul>
			</div>

			<div id="plan">
				<h3 id="tit-plan">Basic PlusOne</h3>
				<ul>
					<li> Macros Calculation</li>
					<li> Guide on how to properly configure and use Myfitnesspal website.</li>
					<li> List with suggestions of foods for each macronutrient</li>
					<li> Weakly support from our team for calorie/macronutient adjustemsts or any questions that might come up.</li>
				</ul>
				
				<h3 id="tit-plan2">Basic PlusOne&ndash;Prices:</h3>
				<ul id="preco">
					<li> 4 weaks &ndash; 40&euro; (10&euro; per weak.)</li>
					<li> 8 weaks &ndash; 68&euro; (8,5&euro; per weak.)</li>
					<li> 12 weaks &ndash; 84&euro; (7&euro; per weak.)</li>
				</ul>
				
			</div>
        </div>
		
        <footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
    </body>
</html>