<?php

class exampleModel extends mainModel
{
    function __construct()
	{
	    //parent::__construct(); Detta �r ett demo s� anv�nder ingen MySQL databas, annars beh�vs denna rad.
		//$this->tbl = $this->set->db['tbl']; //Om det varigt p� riktigt. Sparar ner tabellerna du anget i settings.php i $this->tbl
	}
	
	function getProfile($name)
	{
	    //S� h�r skulle det p�riktigt se ut
	    //$result = mysql_query("SELECT * FROM ". $this->tbl['profile'] ." WHERE name = '$name'") OR die(mysql_error());
		//return mysql_result($result, 0);
		
		//Fake som exempel
		$data = array('demo'  => array('id'   => 0,
		                               'name' => 'Demo',
		                               'info' => 'Hej jag �r ett demo'),
		              'sony?' => array('id'   => 1,
		                               'name' => 'Sony?',
					                   'info' => 'Jag har gjort detta script :)'));
		
		if(isset($data[$name])) {
		    return $data[$name];
		}
		else {
		    return array('error' => 'Hittade ingen '. $name);
		}
	}
	
}

?>