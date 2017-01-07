<html>
	<!--
	This page confirms the recording of a 
	new reservation and shows the total price
	of the reservation.
	-->
    <head>
        <title>Reservation Confirmation</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Content/style.css" />
    </head>
	<body>
		<h1>Confirmation de la reservation</h1>
		<?php
			
			if(isset($_SESSION['reservation']))
			{	
				$reservation = unserialize( $_SESSION['reservation']);
				
				//Display message of successful updating of a record in the
				//database. Set operational flags back to default values.
				if(($reservation->getUpdate() == true) AND ($reservation->getId() == null))
				{
					echo'<p>The ID: '.$reservation->getId().' was updated with success. <br></p>';
					$reservation->setUpdate(false);
				}
			}
			//var_dump($reservation);
		?>
		<table>
			<tr>
				<p>
					<!--Display the reservation price-->
					<?php echo'Votre demande a bien été enregistrée.';?></br>
					<?php echo 'Merci de bien vouloir verser la somme '
								 .$reservation->getTotal().  
								' euro sur le compte 000-000000-00'; 
					?>
				</p>
			</tr>
		
			<tr>
				<!--Fourth form-->
				<form method ="post" action="index.php">
				<td>
					<input type="submit" value="Retour à la page d'acceuil"
						name="back"><!--back to home page-->
				</td>
				<!--<td>
					<input type="submit" value="Page d'administration"
						name="btn_next_page">             
				</td>--> <!--button used during debugging to go to administration page-->
				</form>
			</tr>
	
		</table>
		<?php
			//set of the page index
			$reservation->setPage(3);
			//set of the error flag
			$reservation->setError(false);
			$_SESSION['reservation']= serialize($reservation);
		?>
	</body>				
</html>