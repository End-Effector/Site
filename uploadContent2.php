<?php
	// Page ARTICLES!
	
	// Para os acentos ficarem correctos. Receitas/Artigos têm de ser em Inglês.
	header('Content-Type: text/html; charset=ISO-8859-1');
	
	require 'connect.php';
	
	session_start();
	
	//Array sorting
	class article
	{
		public $article_number;
		public $order_flag;
				
		function __construct(){}
	}
	
	$articles_array 		= $_SESSION["array"];
	$starting_position_flag = $_SESSION["starting_position_flag"];
	
	/*
	foreach ($articles_array as $result) {
		echo $result->article_number;
		echo "<br>";
		echo $result->order_flag; 				
		echo "<br>";
	}*/
	
	//Muda a flag sempre que a função é chamada!
	if($starting_position_flag == 0){
		$_SESSION["starting_position_flag"] = 1;
	}else{
		$_SESSION["starting_position_flag"] = 0;
	}
	
	//starting_position_flag muda a posição de inicio
	//e o fim do ciclo.
	if($starting_position_flag == 0){
		$inicio = 0;
		$fim 	=  sizeof($articles_array)/2;
		
	}else{
		//$starting_position_flag == 1
		$inicio = 3;
		$fim 	=  sizeof($articles_array);
	}
	
	//TEM DE COMEÇAR NUM ESPECIFICO!
	
	while($inicio < $fim){
		
		$query = "SELECT * FROM articles WHERE Article = ".$articles_array[$inicio]->article_number."";
				
		if ($query_run = mysqli_query($mysqlcon,$query)){
									
			$query_num_rows = mysqli_num_rows($query_run);
					
			if($query_num_rows== NULL){
						
			}else{ 
						
				//So pode ir 3 de cada vez que isto corre até chegar ao máx.
				//nesse caso faz reset.
						
				foreach($query_run as $query_row){
					
					//CSS div 
					echo "<div id=\"auto_article\">";
					
					echo "<h2>".$query_row['Title']."</h2>";
								
					//Article might not have an image.
					if($query_row['hasImg'] == 1){
						
						/*
						//Scaling Image.
						$image_size = getimagesize($query_row['ImageName']);
						$image_width = $image_size[0].'<br>';
						$image_height = $image_size[1];
									
						$new_size = ($image_width + $image_height)/($image_width * ($image_height/18));
									
						$new_width = $image_width * $new_size;
						$new_height = $image_height * $new_size;
						*/
						
						echo "<img src=".$query_row['ImageName']." width=10vw height=10vw/>";
					}
								
					echo "<p>".$query_row['Resumo']."</p>";
								
					if($query_row['hasInfo'] == 1){
						/**Tabela Ingredientes***************************************/
						$query1 = "SELECT * FROM infoproduct WHERE Product = ".$query_row['InfoProductLocal']."";
									
						if ($query_run1 = mysqli_query($mysqlcon,$query1)){
										
							$query_num_rows1 = mysqli_num_rows($query_run1);
										
							if($query_num_rows1== NULL){
							
							}else{
											
								echo "<p id=\"auto_article_tab\"> Ingredient List </p>";
											
								foreach($query_run1 as $query_row1){
												
									$ingrediente = $query_row1['Drug1'];
									$i = 2;
												
									echo "<ul>";
									while($ingrediente != NULL){
										echo "<li>".$ingrediente."</il>";
										$ingrediente = $query_row1["Drug".$i.""];
										$i++;
									}
									echo "</ul>";
								}
							}
						}else {
							echo 'Query Fail';
						}
						
						/************************************************************/
						
					}
								
					if($query_row['hasbullets'] == 1){
									
						//Imprime tabela com os titulos
						$query1 = "SELECT * FROM Bullets WHERE Bullet = ".$query_row['BulletTable']."";
									
						if ($query_run1 = mysqli_query($mysqlcon,$query1)){
										
							$query_num_rows1 = mysqli_num_rows($query_run1);
										
							if($query_num_rows1== NULL){
							
							}else{
											
								//echo "<p id=\"auto_article_tab\"> Ingredient List </p>";
											
								//Imprime tabela com os titulos
								foreach($query_run1 as $query_row1){
												
									$titulo = $query_row1['BulletTitle1'];
									$i = 2;
													
									echo "<ul>";
									while($titulo != NULL){
										echo "<li>".$titulo."</il>";
										$titulo = $query_row1["BulletTitle".$i.""];
										$i++;
									}
									
									echo "</ul>";
								}
											
								//Imprime titulos e textos respectivos
								foreach($query_run1 as $query_row1){
												
									$titulo = $query_row1['BulletTitle1'];
									$texto  = $query_row1['BulletText1'];
									$i = 2;
												
									while($titulo != NULL){
										echo "<p id=\"auto_article_tab\">".$titulo."</p>";
										echo "<p>".$texto."</p>";
										$titulo = $query_row1["BulletTitle".$i.""];
										$texto = $query_row1["BulletText".$i.""];
										$i++;
									}
								}
							}
						}else {
							echo 'Query Fail';
						}
									
						/************************************************************/
						
					}else{

						echo $query_row['Text'];
						
						//Se tem informação das drogas também terá de macros
						//que estão na tabela nutricional.
						if($query_row['hasInfo'] == 1){
							$query3 = "SELECT * FROM nutricional WHERE Receitas = ".$query_row['Nutricional Local']."";
					
							if ($query_run3 = mysqli_query($mysqlcon,$query3)){
								
								$query_num_rows3 = mysqli_num_rows($query_run3);
								
								if($query_num_rows3== NULL){
					
								}else{
									
									echo "<p id=\"auto_article_tab\"> Nutricional Information </p>";
									
									foreach($query_run3 as $query_row3){
										echo "<ul>";
										echo "<li> Kcal:".$query_row3['Kcal']."</li>";
										echo "<li> Hidratos:".$query_row3['Hidratos']."</li>";
										echo "<li> Gordura:".$query_row3['Gordura']."</li>";
										echo "<li> Proteina:".$query_row3['Proteina']."</li>";
										echo "<li> Fibra:".$query_row3['Fibra']."</li>";
										echo "</ul>";
									}
								}
							}else {
								echo 'Query Fail';
							}
						}
					}
					
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
	
	//******************************************A P A G A    I S T O ************
	//Falta meter as TAGS CSS nos artigos que estão na primeira página e copiar o código para as FOODS.
	//Quando se carrega no botão tem de se fazer scrool UP!
?>