<html>
	<!--
	This page will allow the management of all
	the reservations. This view is unique because
	it accesses the database.
	Seeing as a user cannot access this view, I figured the
	rules of a normal MVC model could be bent here.
	-->
	<head>
        <title>Reservations</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Content/style.css" />
    </head>
	
	<body>
		<?php
			//verification of the error flag
			$reservations =array();
			if(isset($_SESSION['reservation']))
			{	
				$reservation = unserialize( $_SESSION['reservation']);
				$administrator = unserialize( $_SESSION['administrator']);
				
				//display of error message,
				//if the error flag is set to "true"*/
				if($reservation->getError() == true)
				{
					echo'<p>Non autorisé <br></p>';
				}
			}
			//var_dump($administrator);
			$_SESSION['reservation']= serialize($reservation);
			
			//Connection to the database. Unique to this view
			$bdd = new mysqli("localhost","root","","tw_reservation_16186") or
					die ("Could not select database");		
			$query= "SELECT * FROM  reservation_details ORDER BY _timestamp DESC;";     			//sql request
					
			$result = $bdd->query($query) or die ("Query failed");	
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$reservations[] = $row;
				}
			}			
			else {
					echo "0 results";
				}			
		
			echo '<h1>Liste des réservations</h1>';
			
		?>
		<?php
				//Return to main page as a normal user
				echo'<form method="post" action="index.php">
					<br>
					<table>
						<tr>
							<td><input type="submit" value="Retourner" 
								name="back"></td>
						</tr>
					</table>
				</form>';
		?>
				<form method="POST" action="index.php">
						<table border="1" >
						<tr>
						    <tr>
							<th>TimeStamp</th>
							<th>PersonsID</th>
							<th>Number of Seats</th>
							<th>Destination</th>
							<th>Persons Details</th>
							<th>Insurance</th>
							<th>Total Price</th>
							<th></th>
							<th></th>
						</tr>
						<?php foreach($reservations as $reserv){ ?>
						<?php $persons_display = '';?>
						<?php $persons = unserialize(base64_decode($reserv['Persons_details'])); //Decode list of passengers from blob format?>
						<?php 
							//This loop handles how the array of Persons should
							//be displayed. Concatenate with '<br>' for separation
							foreach($persons as $_){
									$persons_display .= $_.'<br>';
								}?>
						        <tr>
									<td><?php echo $reserv['_timestamp']; ?></td>
									<td><?php echo $reserv['PersonsID']; ?></td>
									<td><?php echo $reserv['Number_of_places']; ?></td>
									<td><?php echo $reserv['Destination']; ?></td>
									<td><?php echo $persons_display; ?></td>
									<td><?php echo $reserv['Assurance']; ?></td>
									<td><?php echo $reserv['TotalPrice']; ?></td>
									<td><button type="submit" name="delete" formaction="index.php" value="<?php echo $reserv['PersonsID']; ?>">Delete</button></td>
									<td><button type="submit" name="editItem" formaction="index.php" value="<?php echo $reserv['PersonsID']; ?>">Edit</button></td>
								</tr>
								<?php } ?>
						</table>
				</form>;
		<?php
		//set of the page index
		$reservation->setPage(4);
		//set of the error flag
		$reservation->setError(false);
		?>
	</body>

</html>