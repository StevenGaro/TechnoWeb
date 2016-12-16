<html>
	<!--this page will allow the user to confirm 
		or not his/her reservation-->
    <head>
        <title>Confirmation des reservation</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" />
    </head>
	<body>
		<h1>Confirmation de la reservation</h1>
    <?php $reservation=unserialize($_SESSION['reservation']);?>
		<table>
			<tr>
				<p>
					<!--display of the reservation price-->
					<?php echo'Votre demande a bien été enregistrée.';?></br>
					<?php echo 'Merci de bien vouloir verser la somme '
								 .$reservation->getTotal().  
								' euro sur le compte 000-000000-00'; 
					?>
				</p>
			</tr>
		
			<tr>
				<!--form-->
				<form method ="post" action="index.php">
					<input type="submit" value="Retour à la page d'acceuil"
						name="back"><!--back to home page-->
				</form>
			</tr>
	
		</table>
		<?php
			$reservation->setPage(3);	
			$_SESSION['reservation']= serialize($reservation);
		?>
	</body>				
</html>