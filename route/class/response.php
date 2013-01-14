<?php

class Response{
    
    static $rest=[
        "GET"    => "show",       
        "DELETE" => "destroy",
        "PUT"    => "update"
    ];
    
   private  static $path="controller";
    
    public static function error()
    {
        echo "<br/> require error page ";
    }
    
    /**
     * 
     * @param array $route
     * @return mix
     */
    public static function result($route)
    {
        if(in_array($route['args']['request'],["CONTROLLER","REST"])){
            (new self)->{strtolower($route['args']['request'])}($route);
        }
        else 
        {
            
            
            if($route['args']['request']==Request::method())
            {
                if(is_string($route['args']['action']))
                {
                    
                     $class=explode(".",$route['args']['action'])[0];                   
                     $method=explode(".",$route['args']['action'])[1];
                   
                   if(($class=self::requireClass($class)) &&  method_exists($class, $method))
                   {                       
                       $args=(strpos($route['uri'],"(any)")!==false || strpos($route['uri'],"(num)")!==false )
                                                  ? array_slice(Uri::segments(), 1)
                                                  : array_slice(Uri::segments(), 2);                       
                       
                       return call_user_func_array(array($class,$method),$args );
                   }
                }
                elseif($route['args']['action'] instanceof Closure)
                {
                    $args=(strpos($route['uri'],"(any)")!==false || strpos($route['uri'],"(num)")!==false )
                                                  ? Uri::segments(2)
                                                  : "";
                    call_user_func($route['args']['action'], $args);
                }
            }
        }
    }
    
    
    public function controller($route=null)
    {
        var_dump($route);
        $class=(!empty($route['args']['action']))?$route['args']['action']:$route['uri'];
        if(($class=self::requireClass($class)))
        {
            $method=Uri::segments(2);
            if(method_exists($class, $method))
            {
               return call_user_func_array(array($class,$method),  array_slice(Uri::segments(), 2));
            }


        }        
        
        return self::error();        
        
    }
    
    public  function rest($route)
    {
        $controller=$route['args']['action'];
        if($controller!="" && ($class=self::requireClass($controller)))
        {
            $requestmethod=Request::method();
            if(($arg=Uri::segments(2))!=false)
            {
                
                if(array_key_exists($requestmethod, self::$rest) && method_exists($class, self::$rest[$requestmethod]))
                {
                    return call_user_func(array($class,self::$rest[$requestmethod]), $arg);
                }
                
              
                
            }
            else
            {
                if($requestmethod=="POST" && method_exists($class, "create"))
                {                    
                    return call_user_func(array($class,"create"));     
                    
                }
                elseif(method_exists($class, "index"))
                {                   
                    return call_user_func(array($class,"index"));   
                }    
            }
        }
        return self::error ();
        
        
        
    }
    
    public static function requireClass($class)
    {
        if(file_exists(self::$path.DIRECTORY_SEPARATOR.$class.".php"))
        {
                
                require self::$path.DIRECTORY_SEPARATOR.ucfirst($class).".php";
                $classname=ucfirst($class);
                return new $classname;
         }
         
         return false;
    }
    
    
}
