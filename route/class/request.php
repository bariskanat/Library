<?php

class Request{
    
    private static $compennets=["GET","POST","PUT","DELETE","CONTROLLER","REST"];   
    
    
    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
    
    public static function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
    
    
    public static function response($route)
    {
      
        if(!in_array($route['args']['request'],self::$compennets)){
			Response::error();
		}else{
			Response::result($route);
		}
               
		
         
        
        
    }
    
    
   
    
    
    
    
}