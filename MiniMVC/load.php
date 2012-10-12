<?php

/**
 * Load.php
 *
 * Funktioner för att ladda Views, Controllers och Models
 *
 * @author Sony? aka Sawny, 4morefun.net
 */

class load
{
    public $set;
    
    //Ger tillgång till alla settings variabler
    function __construct()
    {
        $this->set =  new settings();
    }
    
    /**
     * Laddar en view
     *
     * @parms $file fil som ska laddas. Utan .php
     * @parms (array) $values vajre key blir ett variable namn med innehållet från val.
     */
    function view($file, $values = null)
    {
        $path = MINIMVC_FULLPATH .'/../view/'. $file .'.php';
        
        if(file_exists($path))
        {
            if(is_array($values))
            {
                extract($values, EXTR_PREFIX_SAME, 'new_');
                unset($values);
            }
            
            include($path);
        }
        else
        {
            $this->view($this->set->default['404'], array('didntFindDisFile' => htmlspecialchars($file) .'.php'));
        }
    }
    
    /**
     * Laddar en controller
     *
     * @parms $func funktion som ska köras
     * @parms $values argument som ska skickas till funktionen
     * @parms $controller controllern som ska laddas, om den ej är satt laddas default controllern
     */
    function controller($func = null, $values = null, $controller = null)
    {
        //Default controller / controller via URL
        $controller = ($controller == null) ? $this->set->default['controller'] : $controller;
        //$controller = realpath($controller);
        
        //Finns controllern
        if(!is_readable(MINIMVC_FULLPATH .'/../controller/'. $controller .'.php')) {            
            $this->view($this->set->default['404'], array('didntFindDisClass' => htmlspecialchars($controller) .'.php'));
        }
        else //Finns! :)
        {
            $obj = new $controller();
            
            //Finns funktionen?
            if(!method_exists($obj, $func) AND $func != null) {
                $this->view($this->set->default['404'], array('function'   => htmlspecialchars($func),
                                                              'controller' => htmlspecialchars($controller)));
            }
            else //Yupp
            {
                //Ska en funktion köras? Med eller utan argument?
                switch(true)
                {
                    case !empty($func) &&  empty($values): 
                        $obj->$func();        break;
                    case !empty($func) && !empty($values):                              
                        $obj->$func($values); break;
                }
            }
        }
    }
    
    /**
     * Laddar en model
     *
     * @parms $model modelen som laddas. Bör ligga i model/ mappen. Utan .php tack.
     */
    function model($model)
    {
        $obj = new $model();
        
        $this->$model = $obj;
        
        return ($this->$model == false) ? false : $this->$model;    
    }
    
}

?>