<?php



class Image{
    
    public $image;
    private $file;
    private $ImageX;
    private $ImageY;   
    private $Ext;
    private $Name;
    private $Size;
    private $NameExt;
    private $allowed=array('jpg','jpeg','gif','png');
    private $imageInfo=array();    
    private $set=array("ImageX","ImageY","Ext","Name","Size");
    
    
 
 public function __construct($file) {
     
     if(is_array($file)){
         $this->file=$file['tmp_name'];
         $this->NameExt=$file['name'];
     }else{
         $this->file=$this->NameExt=$file;
     }
   
     $this->createimage();
     $this->setData();
 }
 
 public static function open($image)
 {
     return new self($image);
 }
 
 
 
 public function setData()
 {
     foreach($this->set as $set)
     {         
         $this->imageInfo[$set]=$this->{"_set".$set}();
     }
     
     
 }
 

 
 public function _setImageX()
 {
     $size=$this->imageSize();
     return $this->ImageX=$size[0];
     
 }
 
 public function _setImageY()
 {
     $size=$this->imageSize();
     return $this->ImageY=$size[1];
    
 }
 public function _setExt()
 {
     
     $name       =  explode(".",basename($this->NameExt));
     $this->Ext =  strtolower(end($name)); 
     
     
    return $this->Ext;
     
 }
 
 private  function _setName()
 {
   
        $res        =  explode(".",basename($this->NameExt));
        $this->Name =  array_shift($res);             
        return $this->Name ;
     
 }
 
 private function _setSize()
 {
     $this->Size =  filesize($this->file);
     return $this->Size ;
 }
  
  
  public function imageSize()
  {
      return  getimagesize($this->file);
  }
  
  
 public function info()
 {
     return $this->imageInfo;
 }
 
  
 public function getName()
 {
     return $this->Name;
 }
 
 
 public function getExt()
 {
     return $this->Ext;
 }

 public function getImagex()
 {
     return $this->ImageX;
 }
 
 public function getImagey()
 {
     return $this->ImageY;
 }
 
 public function setAllowedType($type)
 {
     if(!is_array($type))return false;
      $this->allowed=$type;
 }
 
 public function isAllowed()
 {
     return in_array($this->Ext, $this->allowed);
 }
 
 public function createimage()
 {
        $src_image=getimagesize($this->file);
       
        switch ($src_image['mime'])
        {
            case 'image/jpeg';                                
                $this->image=imagecreatefromjpeg($this->file);                                
            break;
            case 'image/png';                               
                $this->image=imagecreatefrompng($this->file);
                imageAlphaBlending($this->file, false);
                imageSaveAlpha($this->file, true);                                
            break;
            case 'image/gif';                              
                $this->image=imagecreatefromgif($this->file);                               
            break;
        }             

        return (!empty($this->image))?$this->image:false;
        
 }
 
 
 public function save($dest=null)
{


    $src_image=getimagesize($this->file);


    switch ($src_image['mime'])
    {
        case 'image/jpeg';
            imagejpeg($this->image,$dest.$this->Name.".".$this->Ext,80);
        break;

        case 'image/png';
            imagepng($this->image,$dest.$this->Name.".".$this->Ext,8);
        break;

        case 'image/gif';
            imagegif($this->image,$dest.$this->Name.".".$this->Ext,80);
        break;
    }
}

/**
 *
 * @param int $thumb_width
 * @param int $thumb_height
 * @param int $picture_x
 * @param int $picture_y
 * @param int $picture_width
 * @param int $picture_height
 * @param string $dest
 * @return object 
 * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_");
 * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_")->blur()->save();
 */

 
 public function crop($thumb_width,$thumb_height,$picture_x,$picture_y,$picture_width,$picture_height,$dest=null)
 {
        $crop=imagecreatetruecolor($thumb_width, $thumb_height);        
        return $this->_resize($crop, 0, 0,$picture_x,$picture_y,$thumb_width,$thumb_height , $picture_width, $picture_height,$dest=null);
 }
 
 
 
 /**
  *
  * @param int $width
  * @param int $height
  * @param string $dest
  * @return object 
 * Image::open($_FILES['picture'])->resize(50,50,"thum_"); 
 * Image::open($_FILES['picture'])->resize(50,50,"thum_")->gray()->save()
 *  
 */

 public function resize($width,$height,$dest=null)
 {         
        list($width,$height)=$this->scale($width,$height);
        $thumb=imagecreatetruecolor($width,$height);       
        return $this->_resize($thumb,0,0,0,0,$width,$height,$this->getImagex(), $this->getImagey(),$dest);       
 }
 
 private function _resize($thumb,$x,$y,$picture_x,$picture_y,$thumb_width,$thumb_height , $picture_width, $picture_height,$dest=null)
 {
        $img=$this->createimage();
        imagecopyresampled($thumb, $img, $x, $y,$picture_x,$picture_y,$thumb_width,$thumb_height , $picture_width, $picture_height);                    
        $this->image=$thumb;
        $this->save($dest);        
       
        $this->destroy($thumb,$img);
        
        return new self($dest.$this->Name.".".$this->Ext);       
       
        
 }
 
 /**
  *Image::open($_FILES['picture'])->gray()->save();
  * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_")->gray()->save();
  * @return \Image 
  */
 
 public function gray()
 {
     imagefilter($this->image, IMG_FILTER_GRAYSCALE);
     return $this;
 }
 
 
 /**
  *Image::open($_FILES['picture'])->blur()->save();
  * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_")->blur()->save();
  * @return \Image 
  */
 public function blur()
 {
     imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
     return $this;
 }
 
 
 /**
  *Image::open($_FILES['picture'])->skecth()->save();
  * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_")->skecth()->save();
  * @return \Image 
  */
 
 public function sketch() 
{
    imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
    return $this;
                
}


/**
  *Image::open($_FILES['picture'])->invert()->save();
  * Image::open($_FILES['picture'])->crop(300,300,0,0,300,300,"crop_")->invert()->save();
  * @return \Image 
  */
 
 public function invert()
 {
        imagefilter($this->image, IMG_FILTER_NEGATE);
        return $this;
 }

 
 
 
 public function destroy($image1,$image2)
 {
      @imagedestroy($image1);
      @imagedestroy($image2);
 }
 
 /**
  *
  * @param int $width
  * @param int $height
  * @return array
  */
 
 public function scale($width,$height)
 {
    $thumb_ratio=$width/$height;      
    $ratio=$this->ImageX/$this->ImageY;


    if($thumb_ratio>$ratio)
    {
       $width=$height*$ratio;
    }
    else
    {
        $height=$width/$ratio;
    }
    
    return array($width,$height);
 }
 
 
    
}
