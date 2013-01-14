<?php

class Router{ 
    
   public static $routes=[];
   
   private static $instance;
   
   
   
    
   public function __construct(){}
   
   
   public static function instance()
   {
       if(!isset(self::$instance))
       {
           self::$instance=(new self);
       }
       
       return self::$instance;
   }
   
   /**
    * 
    * @param array $route
    */
   public static function add($route)
   {
      
       self::$routes=array_merge(self::$routes,[$route]);
      
   }
   
   
  public static function  call()
  { 
     
      foreach(self::$routes as $k => $v)
      {
        
         $uri = (strpos($v['uri'], "/"))?explode("/", $v['uri'])[0]:$v['uri'];
         if($uri===Uri::segments(1))
         {
             Request::response($v);
         }
         
        
          
      }
      return false;
      
  }
    
}
