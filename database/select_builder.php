<?php

class Select_builder{
    
    private $query;
    private $sql;
 
    
    private $querykeys=["select","from","where","groupby","orderby","limit"];
    
    public function __construct(Db $query)
    {
        $this->query=$query;
    }
    
    
    
    public function result()
    {
        $this->buildQuery();
        
        return $this->sql;
        
    }
    
    
    public function buildQuery()
    {
        foreach($this->querykeys as $key)
        {
            
            if(isset($this->query->{$key}) || count($this->query->{$key})>0)
            {
                $this->{$key}();
            }
        }
    }
    
    
    public function select()
    {
     
        $this->sql=(isset($this->query->distinct))?"SELECT DISTINCT ":"SELECT ";
        
        $this->sql.=implode(", ",$this->query->select);
        
    }
    
    public function from()
    {
       $this->sql.=" FROM {$this->query->from} " ;
    }
    
    public function where()
    {
        $this->sql.= (new Where_builder($this->query))->result();
        
    }
    
    public function groupby()
    {
        $this->sql.=(count($this->query->groupby)>0)?" GROUP BY ".implode(",",$this->query->groupby)." ":"";
    }
    
    
    public function orderby()
    {
      
        $order="";
        foreach($this->query->orderby as $o => $v)
        {
            $order.=" , $v[0] $v[1]";
        }
      
        
       $this->sql.=(count($this->query->orderby)>0)?" ORDER BY ".preg_replace("/,/","",$order,1)." ":"";
    }
    
    public function limit()
    {
        $this->sql.=(isset($this->query->offset))?" LIMIT {$this->query->limit} , {$this->query->offset}":" LIMIT {$this->query->limit} ";
    }
    
    
   
}
