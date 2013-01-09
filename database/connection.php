<?php

class Connection{
    
    private  static $config=[
        "host"=>"localhost",
        "database"=>"learninglaravel",
        "username"=>"root",
        "password"=>"bkanat79"
    ];
    
    private static $pdo;
    
    
    
    public static function connect()
    {
        if(!isset(static::$pdo))
        {
            try{
                    extract(static::$config);
                    $dsn = "mysql:host={$host};dbname={$database}";

                    return static::$pdo=new pdo($dsn,$username,$password);
               }catch(PDOException $e){
                    echo $e->getMessage();
               }
        }
        
     
    }
    
    
   
    
    
    
    
    
    
}
