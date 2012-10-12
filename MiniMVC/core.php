<?php

/**
 *  Core.php
 *    
 *    Sköter allt med URL hantering, vilken funktion/controller ska laddas?
 *    Sparar även ner konstanter.
 *
 * @author Sony? aka Sawny, 4morefun.net
*/

//Konstanter som är bra att ha.
define('IS_AJAX',          isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define('MINIMVC_FOLDER',   'http://'. $_SERVER['HTTP_HOST'] . dirname(substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT'])))); //Funkar även om MiniMVC är på subdomäner eller är inkluderat.
define('VIEW_FOLDER',      'http://'. $_SERVER['HTTP_HOST'] . implode("/", array_slice(explode("/", dirname(substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT'])))),0, -1)) . '/view');
define('MINIMVC_FULLPATH', dirname(__FILE__)); //För script, tex /httpd.www/public_html/proj/x/MiniMVC/

require('autoload.php');

//Kör core!
new core();

class core
{
    /**
     * Kör rätt controller
     *
     * Definerar konstanter, kör routing, laddar rätt controller med rätt argument.
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
            echo '$_SERVER[\'QUERY_STRING\'] är inte satt, försöker ladda default controllern.. På rad '. __LINE__ .' i core.php.';
            $this->load->controller();
        }
    }
    
    /**
     * Routing
     *
     * Gör om korta URLer(genvägar) till den (ofta) långa riktiga URLen.
     *
     * @parm $urlPath QUERY_STRING(allt efter "index.php?") av URLen. Format = text/text/text/osv/
     * @return Den riktiga urlen
     */
    
    function route($urlPath) 
    {
        $match   = false;
        $urlPath = trim($urlPath, '/');
        
        //Kort kommandon i $route som ska ersättas.
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

            //Matchar $shortUrl med den sub URL användaren skrev in?
            if(preg_match('/^'. $shortUrl .'$/', $urlPath, $matches))
            {
                //Match, skicka data från (x) till $x
                foreach($matches as $key => $val)
                {
                    if($key !== 0)
                    {
                        //Byter ut $x mot rätt värde
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