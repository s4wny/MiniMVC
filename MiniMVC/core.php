<?php

/**
 *  Core.php
 *    
 *    Sk�ter allt med URL hantering, vilken funktion/controller ska laddas?
 *    Sparar �ven ner konstanter.
 *
 * @author Sony? aka Sawny, 4morefun.net
*/

//Konstanter som �r bra att ha.
define('IS_AJAX',          isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define('MINIMVC_FOLDER',   'http://'. $_SERVER['HTTP_HOST'] . dirname(substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT'])))); //Funkar �ven om MiniMVC �r p� subdom�ner eller �r inkluderat.
define('VIEW_FOLDER',      'http://'. $_SERVER['HTTP_HOST'] . implode("/", array_slice(explode("/", dirname(substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT'])))),0, -1)) . '/view');
define('MINIMVC_FULLPATH', dirname(__FILE__)); //F�r script, tex /httpd.www/public_html/proj/x/MiniMVC/

require('autoload.php');

//K�r core!
new core();

class core
{
    /**
     * K�r r�tt controller
     *
     * Definerar konstanter, k�r routing, laddar r�tt controller med r�tt argument.
     */
    function __construct()
    {        
        $this->load = new load();
        $this->ini  = new settings();
        
        
        if(isset($_SERVER['QUERY_STRING']))
        {                        
            $urlPaths = $this->route($_SERVER['QUERY_STRING']);
                        
            $urlPaths = explode('/', $urlPaths);
            
            //Controllern ska laddas med...
            switch(count($urlPaths))
            {
                //Funktion
                case 1: $this->load->controller($urlPaths[0]);                       break;
                
                //Controller, funktion
                case 2: $this->load->controller($urlPaths[1], null, $urlPaths[0]);      break;
                
                //Controller, funktion, argument
                case 3: $this->load->controller($urlPaths[1], $urlPaths[2], $urlPaths[0]); break;
                
                //Controller, funktion, flera argument
                default:
                    foreach($urlPaths as $k => $v) {
                        if($k > 1) { $argu[] = $v; }
                    }
                    $this->load->controller($urlPaths[1], $argu, $urlPaths[0]);
                    break;
            }
        }
        else //Kanske laddar default funktion ist?
        {
            echo '$_SERVER[\'QUERY_STRING\'] �r inte satt, f�rs�ker ladda default controllern.. P� rad '. __LINE__ .' i core.php.';
            $this->load->controller();
        }
    }
    
    /**
     * Routing
     *
     * G�r om korta URLer(genv�gar) till den (ofta) l�nga riktiga URLen.
     *
     * @parm $urlPath QUERY_STRING(allt efter "index.php?") av URLen. Format = text/text/text/osv/
     * @return Den riktiga urlen
     */
    
    function route($urlPath) 
    {
        $match   = false;
        $urlPath = trim($urlPath, '/');
        
        //Kort kommandon i $route som ska ers�ttas.
        $replaceWith = array("/\//"     => "\\/",
                             "/:num:/"  => "[0-9]",
                             "/:afla:/" => "[a-z]");
        $replace = array_keys($replaceWith);
        $with    = array_values($replaceWith);
        
        //Loopa igenom alla routes
        foreach($this->ini->route as $shortUrl => $longUrl)
        {
            $shortUrl = trim($shortUrl, '/');
            
            //Byter ut kort kommandona
            $shortUrl = preg_replace($replace, $with, $shortUrl);

            //Matchar $shortUrl med den sub URL anv�ndaren skrev in?
            if(preg_match('/^'. $shortUrl .'$/', $urlPath, $matches))
            {
                //Match, skicka data fr�n (x) till $x
                foreach($matches as $key => $val)
                {
                    if($key !== 0)
                    {
                        //Byter ut $x mot r�tt v�rde
                        $longUrl = preg_replace('/\$'. $key .'/', $val, $longUrl);
                    }
                }
                
                $match = true;
                break; //Har hittat en match, sluta loopen
            }
        }
        
        //Hittade en match? Ny url!
        $realUrl = ($match) ? trim($longUrl, "/") : $urlPath;

        return $realUrl;
    }

}

?>