
<html>
	<!--
	This page will display all the reservation information
	-->
    <head>
        <meta charset="utf-8" />
        <title>Reservation : HOME</title>
        <link rel="stylesheet" href="Content/style.css" />

    </head>

    <body>
        <h1>Validation des Reservation</h1>
 
		<form method="post" action="index.php">
             <?php 
					$reservation = unserialize($_SESSION['reservation']);
					if(isset($reservation))
					{
						//var_dump($reservation);
							
			 ?>			<div class="cadre">
						<table>
							<tr>
								<!--Destination-->
								<td>Destination:</td>
								<td><?php echo $reservation->getDestination();?></td>
							</tr>
							<tr>
								<!--Number of passenger -->
								<td>Nombre de Place(s): </td>	
								
								<td><?php echo $reservation->getNbPerson();?></td>
							</tr>	
							
							<?php 
								//Display details of each passenger
								for($i=0;$i<$reservation->getNbPerson();$i++)
									{
							?>
										<tr>
											<td>Nom : </td> 
											<td>
											<?php 
												echo $reservation->getPersonName($i);
											?>
											</td>
										</tr>
										<tr>
											<td>Age : </td>
											<td>
											<?php 
												echo $reservation->getPersonAge($i);
											?>
											</td>
										</tr>
										
							<?php	
									}
							?>
										<tr>
											<td> Assurence annulation : </td>
											<td>
											<?php	
												echo $reservation->getAssurance();
											?>
											</td>
										</tr>
							
						</table>
						</div >
						<table>	
							<tr>
								<td><input type="submit" value="Confimer" 
									  name="btn_next_page"></td> <!--next-->
								<td><input type="submit" 
									  value="Retour à la page précédente"
									  name="btn_prev_page"></td><!--previous-->
								<td><input type="submit" value="Annuler réservation" 
									  name="back"></td><!--annulation-->
							</tr>
						</table>
					
			<?php  
					}
					
			?>
		</form>
		<?php
			//set of the page index
			$reservation->setPage(2);
			//set of the error flag	
			$reservation->setError(false);
			$_SESSION['reservation']= serialize($reservation);	
		?>
	</body>
</html>