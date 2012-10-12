<?php

class exampleModel extends mainModel
{
    function __construct()
	{
	    //parent::__construct(); Detta är ett demo så använder ingen MySQL databas, annars behövs denna rad.
		//$this->tbl = $this->set->db['tbl']; //Om det varigt på riktigt. Sparar ner tabellerna du anget i settings.php i $this->tbl
	}
	
	function getProfile($name)
	{
	    //Så här skulle det påriktigt se ut
	    //$result = mysql_query("SELECT * FROM ". $this->tbl['profile'] ." WHERE name = '$name'") OR die(mysql_error());
		//return mysql_result($result, 0);
		
		//Fake som exempel
		$data = array('demo'  => array('id'   => 0,
		                               'name' => 'Demo',
		                               'info' => 'Hej jag är ett demo'),
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