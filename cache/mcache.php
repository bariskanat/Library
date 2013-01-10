<?php
 if (!in_array('memcache', get_loaded_extensions()))
 {
        die('Memcache extension needs to be installed.');
 }


class Mcache{
    
   
    private static $memcache;
    private static $servers=[["127.0.0.1",11211]];
 
    
    public function __construct()
    {
        if(!isset(self::$memcache))
        {
            self::$memcache=(new Memcache);
            $this->connect();
        }
        
     
      
    }
    
    
    public function connect()
    {
        foreach(self::$servers as $server)
        {
            self::$memcache->addServer($server[0],$server[1]);
        }
       
    }
    
    
    public static function init($server=array())
    {
        if(count($server)>0)self::setserver($server);
        return (new self);
    }
    
    public static function setserver($server)
    {
        self::$servers=array_merge(self::$servers,$server);
    }
    
    public function delete($key)
    {
        return self::$memcache->delete($key);
    }
    
    public function add($key,$data,$flag=false,$time=60)
    {
        return self::$memcache->set($key,$data,$flag,$time);
    }
    
    
    public function get($key)
    {
        return self::$memcache->get($key);
    }  
    
    public function getstatus()
    {
        return self::$memcache->getStats();
    }
    
    public function emptycache()
    {
        self::$memcache->flush();
        
    }
    
}


