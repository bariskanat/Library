<?php

class Insert_builder{
    
    private $query;
    private $data=array();
   
    
    public function __construct(Db $query,$data)
    {
        $this->query=$query;
        $this->data=$data;
    }
    
    
    public function result()
    {
       return $this->buildquery();
    }
    
    
    public function buildquery()
    {
        $keys=implode(",",array_keys($this->data));
        $values=implode(",",array_map(function(){
            return "?";
        },array_values($this->data)));
        
        return "INSERT into {$this->query->from} ({$keys}) VALUES ({$values}) ";
        
    }
}
