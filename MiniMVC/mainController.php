<?php

/*
    mainController.php
	
	Laddar in funktionerna
	    * load.php
		* functions.php
	
	D� slipper man g�ra det i alla andra controllers.
	R�cker med extends mainController och parent::__construct();
	
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