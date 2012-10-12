<?php
/**
 *  Autoload - inkluderar automatiskt klasser när dom skapas
 *
 *    Ner man skriver $x = new Bajs;
 *    Så inkluderar autoload automatiskt bajs.php från antingen MiniMVC/, controller/ eller model/.
 *
 *  @author Sony? aka Sawny, 4morefun.net
 * @parms $class Klassen som ska laddas in. Måste finnas i MiniMVC/, controller/ eller model/ mappen.
*/

function __autoload($class)
{
    $class = $class .'.php';
    $path  = MINIMVC_FULLPATH .'/';
    
    //Testar om det är en MiniMVC funktion, en controller eller en model
    switch(true)
    {
        case is_readable($path . $class):                   include($path . $class);                   break;
        case is_readable($path .'../controller/' . $class): include($path .'../controller/' . $class); break;
        case is_readable($path .'../model/' . $class):      include($path .'../model/' . $class);      break;
        //default:                                   echo "Hittar inte '$class'!";   break;
    }
}

?>