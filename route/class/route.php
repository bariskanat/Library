<?php

class Route{
    
    
     public static $rest;
     private $instance;
  
    
    public function __construct(){}
    
    public static function getinstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance=new self;
        }
        
        return self::$instance;
    }
    
    /**
     * 
     * @param array $route
     */
    public static function addroute($route)
    {
        Router::add($route);
        
    }
    
    /**
     * 
     * @param string $uri
     * @param mix $action
     */
    public static function get($uri="/",$action=null)
    {
        $route=["uri"=>$uri,"args"=>  ["request"=>"GET","action"=>$action]];
         Router::add($route);
        
        
    }
    
    public static function post($uri="/",$action=null)
    { 
        $route=["uri"=>$uri,"args"=>  ["request"=>"POST","action"=>$action]];
         Router::add($route);
    }
    
    public static function put($uri="/",$action=null)
    {
        $route=["uri"=>$uri,"args"=>  ["request"=>"PUT","action"=>$action]];
         Router::add($route);
    }
    
    public static function delete($uri="/",$action=null)
    {
        $route=["uri"=>$uri,"args"=>  ["request"=>"DELETE","action"=>$action]];
         Router::add($route);
    }
    
    public static function controller($uri="/",$action=null)
    {
        $route=["uri"=>$uri,"args"=>  ["request"=>"CONTROLLER","action"=>$action]];
         Router::add($route);
    }
    
    public static function rest($uri="/",$action=null)
    {
        $route=["uri"=>$uri,"args"=>  ["request"=>"REST","action"=>$action]];
         Router::add($route);
    }
    
    public static function call()
    {
        Router::call();
    }    
    
    
}
