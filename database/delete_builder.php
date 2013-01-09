<?php

class Delete_builder{
    
    private $query;
    
    public function __construct(Db $query)
    {
       $this->query=$query; 
    }
    
    
    public function result()
    {
        return "DELETE FROM {$this->query->from} ".$this->where();
    }
    
    private function where()
    {
        return (new Where_builder($this->query))->result();
    }
}