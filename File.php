<?php

class File{
    
    private $file;
    
    public function __construct($file)
    {
        $this->file=$file;
    }
    
    public static function open($file)
    {
        return new self($file);
    }
    
    
    public function exists()
    {
        return file_exists($this->file);
    }
    
    
    public function delete()
    {
        if($this->exists($this->file))
            @unlink($this->file);
    }
    
    
    public function read()
    {
        if($this->exists($this->file))
            return file_get_contents ($this->file);
        return false;
    }
    
    public function write($data)
    {
         return  file_put_contents($this->file, $data,LOCK_EX);
    }
    
    
    public  function append($data)
    {
        return file_put_contents($this->file, $data."\n",FILE_APPEND|LOCK_EX);
    }
    
    public  function readable()
    {
        return is_readable($this->file);
    }   
   
    
    public function writable()
    {
        return is_writable($this->file);
    }
    
    
    public function lastupdate()
    {
        if(static::exists($this->file))
            return filemtime ($this->file);
    }
    
    public function allowed($content=array())
    {
        if(!is_array($content))return false;
        return(in_array($this->extention($this->file), $content));
    }
    
    
     public  function copy($dest)
    {
        if($this->exists($this->file))
            return copy($this->file, $dest);
    }
    
    public  function move($location)
    {
        if($this->exists($this->file))
            return rename($this->file,$location);
    }
    
    public function info()
    {
        if($this->exists($this->file))
            return pathinfo($this->file);
    }
    
    
    public function extention()
    {
         return pathinfo($this->file,PATHINFO_EXTENSION);
    }
    
    public  function name()
    {
        return pathinfo($this->file,PATHINFO_FILENAME);
    }
    
    public  function size()
    {
        return ($this->exists($this->file))?filesize($this->file):false;
    }
    
    
    public  function type()
    {
       return ($this->exists($this->file))?filetype($this->file):false;
    }
    
    
    public  function emptyfile()
    {
        if($this->exists($this->file))
        {
            $f=fopen($this->file,"w");
            fclose($f);
        }
    }
    
    
    
}