<?php

class Connection{
    
    private  static $config=[
        "host"=>"localhost",
        "database"=>"database",
        "username"=>"yourusername",
        "password"=>"yourpassword"
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
