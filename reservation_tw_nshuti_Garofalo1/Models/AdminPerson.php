<?php
	/*
	* This is the AdminPerson model. It allows for the future 
	* future integration of a 'login.php' page by simply adding
	* a username and password fields.
	* 
	*/
class AdminPerson
{
	//Fields
	//Flag used to indicate that we are in 
	//administrator mode
    private $adminmode_ok;
	
	//Constructor
    function __construct()
    {
        $this->adminmode_ok = false;
    }
	//This method will return 
	//the position of flag 'adminmode_ok'
	public function getAdmin_mode()
	{
		return $this->adminmode_ok;
	}
	
	//This method will set the
	//position of the flag 'adminmode_ok'
	public function setAdmin_mode($state)
	{
		 $this->adminmode_ok = $state;
	}
}
?>