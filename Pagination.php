<?php

class Pagination{
    
    private $currentPage;
    private $totalPage;
    private $perpage;
    
   
    public function __construct($total,$current=1,$perpage=10) 
    {
        $this->currentPage=(int)$current;
        $this->totalPage=(int)$total;
        $this->perpage=(int)$perpage;
    }
    
    public static function create($total,$current=1,$perpage=10)
    {
        return new self($total,$current,$perpage);
    }
    
    
    public function nextPage()
    {
        return $this->currentPage+1;
    }
    
    public function prevPage()
    {
        return $this->currentPage-1;
    }
    
    public function hasNext()
    {
        return ($this->currentPage<$this->totalPage())? true :false;
    }
    
    public function hasPrev()
    {
        return ($this->prevPage()>0)?true :false;
    }
    
    public function totalPage()
    {
        return ceil($this->totalPage/$this->perpage);
    }
    
    public function offset()
    {
        return ($this->currentPage-1)*$this->perpage;
    }
    
    
    public function setCurrentPage($current)
    {
        $this->currentPage=(int)$current;
    }
    
    
    public function getCurrent()
    {
        return $this->currentPage;
    }
    
    
    public function setPerPage($page)
    {
       $this->perpage=(int)$page;
    }
    
    public function getPerPage()
    {
        return $this->perpage;
    }
    
    public function setTotal($total)
    {
        $this->totalPage=(int)$total;
    }
    
    
    public function getTotal()
    {
        return $this->totalPage;
    }
    
    
    
    
    
    
}
