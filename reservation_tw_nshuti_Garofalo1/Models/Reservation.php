<?php
/*
 * This class contains the application logic
 */
class Reservation
{
	//Fields
    //Array of passengers->objects Person
	private $list_person;
    
	//Destination
	private $destination;
    
	//number of passengers
	private $nb_person;
    
	//flag that indicates if the passengers
    //have chosen an insurance or not. 
	private $assurance;
	
	//State of the object reservation.
	private $state;
	
	//if set , the destination and 
	//the number of passengers are set. 
	private $state_nb_des;
	
	//if set , the name and 
	//age of passengers are set. 
	private $State_na;
	
	//total cost of the reservation
	private $total;
	
	//Unique id given to each reservation.
	private $person_id;
	
	//flag that indicates if an error occurred  
	//in the views.
	private $error;
	
	//Index of the current page
	private $page;
	//Flag used to verify deleting database entry in model
	private $db_delete;
	//Flag used to verify deleting database entry in controller
	private $db_delete_ok;
	//Variable carrying delete/update id of row to be deleted/updated from database
	private $id;
	//Flag allowing to record data in database
	private $insert_ok;
	//Flag allowing to retrieve record to update in database
	private $update_ok;
	//Flag allowing to update record in database
	private $update;
	//Variable holding original number of places for comparison during editing
	private $nbpersons_db;
	//Array size allowing to retrieve current size of $list_person
	//I.e. list of passengers for each reservation
	private $array_size;
	
	
	
	/*Constructor*/
	
   public function __construct()
    {
        $this->state = false ;
		$this->destination= null;
		$this->id= null;
		$this->assurance = "NON" ;
		$this->state_nb_des = false;
		$this->state_na = false;
		$this->error = false;
		$this->db_delete = false;
		$this->db_delete_ok = false;
		$this->insert_ok= true;   //Allow site users to enter new reservations
		$this->update_ok= false;
		$this->update= false;
		$this->person_id = rand(0,100); //Maximum number of passengers is 100
		$this->page=0;
		$this->array_size=0;
		$this->nbpersons_db=0;
		$this->list_person=array();
	}
	
	//Methods
	
	//This method will set the details (destination 
	//and number of places) of the booking. 
	public function Details($destination,$nb_person)
	{
		$this->destination=$destination;
        $this->nb_person = $nb_person;
		//Check the current array size and add
		//Persons accordingly
		if($this->array_size == 0)
		{
		for($i=0 ; $i< $nb_person ;$i++)
		{
			$n_person= new Person();
			$this->list_person[$this->array_size]=$n_person;
			$this->array_size++;
		}
		} else
		{
		for($i=$this->array_size ; $i< $nb_person ;$i++)
		{
			$n_person= new Person();
			$this->list_person[$this->array_size]=$n_person;
			$this->array_size++;
		}
		}		
		$this->state = true;
		$this->state_nb_des = true;	
	}
	
	//This method will set the details 
	//of the passenger.
    public function AddPerson($fullname ,$age,$i)
    {
	    $this->list_person[$i]->setName($fullname);
		$this->list_person[$i]->setAge($age);
    }
	
	//This method will calculate the total
	//price of a booking.
	public function Total()
	{
		$this->total = 0 ; 
		for($i=$this->nb_person-1 ; $i>-1 ; $i--)
		{
			if($this->list_person[$i]->getAge() < 13 )
			{
				$this->total = $this->total + 10 ;   
			}
			if($this->list_person[$i]->getAge() > 12 )
			{
				$this->total = $this->total + 15 ; 
			}	
		}
		if($this->assurance == "OUI")
		{
			$this->total = $this->total + 20 ;
		}
	}
	
	//This method will return the number 
	//of passengers
    public function getNbPerson()
    {
		return $this->nb_person;
    }
	
	//This method will set the number 
	//of passengers as retrieved from database
	//Used in update routine
    public function setNbPerson_db($nbpersons_db)
    {
		$this->nbpersons_db = $nbpersons_db;
    }
	
	//This method will return the number 
	//of passengers as retrieved from database
	//Used in update routine
    public function getNbPerson_db()
    {
		return $this->nbpersons_db;
    }
	
