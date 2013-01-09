<?php

class Db{
    
    private $connection;
    private $sth;
    public  $from;
    public  $distinct;
    public  $where=array();
    public  $bindings=array();
    public  $select;
    public  $groupby=array();
    public  $limit;
    public  $offset;
    public  $updates=array();
    public  $id;
    private $sql;
    public  $orderby=array();
    
    
    public function __construct()
    {
        if(!isset($this->connection))
        {
             
             $this->connection =  Connection::connect();
        }
        
        
       
    }
    
    /**
     * 
     * @param string $table
     * @return \db object
     */
    public static function open($table)
    {
        return (new self)->from($table);
    }  
    
    /**
     * 
     * @return \Db
     */
    public function distinct()
    {
        $this->distinct=true;
        return $this;
    }
    
    /**
     * 
     * @param string $table
     * @return \Db
     */
    
    public function from($table)
    {
        $this->from=$table;
        return $this;
    }
    
    
    /**
     * 
     * @param string $key
     * @param string $operator
     * @param mix $value
     * @return type
     */
    public function where($key,$operator,$value)
    {      
        
        $this->bindings[]=$value;
        
       
        return $this->build_where($key, $operator,"AND");
    }
    
    /**
     * 
     * @param string $key
     * @param string $operator
     * @param mix $value
     * @return type
     */
    
    
    public function or_where($key,$operator,$value)
    {
        $this->bindings[]=$value;
       
        return $this->build_where($key, $operator,"OR");
    }
    
    /**
     * 
     * @param string $key
     * @param array $data
     * @param string $operator
     * @param tstring $type
     * @return type
     */
    
    public function build_where_in($key,$data,$operator="AND",$type="in")
    {
        foreach($data as $d)       
        {
            $this->bindings[]=$d;
        }
        
        return $this->build_where($key, $operator, $type, $data);
    }
    
    /**
     * 
     * @param string $key
     * @param string $operator
     * @param string $type
     * @param array $data
     * @return \Db
     */
    
    public function build_where($key,$operator,$type,$data=null)
    {
        
        $this->where=array_merge($this->where,[$type=>[$key,$operator,$data]]);    
        return $this;
    }
    
    /**
     * 
     * @param string $field
     * @param array $data
     * @return type
     */
    
    public function where_in($field,$data)
    {
       return $this->build_where_in($field,$data);
        
    }
    
    /**
     * 
     * @param string $field
     * @param array $data
     * @return type
     */
    
    public function or_where_in($field,$data)
    {
        return $this->build_where_in($field,$data,"OR","orin");
    }
    
    /**
     * 
     * @param string $field
     * @param array $data
     * @return type
     */
    
    public function where_notin($field,$data)
    {
        return $this->build_where_in($field,$data,"AND","notin");
    }
    /**
     * 
     * @param string $field
     * @param array $data
     * @return type
     */
    public function or_where_notin($field,$data)
    {
        return $this->build_where_in($field,$data,"OR","ornotin");
    }
    
    
    /**
     * 
     * @param string $query
     * @param array $bindings
     * @param boolean $json
     * @return sql result
     */
    public static function query($query,$bindings=array(),$json=false)
    {
        
       return (new self)->fetch($query,$bindings,$json);
    }
    
    /**
     * 
     * @param string $query
     * @param array $bindings
     * @param boolean $json
     * @return mix
     */
    public static function first($query,$bindings=array(),$json=false)
    {
        if(!is_array($bindings))
        {
            $result=self::query($query,array());
            $json=true;
        }
        else
        {
            $result=self::query($query,$bindings);
        }
        
        
        if(count($result)>0){
            return ($json)?json_encode($result[0]):$result[0];
        }
        return false;
        
    }
    
    /**
     * 
     * @param string $query
     * @param array $bindings
     * @param boolean $json
     * @return sql result
     */
    
    public function fetch($query,$bindings,$json=false)
    {
         $this->sql=trim($query);
       
         $this->sth=$this->connection->prepare($this->sql);
         
         (count($bindings)>0)?$this->sth->execute($bindings):$this->sth->execute();
    
        
         if(stripos($this->sql,"select")!==0)
         {
             
             return $this->sth->rowCount();
         }
       
         
        return ($json) ?  json_encode($this->sth->fetchAll()):$this->sth->fetchAll();
    }
    
    
    /**
     * 
     * @param mix $id
     * @param array $data
     */
    public  function update($id,$data=array())
    {
        if(is_array($id))
        {
            
            $this->updates  =  array_keys($id);
            $this->bindings =  array_merge(array_values($id),$this->bindings);
        }
        else
        {    
            
            $this->updates  =array_keys($data);
            $this->bindings =array_merge($this->bindings,array_values($data));
            $this->where("id","=", $id);
        }
        $this->sql= (new Update_builder($this))->result();
        
        return $this->fetch($this->sql, $this->bindings);
        
    }
    
    /**
     * 
     * @param integer $key
     * @param mix $operator
     * @param mi $value
     * @return sql result
     */
    public function delete($key=null,$operator="=",$value=null)
    {
        if(!is_null($key))
            (is_null($value))?$this->where("id", $operator, $key):$this->where($key, $operator, $value);
        
        $this->sql=  (new Delete_builder($this))->result();
        
        return $this->fetch($this->sql, $this->bindings);
        
    }
    
    
    /**
     * 
     * @param array $data
     * @return sqq result
     */
    public  function insert($data)
    {
    
        var_dump($this->bindings);
        var_dump($data);
       $this->bindings=  array_merge($this->bindings,array_values($data));
       
       $this->sql=  (new Insert_builder($this,$data))->result();
       
       return $this->fetch($this->sql, $this->bindings);
    }
    
    
    /**
     * 
     * @param boolean $json
     * @return sql result
     */
    public function get($json=false)
    {
        if(!isset($this->select))$this->select=["*"];
        $this->sql =  (new Select_builder($this))->result();
       
        return $this->fetch($this->sql, $this->bindings,$json);
        
    }  
    
    /**
     * 
     * @param string $select
     * @return \Db
     */
    public function select($select="*")
    {
        $this->select=explode(",",$select);
        return $this;
        
    }
    
    /**
     * 
     * @param string $name
     * @param string $type
     * @return \Db
     */
    public function order_by($name,$type="ASC")
    {
        $this->orderby[]=[$name,$type];
        return $this;
    }
    
    
    /**
     * 
     * @param string $data
     * @return \Db
     */
    public function group_by($data)
    {
        $this->groupby[]=$data;
        return $this;
    }
    
    /**
     * 
     * @param int $limit
     * @param int $offset
     * @return \Db
     */
    
    public function limit($limit,$offset=null)
    {
        $this->limit=(int)$limit;
        if(!is_null($offset))$this->offset=(int)$offset;
        return $this;
    } 

    
    //TODO JOINS
}
