<?php

class Where_builder{
    
    private $query;
    private $where;
    
    public function __construct(Db $query)
    {
        $this->query=$query;
        
    }
    
    
    public function result()
    {
        foreach($this->query->where as $k =>$v)
        {
           $method="where_".strtolower($k);
           if(method_exists($this, $method))
           {
               call_user_func_array(array($this,$method),array($v));
           }
          //$this->where.=$k." ".$v[0]." ".$v[1]." ? ";
            
        }
        
        return (count($this->query->where)>0)?" WHERE ".preg_replace("/AND|OR/i","",$this->where,1):"";
        
    }
    
    
     
    public function where_and($where)
    {
       
        $this->where.=" AND ".$where[0]." ".$where[1]." ? ";
    }
    
    public function where_or($where)
    {
        $this->where.=" OR ".$where[0]." ".$where[1]." ? ";
    }
    
    public function where_in($where)
    {
        
        $values=$this->buildquestion($where[2]);
        
        $this->where.=" AND {$where[0]} IN ({$values})";
    }
    
    
    private function buildquestion($data)
    {
       return implode(",",array_map(function(){
            return " ?";
        },$data));
    }
    
    public function where_orin($where)
    {
        
        $values=$this->buildquestion($where[2]);
        
        $this->where.=" OR {$where[0]} IN ({$values})";
        
    }
    
    
    public function where_notin($where)
    {
        
        $values=$this->buildquestion($where[2]);
        
        $this->where.=" AND {$where[0]} NOT IN ({$values})";
    }
    
    public function where_ornotin($where)
    {
        
        $values=$this->buildquestion($where[2]);
        
        $this->where.=" OR {$where[0]} NOT IN ({$values})";
    }
}