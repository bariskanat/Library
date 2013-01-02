<?php

class Registry{
    
    private static $instance;
    private $objects = array();
    
    
    private function __construct(){}
    
    private function __clone(){}
    
    
    
    public static function instance()
    {
        if(!isset(self::$instance))
        {
           self::$instance=new self();
        }
        
        return self::$instance;
    }
    
    /**
     *
     * @param string $key
     * @param object $value 
     */
    private function set($key,$value)
    {
        $this->objects[$key] = $value;
    }
    
    
    /**
     *
     * @param string $key
     * @return mix 
     */
    
    private function get($key)
    {        
        return (isset($this->objects[$key]))?$this->objects[$key]:false;
        
    }
    
    
    /**
     *
     * @param string $key
     * @param object $val 
     */
    public static function setobject($key,$val)
    {
        self::instance()->set($key,$val);
    }
    
    /**
     *
     * @param string $key
     * @return mix 
     */
    public static function getobject($key)
    {
        return self::instance()->get($key);
    }  
    
    /**
     *
     * @param string $key
     * @return boolean 
     */
    public static function has($key)
    {
        return (array_key_exists($key, self::instance()->objects));
    }
    
    /**
     *
     * @param string $key 
     */
    
    public static function forget($key)
    {
        if(self::has($key))
           unset(self::instance ()->objects[$key]);
    }
    
    
    /**
     *
     * @param string $class
     * @param string $path
     * @param string $ext
     * @return boolean 
     */
    
    public static function requireClass($class,$path="lib",$ext=".php")
    {
        if(file_exists($path.$class.$ext))
        {
            require_once $path.$class.$ext;
            return true;
            
        }
        
        return false;
            
    }
    
  
}