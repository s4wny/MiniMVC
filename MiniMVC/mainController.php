<?php

/*
    mainController.php
	
	Laddar in funktionerna
	    * load.php
		* functions.php
	
	Då slipper man göra det i alla andra controllers.
	Räcker med extends mainController och parent::__construct();
	
*/

class mainController
{
    function __construct()
	{
		$this->load  = new load;
		@$this->func = new functions;
	}
}

?>