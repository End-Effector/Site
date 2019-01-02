<?php
	// Page FOOD!
	
	
	// Para os acentos ficarem correctos. Receitas/Artigos têm de ser em Inglês.
	header('Content-Type: text/html; charset=ISO-8859-1');
	
	require 'connect.php';
	
	//echo $number_articles;
	//echo $current_articles;
	
	session_start();
	
		//Array sorting
	class food
	{
		public $food_number;
		public $order_flag;
				
		function __construct(){}
	}
	
	$foods_array 		= $_SESSION["array2"];
	$starting_position_flag2 = $_SESSION["starting_position_flag2"];
	
	
	//Muda a flag sempre que a função é chamada!
	if($starting_position_flag2 == 0){
		$_SESSION["starting_position_flag2"] = 1;
	}else{
		$_SESSION["starting_position_flag2"] = 0;
	}
	
	//starting_position_flag muda a posição de inicio
	//e o fim do ciclo.
	if($starting_position_flag2 == 0){
		$inicio = 0;
		$fim 	=  sizeof($foods_array)/2;
		
	}else{
		//$starting_position_flag2 == 1
		$inicio = 3;
		$fim 	=  sizeof($foods_array);
	}
	
	while($inicio < $fim){
	
		$query = "SELECT * FROM food WHERE Receitas = ".$foods_array[$inicio]->food_number."";
			
		if ($query_run = mysqli_query($mysqlcon,$query)){
							
			$query_num_rows = mysqli_num_rows($query_run);
			
			if($query_num_rows== NULL){
				
			}else{ 
				
				//So pode ir 3 de cada vez que isto corre até chegar ao máx.
				//nesse caso faz reset.
				
				foreach($query_run as $query_row){
						
					//CSS div 
					echo "<div id=\"auto_food\">";
					
					echo "<h2>".$query_row['Title']."</h2>";
					
					//Scaling Image.
					$image_size = getimagesize($query_row['Image Name']);
					$image_width = $image_size[0].'<br>';
					$image_height = $image_size[1];
					
					//Adjust number for scaling.
					//number needs to be connected to the size of the screen. How to get size of the screen?
					$new_size = ($image_width + $image_height)/($image_width * ($image_height/180));
					
					$new_width = $image_width * $new_size;
					$new_height = $image_height * $new_size;
					//End of scaling.
					
					echo "<img src=".$query_row['Image Name']." width=\"".$new_width."vw\"height=\"".$new_height."vw\"/>";
					echo "<p>".$query_row['Resumo']."</p>";
					
					/**Tabela Ingredientes***************************************/
					$query1 = "SELECT * FROM ingredients WHERE Receitas = ".$query_row['Ingredients Local']."";
					
					if ($query_run1 = mysqli_query($mysqlcon,$query1)){
						
						$query_num_rows1 = mysqli_num_rows($query_run1);
						
						if($query_num_rows1== NULL){
			
						}else{
							
							echo "<p id=\"auto_food_tab\"> Ingredients List </p>";
							
							foreach($query_run1 as $query_row1){
								
								$ingrediente = $query_row1['Ingredient1'];
								$i = 2;
								
								echo "<ul>";
								while($ingrediente != NULL){
									echo "<li>".$ingrediente."</il>";
									$ingrediente = $query_row1["Ingredient".$i.""];
									$i++;
								}
								echo "</ul>";
							}
						}
					}else {
						echo 'Query Fail';
					}
					/************************************************************/
					
					//Os paragrafos no texto inserido na base de dados têm de ter marcas html5 <p></p>
					echo $query_row['Text'];
					
					/**Tabela Nutricional****************************************/
					$query3 = "SELECT * FROM nutricional WHERE Receitas = ".$query_row['Nutricional Local']."";
					
					if ($query_run3 = mysqli_query($mysqlcon,$query3)){
						
						$query_num_rows3 = mysqli_num_rows($query_run3);
						
						if($query_num_rows3== NULL){
			
						}else{
							
							echo "<p id=\"auto_food_tab\"> Nutricional Information </p>";
							
							foreach($query_run3 as $query_row3){
								echo "<ul>";
								echo "<li> Calories: ".$query_row3['Kcal']." kcal</li>";
								echo "<li> Carbs: ".$query_row3['Hidratos']." g</li>";
								echo "<li> Fat: ".$query_row3['Gordura']." g</li>";
								echo "<li> Protein: ".$query_row3['Proteina']." g</li>";
								echo "<li> Fiber: ".$query_row3['Fibra']." g</li>";
								echo "</ul>";
							}
						}
					}else {
						echo 'Query Fail';
					}
					/*************************************************************/
					
					//CSS div fim.
					echo "</div>";				
				}
				
			}
		}else {
			
			echo 'Query Fail';
		}
		
		//Incrementa o ciclo.
		$inicio++;
	}
?>