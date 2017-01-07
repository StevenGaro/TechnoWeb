<?php

//this class  contains the passenger's 
//name and age
class Person
{
	//Fields
    private  $fullname ;
    private  $age;

	//Constructor
    public function __construct()
    {	
		$this->fullname=null;
		$this->age=null;
       
    }
	
	//Methods
	
	//This method will return
	//the name of the passenger
	public function getName()
	{
		return $this->fullname;
	}
	
	//This method will return
	//the age of the passenger
	public function getAge()
	{
		return $this->age;
	}
	
	//this method will set
	//the name of the passenger
	public function setName ($value)
	{
		 $this->fullname = $value;
	}
	
	//this method will set
	//the age of the passenger
	public function setAge ($value)
	{
		 $this->age = $value;
	}
	 //
     // Combine the attributes in a single string.
     // @param none
     // @return the stringified attributes of the object
     //
    public function __toString()
    {
        return $this->fullname." - ".$this->age." ans";
    }

}
?>