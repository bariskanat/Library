<?php

class Author{
    
    
    public function index()
    {               
        echo "get is requested ";
    }
    
    public function show($id=null)
    {
        echo " get is requested  ";
    }
    
    
    public function create()
    {
        echo "post requested";
    }
    
    
    public function destroy($id)
    {
        echo "delete is requested";
    }
    
  
    
    public function update($id)
    {
        echo "put is requested";
    }
}