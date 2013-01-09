<?php
class Update_builder{
    
    private $query;
    
    public function __construct(Db $query)
    {
        $this->query=$query;
    }
    
    
    public function result()
    {
        return $this->buildquery();
    }
    
    private function buildquery()
    {
        $where=(new Where_builder($this->query))->result();
        return  "UPDATE {$this->query->from} SET ".implode(" = ? , ",$this->query->updates)." = ? ".$where;
        
    }
    
}
