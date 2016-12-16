<?php

/*this class contains the application logic*/
class Reservation
{
    /*Array of objects Person*/
	private $list_person;
    
	/*object Destination*/
	private $destination;
    
	/*number of passengers*/
	private $nb_person;
    
	/*flag that indicate if the passengers
		have choose a insurance or not. */
	private $assurance;
	
	/*State of the object reservation.*/
	private $state;
	
	/* if set , the destination and 
		the number of passengers are set. */
	private $state_nb_des;
	
	/* if set , the name and 
		age of passengers are set. */
	private $State_na;
	
	/*total cost of the reseration*/
	private $total;
	
	/* identification number of passengers,
	it's the same for all the passengers of a reservation.
	it's also the index of these passengers in the database.*/
	private $person_id;
	
	/*flag that indicate if an error occured or not 
	,in the views.*/
	private $error;
	
	/*it's the index of the current page*/
	private $page;
	
	
	
	/*Constructor*/
	
   public function __construct()
    {
        $this->state = false ;
		$this->destination= new Destination();
		$this->assurance = "NON" ;
		$this->state_nb_des = false;
		$this->state_na = false;
		$this->error = false;
		$this->person_id = rand(0,100); 
		$this->page=0;
	}
	
	/*functions*/
	
	/**this function will set the details of 
	the reservation , like the destitination ,etc. */
	public function Details($destination,$nb_person)
	{
		$this->destination->setNom($destination);
        $this->nb_person = $nb_person;
		$this->state = true;
		$this->list_person= null;
		$this->list_person=array();
		for($i=0 ; $i< $nb_person ;$i++)
		{
			$n_person= new Person();
			$this->list_person[]=$n_person;
		} 
		$this->state_nb_des = true;	
	}
	
	/**this function will set the details 
	of the passengers(name and age).*/
    public function AddPerson($nom ,$age,$index)
    {
	    $this->list_person[$index]->setNom($nom);
		$this->list_person[$index]->setAge($age);
		//$this->array_size++;
    }
	
	/**this function will calculate de total
	cost of the reseration.*/
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
	
	/**this function will return the number 
	of passenger*/
    public function getNbPerson()
    {
		return $this->nb_person;
    }
	
	/**this function will return the name 
	of the destination */
	public function getDestination()
	{
		return $this->destination->getNom();
	}
	
	/**this function will return the name 
	of the passenger at the index $i*/
	public function getPersonNom($i)
	{
		$nom = $this->list_person[$i];
		return $nom->getNom();
	}
	
	/**this function will return the age
	of the passenger at the index $i*/
	public function getPersonAge($i)
	{
		$age =$this->list_person[$i];
		return $age->getAge();
	}
	
	/**this function will return 
	the flag state*/
	public function getState()
	{
		return $this->state;
	}
	
	/**this function will set 
	the flag state*/
	public function setState($state)
	{
		 $this->state = $state;
	}
	
	/**this function will return 
	the flag state_nb_des*/
	public function getStateNbDes()
	{
		return $this->state_nb_des;
	}
	/**this function will set
	the flag state_nb_des*/
	public function setStateNbDes($state)
	{
		$this->state_nb_des = $state ;
	}
	
	/**this function will return 
	the tottal cost of the reservation*/
	public function getTotal()
	{
		return $this->total ;
	}
	
	/**this function will set 
	the insurance, "OUI"==OK "NON"== KO*/
	public function setAssurance($value)
	{
		$this->assurance = $value;
	}
	
	/**this function will return 
	the insurance state*/
	public function getAssurance()
	{
		return $this->assurance;
	}
	
	/**this function will return 
	the person identification number*/
	public function getPersonId()
	{
		return $this->person_id;
	}
	
	/**this function will set 
	the flag state_na*/
	public function setStateNA($state)
	{
		$this->state_na = $state;
	}
	
	/**this function will return 
	the flag state_na*/	
	public function getStateNA()
	{
		return $this->state_na;
	}
	
	/**this function will set 
	the flag error*/	
	public function setError($state)
	{
		$this->error = $state ;
	}
	
	/**this function will return 
	the flag error*/
	public function getError()
	{
		return $this->error;
	}
	/**this function will set 
	the page index*/
	public function setPage($page)
	{
		$this->page = $page ;
	}
	/**this function will return 
	the page index*/
	public function getpage()
	{
		return $this->page;
	}
	
}
?>