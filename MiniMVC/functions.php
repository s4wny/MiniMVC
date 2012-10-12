<?php

/*
    Functions, inte n�dv�ndigt f�r resten av ramverket, du kan radera / l�gga till funktioner fritt.
*/

class functions
{
    function __construct()
    {
        
    }
    
    //Snyggare print_r
    function print_code($code, $comment = '')
    {
        echo '<b>'. $comment .'</b><pre style="border:1px solid red; padding: 10px; font-family: monospace; max-width: 90%; word-wrap: break-word; text-align: left;">';
        print_r($code);
        echo '</pre>';
    }
    
    //Anti SQLi / xss
    function clean($value, $xss = false)
    {
        if(is_array($value)) {
            foreach($value as $key => $val) {
                $value[$key] = $this->clean($val, $xss);
            }
            
            return $value;
        }
        else {
            //XSS eller SQLi skydd
            return ($xss != "SQLI" OR $xss == 'XSS' OR $xss == true) ? htmlspecialchars($value, ENT_QUOTES) : mysql_real_escape_string($value);
        }
    }
    
    //F�r debuging
    function debug($smal = true)
    {
        echo '<pre style="border:1px solid red; padding: 10px; font-family: monospace; max-width: 90%; word-wrap: break-word; text-align: left;">';
        
        if($smal === true) {
            debug_print_backtrace();
        }
        else {
            print_r(debug_backtrace());
        }
        
        echo '</pre>';
    }
    
    
    /**
     * Kollar om $args �r tomma, om N�GON �r tomm, return true. 
     *
     * @parms * (o�ndlligt)
     * @return true/false
     */
     
    function someone_empty()
    {
        $args = func_get_args();
        
        foreach($args as $val)
        {
            if(empty($val)) {
                return true;
            }
        }
        
        return false;
    }
    
}

?>