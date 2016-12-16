
<html>
	<!--this page will allow the user to enter the details
	, as name and age , of all the passengers. -->
    <head>
        <title> Details Reservation</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" />
    </head>
	<body>
		<h1>Details de la Reservation</h1>
		 <?php
			
			/*verification of the error flag*/
			if(isset($_SESSION['reservation']))
			{	
				$reservation = unserialize( $_SESSION['reservation']);
				/**display of error message,
				if the error flag is set to "true"*/
				if($reservation->getError() == true)
				{
					echo'<p>Veuillez entrer un nom pour chaque personne<br>
							Veuillez entrer un age supérieur à 0</p>';
					
				}
			}
		?>
		
		<?php
			/*
				form , the user will enter the details of each passenger
				,the name and the age.
				each age and name will be saved with an index.
			*/
			$reservation = unserialize($_SESSION['reservation']);
			
			/**
				data acquisition, if the model is set,
				for the pre-filling of the textboxes
			*/
			if($reservation->getStateNA()== true)
			{	
				echo '<form method ="post" action="index.php">';
					/**display of textboxes(name and age), for each passenger*/
					for($i=0; $i<$reservation->getNbPerson();$i++)
					{
						echo'
							<table>
								<tr>
									<td>Nom:</td> 
									<td><input type="text" name="nom'.$i.'"
										value="'.$reservation->getPersonNom($i).'"></td>
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
								name="btn_next">
							</td>
							<td>
								<input type="submit" value="Retour à la page précédante"
								name="btn_prev">
							</td>
							<td>
								<input type="submit" value="annuler la reservation"
								name="back">
							</td>
						</tr>
					</table>
				</form>';
			}
			/**empty form*/
			else
			{	
				echo '<form method ="post" action="index.php">';
					for($i=0; $i<$reservation->getNbPerson();$i++)
					{
						echo'
							<table>
								<tr>
									<td>Nom:</td> 
									<td><input type="text" name="nom'.$i.'"></td>
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
								name="btn_next">
							</td>
							<td>
								<input type="submit" value="Retour à la page précédante"
								name="btn_prev">
							</td>
							<td>
								<input type="submit" value="annuler la reservation"
								name="back">
							</td>
						</tr>
					</table>
				</form>';
				
			}			
			/*set of the page index*/
			$reservation->setPage(1);
			/*set of the error flag*/	
			$reservation->setError(false);
			$_SESSION['reservation']= serialize($reservation);	
		
		?>
	</body>				

</html>
