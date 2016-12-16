
<html>
	<!--this page will display all the reservation information-->
    <head>
        <meta charset="utf-8" />
        <title>Reservation : acceuil</title>
        <link rel="stylesheet" href="style.css" />

    </head>

    <body>
        <h1>Validation Des Reservation</h1>
       
        <!-- form,
			it will display  all details of the reservation
		 -->
		<form method="post" action="index.php">
             <?php 
					$reservation = unserialize($_SESSION['reservation']);
					if(isset($reservation))
					{
							
			 ?>			<div class="cadre">
						<table>
							<tr>
								<!--destination-->
								<td>Destination:</td>
								<td><?php echo $reservation->getDestination();?></td>
							</tr>
							<tr>
								<!--number of passenger -->
								<td>Nombre de Place(s): </td>	
								
								<td><?php echo $reservation->getNbPerson();?></td>
							</tr>	
							
							<?php 
								/* display of details of each passenger*/
								for($i=0;$i<$reservation->getNbPerson();$i++)
									{
							?>
										<tr>
											<td>Nom : </td> 
											<td>
											<?php 
												echo $reservation->getPersonNom($i);
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
									  name="btn_next"></td> <!--next-->
								<td><input type="submit" 
									  value="Retour à la page précédente"
									  name="btn_prev"></td><!--previous-->
								<td><input type="submit" value="Annuler réservation" 
									  name="back"></td><!--annulation-->
							</tr>
						</table>
					
			<?php  
					}
					
			?>
		</form>
		<?php
			/*set of the page index*/
			$reservation->setPage(2);	
			$_SESSION['reservation'] = serialize($reservation);
		?>
	</body>
</html>