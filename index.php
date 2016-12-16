<?php
   require("Reservation.php");
   require("Destination.php");
   require("Person.php");
   session_start();
   
   $reservation;
   $page;
  
   
	/*
		verification of the model
	*/
	if(isset($reservation))
	{
		;
	}
	else	
	{
		$reservation= new Reservation();
	}
	
	/*retrieve of the page index 
	in the object reservation in the
	session's array	*/
	if(isset($_SESSION['reservation']))	 
    {   
		$reservation = unserialize($_SESSION['reservation']);
		$page = $reservation->getPage();
		$_SESSION['reservation']= serialize($reservation);
    }
   else
    {
	    $page=null;
    }
	
	/*update of the page index according to
	the button which was set in the view*/
	if(isset($_POST['back']))
	{	
		session_destroy();
		session_start();
		$page=0;
		$reservation = new Reservation();
		$_SESSION['reservation']= serialize($reservation);	
	}

	if(isset($_SESSION['reservation']))	 
    {  
	$reservation = unserialize($_SESSION['reservation']);
	}
	
	/*verification of the error flag*/
	if($reservation->getError()== false)
	{	
		if (isset($_POST['btn_next']))
		{
			$page=$page+1;		
		}
		
		if(isset($_POST['btn_prev']))
		{
			$page=$page-1;
		}
		$_SESSION['reservation']= serialize($reservation);	
	}
	else
	{	
		$_SESSION['reservation']= serialize($reservation);
		$page = $reservation->getPage();
	}
	
		
	
	
	
   /*
	 navigation between Views
   */
    switch ($page)
	{
		/*
			home page
		*/
		case 0 :
		
			include("Mainpage.php");//display
				
		break ;
		
		/*
			aqcuisition of passengers details
		*/
		case 1 :
			
				
			
			$reservation = unserialize($_SESSION['reservation']);
			if($reservation->getStateNbDes() == true)	
			{	
				$_SESSION['reservation']= serialize($reservation);
				include("Details.php");
			}	
			else
			{	
				/* set of the reservation details(destination 
				and number of passengers );
				if all the conditions are matched*/
				if((empty($_POST['destination']) != true) 
					AND (empty($_POST['nb_place'])!= true))
				{	
					/*verification of the destination textbox*/
					/**checking if there are numbers*/
					if(is_numeric($_POST['destination'])== false)
					{	
						/**Verification of the string length*/
						if(strlen($_POST['destination'])<=15)
						{
							$destination=$_POST['destination'];
						}
						else
						{
							/** Set of the error's flag*/
							$reservation->setError(true);
							/**set of page's index*/
							$reservation->setPage(0);
							$_SESSION['reservation']= serialize($reservation);
							
							/**display of the previous
							view.*/
							include('Mainpage.php');
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(0);
						$_SESSION['reservation']= serialize($reservation);
						include('Mainpage.php');
						break;
					}						
					
					/*Verification of number of passenger textbox*/
					/**checking if there ar only number
					in the field*/
					if(is_numeric($_POST['nb_place'])==true)
					{	
						if($_POST['nb_place'] != 0)
						{
							$nb_place=$_POST['nb_place'];
						}
						else
						{
							$reservation->setError(true);
							$reservation->setPage(0);
							$_SESSION['reservation']= serialize($reservation);
							include('Mainpage.php');
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(0);
						$_SESSION['reservation']= serialize($reservation);
						include('Mainpage.php');
						break;
					}
					/*checking  if the insurance checkbox is set*/
					if(isset($_POST['assu']))
					{	
						if($_POST['assu']== true)
						{
							$reservation->setAssurance("OUI");
						}
						else
						{
							$reservation->setAssurance("NON");
						}
					}
					else
					{
						$reservation->setAssurance("NON");
					}
						
					/*set of the reservation's details*/	
					$reservation->Details($destination,$nb_place);
					$reservation->setError(false);
					/*set of the flag state_nb_des*/
					$reservation->setStateNbDes(true);
					$_SESSION['reservation']= serialize($reservation);
					/*display of the next view*/	
					include("Details.php");//display
				}
				else
				{
					$reservation->setError(true);
					$reservation->setPage(0);
					$_SESSION['reservation']= serialize($reservation);
					include('Mainpage.php');
				}
			}
		break;
		
		/*
			display of reservation details
		*/
		case 2 :
					
			/*set of the passengers' names and ages */
			$reservation=unserialize($_SESSION['reservation']);
			for($i=0 ;$i<$reservation->getNbPerson();$i++)
			{	
				/**set of the flag state_na*/
				$reservation->setStateNA(false);
				
				/**set of the passengers' details ,
				if all the conditions are matched.*/
				if(isset($_POST['nom'.$i]) AND isset($_POST['age'.$i]))
				{
					/***checking the name length and 
					 the type of the age(int or not)*/
					if((strlen($_POST['nom'.$i])<30) 
						AND (is_numeric($_POST['age'.$i])== true))
					{
						/***checking if the age is bigger than zero*/
						if(($_POST['age'.$i] > 0 )
							AND (is_numeric($_POST['nom'.$i]) == false))
						{
							/***set of the passengers' details */
							$reservation->AddPerson($_POST['nom'.$i],$_POST['age'.$i],$i);
							/***set of the flag state_na*/
							$reservation->setStateNA(true);
						}
						else
						{
							$reservation->setError(true);
							$reservation->setPage(1);
							$_SESSION['reservation']= serialize($reservation);
							/*display of the previous view*/
							include("Details.php");//display
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(1);
						$_SESSION['reservation']= serialize($reservation);
						include("Details.php");//display
						break;
					}
				}
				else
				{
					$reservation->setError(true);
					$reservation->setPage(1);
					$_SESSION['reservation']= serialize($reservation);
					include("Details.php");//display
					break;
				}	
			}
			
			/*Display if the next view
			if the previous step is completed.*/
			if($reservation->getStateNA()== true)
			{
				$reservation->setError(false);
				/**calculation of the reservation
				cost*/
				$reservation->Total();
				$_SESSION['reservation']= serialize($reservation);	
				/*display of the next step*/
				include("Validation.php");
			}
		break;
		
		case 3 :
			/*display of the confirmation page*/
			include("Confirmation.php");
			/*recording of the reservation 
			informations in the database*/
			include("DataBase.php");
			session_destroy();
		break;
		
		case 4 :
			/*display of the adminstrtion page*/
			include("AdReservation.php");
			
		break;	
		
		
	}
?>


