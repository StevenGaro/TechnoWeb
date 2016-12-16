
<html>
	<!--this page will allow the user to enter his destination
		and the number of passenger but also to select 
		an insurance or not -->
    <head>
        <meta charset="utf-8"/>
        <title>Reservation : acceuil</title>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
       
		<!-- Text -->
		<h1>Reservation</h1>
		 <?php
			
			/*verification of the error flag*/
			if(isset($_SESSION['reservation']))
			{	
				$reservation = unserialize( $_SESSION['reservation']);
				
				/**display of error message,
				if the error flag is set to "true"*/
				if($reservation->getError() == true)
				{
					echo'<p>Veuillez entrer une destination <br>
					Veuillez enter un nombre de personnes supérieur à 0 
					et inférieur à 10</p>';
				}
			}
		?>
        <p>
            Le prix de la place est de
            10€ jusqu'a 12 ans ensuite de 15€.<br>
            Le prix est de l'assurancence annulation
            est de 20€ que que soit le nombr
            de voyageurs.
        </p>
		<!-- -->

		<?php   
			/*
				form, the user will enter the destination 
				and de number of passanger for the trip.
			*/	
			
			
			
	
			/**
				data acquisition, if the model is set,
				for the pre-filling of the textboxes
			*/

			if($reservation->getStateNbDes() == true)
			{	$b="";
				if($reservation->getAssurance() == "OUI")
				{
					$b="checked";
				}
				$reservation->setStateNbDes(false);
				echo'<form method="post" action="index.php">
					<div class="cadre">
					<table> 
						<tr>
							<td>Destination:</td>
							<td><input type="text" name="destination" MAXLENGTH="30" 
							value="'.$reservation->getDestination().'"></td>
						</tr>
						<tr>
							<td>Nombres de places:</td>
							<td><input type="text" name="nb_place" MAXLENGTH="2"
							value="'.$reservation->getNbPerson().'"></td>
						</tr>
						<tr>
							<td>Assurance annulation</td>
							<td><input type="checkbox" name="assu" '.$b.' ></td>
						</tr>
					</table>
					</div>
					<table>
						<tr>
							<td><input type="submit" value="Etape suivante" 
								name="btn_next"></td>
							<td><input type="submit" value="Annuler réservation" 
								name="back"></td>
						</tr>
					</table>	
				</form>';
				
			}
			/**empty form*/
			else
			{
				
				echo'<form method="post" action="index.php">
					<div class="cadre">
					<table> 
						<tr>
							<td>Destination:</td>
							<td><input type="text" name="destination" MAXLENGTH="30"></td>
						</tr>
						<tr>
							<td>Nombres de places:</td>
							<td><input type="text" name="nb_place" MAXLENGTH="4"></td>
						</tr>
						<tr>
							<td>Assurance annulation</td>
							<td><input type="checkbox" name="assu" ></td>
						</tr>
					</table>	
					</div>	
					<table>
						<tr>
							<td><input type="submit" value="Etape suivante" 
								name="btn_next"></td>
							<td><input type="submit" value="Annuler réservation" 
								name="back"></td>
						</tr>
					</table>
				</form>';
			}
			/*set of the page index*/
			$reservation->setPage(0);
			/*set of the error flag*/
			$reservation->setError(false);
			$_SESSION['reservation']= serialize($reservation);
			
		?>
		
    </body>
</html>