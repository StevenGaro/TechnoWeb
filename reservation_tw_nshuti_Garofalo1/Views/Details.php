
<html>
	<!--
	This page allows the user to enter the
	name and age of all the passengers. 
	-->
    <head>
        <title> Reservation Details</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Content/style.css" />
    </head>
	<body>
		<h1>Details des Reservations</h1>
		 <?php
			//var_dump($reservation);
			//verification of the error flag
			if(isset($_SESSION['reservation']))
			{	
				$reservation = unserialize( $_SESSION['reservation']);
				//Display error message if the error flag is set to "true"
				if($reservation->getError() == true)
				{
					echo'<p>Veuillez entrer un nom pour chaque personne<br>
							Veuillez entrer un age supérieur à 0</p>';
					
				}
			}
		?>
		
		<?php

			//Second form , the user will enter the name and the age of each passenger.
			//Each age and name will be saved with an index.
			$reservation = unserialize($_SESSION['reservation']);
			
			//Data acquisition, if the model is set,
			//for the pre-filling of the text boxes
			if($reservation->getStateNA()== true)
			{	
				echo '<form method ="post" action="index.php">';
					//Display of text boxes with the respective
					//name and age of each passenger
					for($i=0; $i<$reservation->getNbPerson();$i++)
					{
						echo'
							<table>
								<tr>
									<td>Nom:</td> 
									<td><input type="text" name="name'.$i.'"
										value="'.$reservation->getPersonName($i).'"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type="text" name="age'.$i.'"
										value="'.$reservation->getPersonAge($i).'"></td>
								</tr>
							</table>';
					}
				
				echo'
					<table>
						<tr>
							<td>
								<input type="submit" value="Etape suivante" 
								name="btn_next_page">
							</td>
							<td>
								<input type="submit" value="Retour à la page précédante"
								name="btn_prev_page">
							</td>
							<td>
								<input type="submit" value="annuler la reservation"
								name="back">
							</td>
						</tr>
					</table>
				</form>';
			}
			//Empty form if the model is not set
			//form with no pre-fills
			else
			{	
				echo '<form method ="post" action="index.php">';
					for($i=0; $i<$reservation->getNbPerson();$i++)
					{
						echo'
							<table>
								<tr>
									<td>Nom:</td> 
									<td><input type="text" name="name'.$i.'"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type="text" name="age'.$i.'"></td>
								</tr>
							</table>';
					}
					
				echo'
					<table>
						<tr>
							<td>
								<input type="submit" value="Etape suivante" 
								name="btn_next_page">
							</td>
							<td>
								<input type="submit" value="Retour à la page précédante"
								name="btn_prev_page">
							</td>
							<td>
								<input type="submit" value="annuler la reservation"
								name="back">
							</td>
						</tr>
					</table>
				</form>';				
			}			
			//set of the page index
			$reservation->setPage(1);
			//set of the error flag	
			$reservation->setError(false);
			$_SESSION['reservation']= serialize($reservation);	
		
		?>
	</body>				

</html>
