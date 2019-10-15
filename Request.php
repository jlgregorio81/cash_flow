<?php
use core\util\Session;
use core\Application;
/**
 * Classe que concentra todas as requisições - PageController
 */
class Request
{
    /**
     * Trata uma requisição de um cliente. 
     */
    static function getRequest()
    {
        //..if exists something in the server variable _GET, then...
        if ($_GET) {            
            //..get the class name (if exists)
            $class = isset($_GET['class']) ? $_GET['class'] : null;
            //..get the method (if exists)
            $method = isset($_GET['method']) ? $_GET['method'] : null;
                if ($class) {
                    $class = "app\\controller\\" . $class; //..acerta o caminho da classe.
                //..instantiates a new object derived from the $class
                    $object = new $class;
                    //..if the $method exists in the $object, then...
                    if (method_exists($object, $method)) {
                        //..invokes the method
                        call_user_func(array($object, $method));
                    }
                } else if (function_exists($method)) {
                    call_user_func($method, $_GET);
                }
            }

        }
    }


//..includes the autoload.php
require_once 'autoload.php';
//..process the request
Request::getRequest();




