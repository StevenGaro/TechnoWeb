<?php

/*this class  contains the passenger 
 name and age*/
class Person
{
	/*passenger's name*/
    private  $nom ;
	/*passenger's age*/
    private  $age;

	/*constructor*/
    public function __construct()
    {	
		$this->nom=null;
		$this->age=null;
       
    }
	/*functio,*/
	
	/**this function will return
	the name of the passenger*/
	public function getNom()
	{
		return $this->nom;
	}
	
	/**this function will return
	the age of the passenger*/
	public function getAge()
	{
		return $this->age;
	}
	
	/**this function will set
	the name of the passenger*/
	public function setNom ($value)
	{
		 $this->nom = $value;
	}
	
	/**this function will set
	the age of the passenger*/
	public function setAge ($value)
	{
		 $this->age = $value;
	}

}
?>