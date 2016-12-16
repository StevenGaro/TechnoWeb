<?php
/*this page will interact with the database 
and save the reservation's information*/

 $reservation= unserialize($_SESSION['reservation']);
 /*Connection to the database*/
 $bdd = new mysqli("localhost","root","","reservation") or
die ("Could not select database");

	/*Insertion of booking details*/
	/*sql request*/
	$sql = 'INSERT INTO recapitulatif(Destination
			,Assurance,Total,Personnes_id) 
             VALUES("'.$reservation->getDestination().'" 
		   ,"'.$reservation->getAssurance().'"
		   ,'.$reservation->getTotal().'
		   ,'.$reservation->getPersonId().');';
	$bdd->query($sql);
	
	/*Insertion of passengers details*/
	for($i=0 ; $i < $reservation->getNbPerson() ; $i++)
	{
		
		$sql='INSERT INTO personnes(id,Nom,Age) 
				VALUES ('.$reservation->getPersonId().',
				"'.$reservation->getPersonNom($i).'"
				,'.$reservation->getPersonAge($i).");";
		$bdd->query($sql);
	}
  
$_SESSION['reservation'] = serialize($reservation);  
 
?>