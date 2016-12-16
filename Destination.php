<?php
/*this class  contains the information 
of the chosen destination*/
class Destination
{	
	/*destistion's name*/
    private $nom;
    
	/*constructor*/
    public function __construct()
    {
       
    }
	/*function*/
	
	/**this function will return the destination's
	name*/
	public function getNom()
	{
		return $this->nom;
	}
	
	/**this function will set the destination's
	name*/
	public function setNom($nom)
	{
		$this->nom = $nom;
	}
}
?>