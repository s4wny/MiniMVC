<?php

class settings
{
    public $db;
    public $default;
    public $route;
    
    function __construct()
    {
        //Databas inställningar
        //-------------------------------
        $this->db['host']      = 'localhost';
        $this->db['user']      = '';
        $this->db['pass']      = '';
        $this->db['db']        = '';
        
        //Salt för lösenord etc
        $this->db['salt1'] = "";
        $this->db['salt2'] = "";
        
        //Prefix på tabellerna
        $this->db['tbl']['prefix'] = "";
        
        $prefix = $this->db['tbl']['prefix'];
        
        //Tabeller
        $this->db['tbl']['profile']  = $prefix ."profiles";
    
        
        
        //Default värden
        //-------------------------------
        $this->default['controller'] = "exampleController";
        $this->default['404']        = "404"; //404 sidan
        $this->default['dbHandler']  = "mysql"; //MySQL eller PDO
        $this->default['dbType']     = "mysql"; //MySQL eller MS SQL (går bara att välja om PDO är vald ovan.
        
        
        //Route
        //-------------------------------
        $route["hello/([a-zA-Z0-9?]+)"]    = "exampleController/hello/$1/";
        $route["profile/([a-zA-Z0-9?]+)"]  = "exampleController/profile/$1";
        $route["pro"]                      = "exampleController/hello/pro";
        
        $this->route = $route;
        
        unset($prefix);
        unset($route);
        
        
        //Returnerar värderna
        return array($this->db, $this->default, $this->route);    
    }
}

?>