<?php
	/*
	* This is the main controller. It tests and validates information 
	* received from the different views. It uses switch case function 
	* to control navigation between the different views.
	* Page 4, the administration view is only accessible by passing 
	* through the second controller called 'admin.php'. 
	* This is achieved by typing the url: localhost/reservation_tw_nshuti/admin.php
	* 
	*/
   require_once("Models/Reservation.php");
   require_once("Models/Person.php");
   require_once("Models/AdminPerson.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
   
   $reservation;
   $page;
   $administrator;
   $admin_mode;

	//Verify if the model is set. If not
    //create new reservation object.
	if(isset($reservation))
	{
		;
	}
	else	
	{
		$reservation= new Reservation();
	}
	
	//Retrieve the page index from the object
	//reservation in the session's array
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
	
	//Update the page index according to
	//the button which was set in the view
	if(isset($_POST['back']))
	{	
		session_destroy();
		session_start();
		$page=0;                                          //set to default main page
		$reservation = new Reservation();
		$_SESSION['reservation']= serialize($reservation);	
	}
	
	//Administrator routine for deleting a reservation 
	//from database
	if(isset($_POST['delete']) and is_numeric($_POST['delete']))
	{
		session_destroy();
		session_start();                                        
		$reservation = new Reservation();
		//Set the flags appropriately for operations on database
		$reservation->setInsert_ok(false);   
		$reservation->setdb_delete(true);
		$deleteID = $_POST['delete'];
		//Save reservation's id to match in SQL queries
		$reservation->setId($deleteID); 
		$reservation->setPage(0);
		$page=$reservation->getPage();                  //set to default main page
	}
	
	//Administrator routine to edit a reservation
	if(isset($_POST['editItem']) and is_numeric($_POST['editItem']))
	{
		session_destroy();
		session_start();                                        
		$reservation = new Reservation();
		$reservation->setInsert_ok(false);
		$reservation->setUpdate_ok(true);
		$editID = $_POST['editItem'];
		$reservation->setId($editID);
		$reservation->setPage(0);
		$page=$reservation->getPage();                //set to default main page
		$_SESSION['reservation']= serialize($reservation);
	}
	if(isset($_SESSION['reservation']))	 
    {  
	$reservation = unserialize($_SESSION['reservation']);
	}
	
	//Verify the error flag and set page 
	//index according to button pressed in views
	if($reservation->getError()== false)
	{	
		if (isset($_POST['btn_next_page']))
		{
			$page=$page+1;		
		}
		
		if(isset($_POST['btn_prev_page']))
		{
			$page=$page-1;
		}
		if(isset($_SESSION['administrator']))
		{
			$reservation->setPage(4);
			$page=$reservation->getPage();
		}
		$_SESSION['reservation']= serialize($reservation);
		
	}
	else
	{	
		$_SESSION['reservation']= serialize($reservation);
		$page = $reservation->getPage();
	}
	
	//Switch case used to navigate between Views
    switch ($page)
	{
		//home page
		case 0 :
			//Deleting of information in the database 
			//if flag is set
			if(($reservation->getdb_delete() == true) OR ($reservation->getUpdate_ok() == true))
			{
				include("Models/DataBase.php");
			}
			//display
			include("Views/Mainpage.php");
				
		break ;
		
		//Acquisition of passengers details
		case 1 :
			
				
			
			$reservation = unserialize($_SESSION['reservation']);
			if($reservation->getStateNbDes() == true)	
			{	
				$_SESSION['reservation']= serialize($reservation);
				include("Views/Details.php");
			}	
			else
			{	
				///Set the reservation details(destination and number of passengers)
				//if all the conditions are matched
				if((empty($_POST['destination']) != true) 
					AND (empty($_POST['nb_place'])!= true))
				{	
					//Verification of the destination text box
					//checking if there are any numbers
					if(is_numeric($_POST['destination'])== false)
					{	
						//Verification of the string length
						if(strlen($_POST['destination'])<=15)
						{
							$destination=$_POST['destination'];
						}
						else
						{
							//Set of the error's flag
							$reservation->setError(true);
							//Set of page index
							$reservation->setPage(0);
							$_SESSION['reservation']= serialize($reservation);
							
							//display the previous view
							include('Views/Mainpage.php');
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(0);
						$_SESSION['reservation']= serialize($reservation);
						include('Views/Mainpage.php');
						break;
					}						
					
					//Verification of number of passenger text box
					//checking if there are only numbers in the field
					if(is_numeric($_POST['nb_place'])==true)
					{	
						if($_POST['nb_place'] != 0)
						{
							$nb_place=$_POST['nb_place'];
							//Administrator edit routine: If new number of places
							//is less than original record, delete objects
							//person from array
							$nb_place_db = $reservation->getNbPerson_db();
							if($nb_place < $nb_place_db)
							{
								$delete_counter = $nb_place_db - $nb_place;
								for($a = 1; $a <= $delete_counter; $a++)
								{
									$reservation->removePerson();	
								}
							}
						}
						else
						{
							$reservation->setError(true);
							$reservation->setPage(0);
							$_SESSION['reservation']= serialize($reservation);
							include('Views/Mainpage.php');
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(0);
						$_SESSION['reservation']= serialize($reservation);
						include('Views/Mainpage.php');
						break;
					}
					//Checking  if the insurance checkbox is set
					if(isset($_POST['assurance']))
					{	
						if($_POST['assurance']== true)
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
						
					//Set of the reservation's details	
					$reservation->Details($destination,$nb_place);
					//Save original number of places in order to compare 
					//to "new" number of places entered during editing
					$reservation->setNbPerson_db($nb_place);              
					$reservation->setError(false);
					//Set of the flag state_nb_des
					$reservation->setStateNbDes(true);
					$_SESSION['reservation']= serialize($reservation);
					//Display the next view	
					include("Views/Details.php");
				}
				else
				{
					$reservation->setError(true);
					$reservation->setPage(0);
					$_SESSION['reservation']= serialize($reservation);
					include('Views/Mainpage.php');
				}
			}
		break;
		
		//Display of reservation details
		case 2 :
					
			//Set the passengers' names and ages
			$reservation=unserialize($_SESSION['reservation']);
			for($i=0 ;$i<$reservation->getNbPerson();$i++)
			{	
				//Set the flag state_na
				$reservation->setStateNA(false);
				
				//Set of the passengers' details ,
				//if all the conditions are matched.
				if(isset($_POST['name'.$i]) AND isset($_POST['age'.$i]))
				{
					//Checking the name length and 
					//the type of the age(int or not)
					if((strlen($_POST['name'.$i])<30) 
						AND (is_numeric($_POST['age'.$i])== true))
					{
						//Checking if the age is bigger than zero
						if(($_POST['age'.$i] > 0 )
							AND (is_numeric($_POST['name'.$i]) == false))
						{
							//Set the passengers' details 
							$reservation->AddPerson($_POST['name'.$i],$_POST['age'.$i],$i);
							//Set the flag state_na
							$reservation->setStateNA(true);
						}
						else
						{
							$reservation->setError(true);
							$reservation->setPage(1);
							$_SESSION['reservation']= serialize($reservation);
							//Display the previous view
							include("Views/Details.php");//display
							break;
						}
					}
					else
					{
						$reservation->setError(true);
						$reservation->setPage(1);
						$_SESSION['reservation']= serialize($reservation);
						include("Views/Details.php");//display
						break;
					}
				}
				else
				{
					$reservation->setError(true);
					$reservation->setPage(1);
					$_SESSION['reservation']= serialize($reservation);
					include("Views/Details.php");//display
					break;
				}	
			}
			
			//Display the next view if the previous step is completed.
			if($reservation->getStateNA()== true)
			{
				$reservation->setError(false);
				//Calculate cost of the reservation
				$reservation->Total();
				$_SESSION['reservation']= serialize($reservation);	
				//Display of the next step
				include("Views/Validation.php");
			}
		break;
		
		case 3 :
			//Recording(inserting) or updating of the reservation 
			//information in the database
			//Only for Administrator updating routine
			if(($reservation->getUpdate_ok() != true) AND ($reservation->getInsert_ok() == false))
			{
				$reservation = unserialize($_SESSION['reservation']);
				$reservation->setUpdate(true);
				$_SESSION['reservation']= serialize($reservation);			
			}
			//Normal inserting routine
			include("Models/DataBase.php");	
			//display the confirmation page
			include("Views/Confirmation.php");
		break;
		
		case 4 :
			//Display the administration page if the model is set
			//and the administrator mode flag is in the right position
			if(isset($_SESSION['administrator']))	 
			{   
				$administrator = unserialize($_SESSION['administrator']);
				if($administrator->getAdmin_mode() == true){
				include("Views/AdReservation.php");
				$_SESSION['administrator']= serialize($administrator);
				}
			}
			else
			{
				include("Views/error.php");
			}
			
		break;	
		default:
			//Display the error page 
			include("Views/error.php");
		
		
	}
?>