	//This function will return the name 
	//of the destination 
	public function getDestination()
	{
		return $this->destination;
	}
	
	//This method will return the name 
	//of the passenger at the index $i
	public function getPersonName($i)
	{
		$name = $this->list_person[$i];
		return $name->getName();
	}
	
	//This method will return the age
	//of the passenger at the index $i
	public function getPersonAge($i)
	{
		$age =$this->list_person[$i];
		return $age->getAge();
	}
	
	//This method will return 
	//the position of flag 'state'
	public function getState()
	{
		return $this->state;
	}
	
	//This method will set the
	//position of the flag 'state'
	public function setState($state)
	{
		 $this->state = $state;
	}
	//This method will return 
	//the position of flag 'insert_ok'
	public function getInsert_ok()
	{
		return $this->insert_ok;
	}
	
	//This method will set the
	//position of the flag 'state'
	public function setInsert_ok($state)
	{
		 $this->insert_ok = $state;
	}
	//This method will return 
	//the position of flag 'update_ok'
	public function getUpdate_ok()
	{
		return $this->update_ok;
	}
	
	//This method will set the
	//position of the flag 'state'
	public function setUpdate_ok($state)
	{
		 $this->update_ok = $state;
	}
	//This method will return 
	//the position of flag 'update'
	public function getUpdate()
	{
		return $this->update;
	}
	
	//This method will set the
	//position of the flag 'state'
	public function setUpdate($state)
	{
		 $this->update = $state;
	}
	//This method will return 
	//the position of flag 'db_delete'
	public function getdb_delete()
	{
		return $this->db_delete;
	}
	//This method will set the
	//position of the flag 'db_delete' 
	public function setdb_delete($state)
	{
		 $this->db_delete = $state;
	}
	//This method will return 
	//the position of flag 'db_delete'
	public function getdb_delete_ok()
	{
		return $this->db_delete_ok;
	}
	//This method will set the
	//position of the flag 'db_delete' 
	public function setdb_delete_ok($state)
	{
		 $this->db_delete_ok = $state;
	}
	//This method will return 
	//the value of deleteid
	public function getId()
	{
		return $this->id;
	}
	//This method will set 
	//the value of deleteid
	public function setId($delete_update_id)
	{
		 $this->id = $delete_update_id;
	}	
	
	//This method will return 
	//the flag state_nb_des*/
	public function getStateNbDes()
	{
		return $this->state_nb_des;
	}
	//This method will set
	//the flag state_nb_des
	public function setStateNbDes($state)
	{
		$this->state_nb_des = $state ;
	}
	
	//This method will return 
	//the total cost of the reservation
	public function getTotal()
	{
		return $this->total ;
	}
	
	//This method will set 
	//the insurance, "OUI"==True "NON"== False
	public function setAssurance($value)
	{
		$this->assurance = $value;
	}
	
	//This method will return 
	//the insurance state
	public function getAssurance()
	{
		return $this->assurance;
	}
	
	//This method will return 
	//the person identification number
	public function getPersonId()
	{
		return $this->person_id;
	}
	
	//This method will set 
	//the flag state_na
	public function setStateNA($state)
	{
		$this->state_na = $state;
	}
	
	//This method will return 
	//the flag state_na*/	
	public function getStateNA()
	{
		return $this->state_na;
	}
	
	//This method will set 
	//the flag error*/	
	public function setError($state)
	{
		$this->error = $state ;
	}
	
	//This method will return 
	//the flag error*/
	public function getError()
	{
		return $this->error;
	}
	//This function will set 
	//the page index
	public function setPage($page)
	{
		$this->page = $page ;
	}
	//This function will return 
	//the page index
	public function getpage()
	{
		return $this->page;
	}
    //This method will return the names 
	//of the passengers in the list
	public function getPersons()
	{
		return $this->list_person;
	}
	//This method will carry the names 
	//of the passengers in the db
	public function setPersons($List_person)
	{
		return $this->list_person = $List_person;
	}
	//This method deletes a passenger from a reservation
	//if number of places has been reduced. Used during 
	//update routine
	public function removePerson() 
	{  
		$this->array_size--;
		unset($this->list_person[$this->array_size]);
	}  
	
}
?>