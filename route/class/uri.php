<?php

class Uri{
    
    
    private static $uri;
    
    public static function parse()
    {
        if(isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
         {            
            if(strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])===0)
            {
                $uri= substr($_SERVER['REQUEST_URI'],strlen($_SERVER['SCRIPT_NAME']));    
            }
            elseif(strpos($_SERVER['REQUEST_URI'], dirname($_SERVER['SCRIPT_NAME']))===0)
            {
                $uri= substr($_SERVER['REQUEST_URI'],strlen(dirname($_SERVER['SCRIPT_NAME'])));
      
            }
        }
        else 
        {
            $uri="";
        }
        
        if(strpos($uri,"?"))
        {      
            $uri=explode("?",$uri)[0];      
        }
        
        $uri=trim($uri,"/");
        
        return static::$uri=$uri;
    }
    
    
    public static function segments($index=null)
    {
        $uri=self::parse();
        
        if($uri=="")return false;
        
        $uriarray=explode("/",$uri);
        
        if(is_null($index))
        {
            return $uriarray;
        }
        elseif($index > 0)
        {
            return isset($uriarray[$index-1])?$uriarray[$index-1]:false;
        }
        return false;
    }
}
