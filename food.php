<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8">
        <title>Gains Anatomy: Articles</title>
        <link href='https://fonts.googleapis.com/css?family=Kurale|Numans|Oleo+Script' rel='stylesheet' type='text/css'>
        <link href="styles/normalize.css" rel="stylesheet">
        <link href="styles/main.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <!--Faltam aqui elementos: autor, palavras-chave -->
        
        <!-- JQuery para o slider-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidertron-1.1.js"></script>
        <script type="text/javascript">
		
            $(window).load(function() {
				
                $( ".handle" ).on( "click", function() {
                    $("nav ul").toggleClass("showing");
                });
            }); 
			
				//Uploading new content function 3 VÍDEO!
				function insert(){
					if(window.XMLHttpRequest){
						xmlhttp = new XMLHttpRequest();
					}else{
						xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
					}
					
					xmlhttp.onreadystatechange = function() {
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
							document.getElementById('content').innerHTML = xmlhttp.responseText;
						}
					}
					
					xmlhttp.open('GET','uploadContent.php',true);
					xmlhttp.send();
					
				}
			
        </script>   
    </head>
    
	
    <body>
	
        <header>
			<a href="index.html" class="logo1"><img src="images/GA_new.png" alt="Gains Anatomy Logo" width="150px" height="150"></a>
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
            <h2 id="titulo">Food</h2>
                
            <div id="icons">
                <ul>
                    <!-- Faltam os links de referência.-->
                    <li><img src="images/facebook.png"/></li>
                    <li><img src="images/twitter.png"/></li>
                    <li><img src="images/YouTube.png"/></li>
                </ul>
            </div>
        </div>
		
		<?php
			require 'connect.php';
			
			$query = "SELECT * FROM food";
			
			//Array sorting
			class food
			{
				public $food_number;
				public $order_flag;
				
				function __construct(){}
			}
			
			$number_foods = 0;
			
			if ($query_run = mysqli_query($mysqlcon,$query)){
				
				$query_num_rows = mysqli_num_rows($query_run);				
			
				if($query_num_rows== NULL){
					
				}else{
					
					foreach($query_run as $query_row){
						
						//Array sorting of articles, building array.
						$food_obj = new food;
			
						$food_obj->food_number = $query_row['Receitas'];
						$food_obj->order_flag = $query_row['Sorting'];
				
						$foods_array[$number_foods] = $food_obj;
						
						$number_foods++;
					}
				}
			}
			
			//Sorting Function
			function cmp($a, $b)
			{
				if ($a->order_flag == $b->order_flag) {
					return 0;
				}
				return ($a->order_flag > $b->order_flag) ? -1 : 1;
			}
			
			usort($foods_array, "cmp");
			
			//echo "<br>";
			//echo "<br>";
			
			$_SESSION["starting_position_flag2"] = 0;
			$_SESSION["array2"]=$foods_array;
			
			echo '<script type="text/javascript">';
			echo  'insert();';
			echo  '</script>';

		?>
		
		<div id="content"></div>
		
		<p class="button" id="buttonFood"><a href="food.php#" onclick="insert();">More Food Recipes</a></p>
		
		<footer>
            <h4 id="footer1">Contactos</h4>
            <h4 id="footer2">Direitos Reservados</h4>
        </footer>
		
    </body>
</html>