<?php

class mainModel
{
    function __construct()
	{
		$this->set = new settings();
		
		$host = $this->set->db['host'];
		$user = $this->set->db['user'];
		$pass = $this->set->db['pass'];
		$db   = $this->set->db['db'];
		
		//PDO
		if(strtolower($this->set->default['dbHandler']) == "pdo")
		{
		    try
			{      
                // MySQL with PDO_MYSQL  
                $DBH = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
			
			    return $DBH;
			}
			catch(PDOException $e)
			{
			    echo "PDO error <b>". $e->getMessage() . "</b><br>";
				echo "Du har dessa databaser installerade:<pre>";
			    print_r(PDO::getAvailableDrivers());  
				echo "</pre>";
			}
		}
		else //MySQL
		{
	        if(@!mysql_ping())
		    {
		        $DBLink = mysql_connect($host, $user, $pass) OR die("Fel MySQL uppgifter. Ändra dem i MiniMVC/settings.php");
			    mysql_select_db($db)                         OR die("Databasen finns inte, se till att du skrev rätt i MiniMVC/settings.php");
			
			    return $DBLink;
		    }
		}
	}
}


?>