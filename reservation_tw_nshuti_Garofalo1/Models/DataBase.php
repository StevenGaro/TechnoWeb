<?php
/*
 * This page will interact with the database. 
 * It saves the reservation's information.
 * It deletes a record from the database.
 * And it retrieves and updates records from the database.
 * The operation flags in the object reservation determine
 * which function is carried out by this model.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('Reservation.php');


if(isset($_SESSION['reservation']))
	{	
		$reservation = unserialize( $_SESSION['reservation']);	
		//display of error message,
		//if the error flag is set to "true"
		if($reservation->getError() == true)
		{
			echo'<p>Non autorisé <br></p>';
		}
	}
	
 $reservation= unserialize($_SESSION['reservation']);
 //Connection to the database
 $bdd = new mysqli("localhost","root","","tw_reservation_16186") or
 die ("Could not select database");

	//Deletion of a reservation in the database
	//if appropriate flag is set
	if($reservation->getdb_delete() == true){
		
		if($reservation->getId() != null)
		{
			//Delete query: use the id retrieved from button
			//delete to delete item fom database
			$deleteID = $reservation->getId();
			$sql = "DELETE FROM reservation_details where PersonsID = ".$deleteID.";";
			$bdd->query($sql);	 
		}

		if ($bdd->affected_rows > 0)
		{
			//The ID was deleted with success
			$reservation->setId(null);
		}
		else
		{
			echo "Couldn't delete the ID.";
		}
	}
	
	
	//Insertion of booking details
	//if appropriate flag is set
	if($reservation->getInsert_ok() == true){
		
		$Persons = base64_encode(serialize($reservation->getPersons())); //Encode list of passengers for blob format
		$sql = 'INSERT INTO reservation_details(PersonsID,Number_of_places,Destination
				,Persons_details,Assurance,TotalPrice) 
				VALUES('.$reservation->getPersonId().'
				,'.$reservation->getNbPerson().'
				,"'.$reservation->getDestination().'"
				,"'.$Persons.'"
				,"'.$reservation->getAssurance().'"
				,'.$reservation->getTotal().');';
		$bdd->query($sql);
	}
	$reservation->setInsert_ok(false);
	
	//if appropriate flag is set. Retrieve
	//record's information from database
	//for update routine 
	if($reservation->getUpdate_ok() == true)
	{
		$editID = $reservation->getId();
		$sql = "SELECT Number_of_places, Destination, Persons_details, Assurance FROM reservation_details WHERE PersonsID=".$editID.";";
		$result = $bdd->query($sql) or die ("Query failed");
				
		//This should not be looped more than once 
		while($row = $result->fetch_assoc())
        {
			if ($row == null)
			{
                echo "Couldn't reach db.";
			}
				$nbpersons=intval($row['Number_of_places']);
				$destination=$row['Destination'];
				$persons=unserialize(base64_decode($row['Persons_details']));  //Decode list of passengers from blob format
				$Assurance=$row['Assurance'];
				//Set the model reservation for pre-filling of all forms
                $reservation->Details($destination,$nbpersons);		
				//Save original number of places from database to compare 
				//to "new" number of places entered during editing
				$reservation->setNbPerson_db($nbpersons);            
				$reservation->setPersons($persons);
                $reservation->setAssurance($Assurance);
				$reservation->setStateNA(true);  
		}
		$reservation->setUpdate_ok(false);
	}
	
	//After information has been edited, update
	//record in database.
	if($reservation->getUpdate() == true)
		{
			$editID = $reservation->getId();
			$reservation = unserialize( $_SESSION['reservation']);	
			$Persons = base64_encode(serialize($reservation->getPersons()));
			$sql = "UPDATE reservation_details
					SET Number_of_places='".$reservation->getNbPerson()."',
						Destination='".$reservation->getDestination()."',
						Assurance='".$reservation->getAssurance()."',
						Persons_details='".$Persons."'
						WHERE PersonsID=".$editID.";";
					$bdd->query($sql);
				if ($bdd->affected_rows > 0)
					{
						//The ID was edited with success.
						$reservation->setId(null);
					}
		}
  
$_SESSION['reservation'] = serialize($reservation);  
 
?>