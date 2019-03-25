<?php

class ImageWater{
  //路径
  protected $path;
  //是否启用随机名字
  protected $isRandName;
  //要保存的图像类型
  protected $type;
   
  //通过构造方法队成员属性进行初始化
  function __construct($path='./',$isRandName=true,$type='png'){
    $this->path = $path;
    $this->isRandName = $isRandName;
    $this->type = $type;
  }
  //对外公开的水印方法
   
  /**
   * @param char $image  原图
   * @param char $water  水印图片
   * @param char $postion 位置
   * @param int $tmp   透明度
   * @param char $prefix 前缀
   */
  function water($image,$water,$postion,$tmp=100,$prefix='water_'){
    
    //判断这两个图片是否存在
    if(!file_exists($image)||!file_exists($water)){
      //die('图片资源不存在');
    }
    //得到原图和水印图片的宽高
    $imageInfo = self::getImageInfo($image);
    $waterInfo = self::getImageInfo($water);
    //判断水印图片是否能贴上来
    if (!$this->checkImage($imageInfo,$waterInfo)){
      die('水印图片太大');
    }
    //打开图片
    $imageRes = self::openAnyImage($image);
    $waterRes = self::openAnyImage($water);
    //根据水印图片的位置计算水印图片的坐标
    $pos = $this->getPosition($postion,$imageInfo,$waterInfo);
	
    //将水印图片贴过来
    imagecopymerge($imageRes, $waterRes, $pos['x'], $pos['y'], 0, 0, $waterInfo["width"], $waterInfo["height"], $tmp);
    //得到要保存图片的文件名
    $newName = $this->createNewName($image,$prefix);
    //得到保存图片的路径,也就是文件的全路径
    $newPath = dirname($image).'/'.$newName;//rtrim($this->path,'/').'/'.$newName;
    //保存图片
    $this->saveImage($imageRes,$newPath);
    //销毁资源
    imagedestroy($imageRes);
    imagedestroy($waterRes);
     
    //返回路径
    return $newPath;
  }
  //保存图像资源
  protected function saveImage($imageRes,$newPath){
    $func = 'image'.$this->type;
    //通过变量函数进行保存
    $func($imageRes,$newPath);
  }
  //得到文件名函数
  protected function createNewName($imagePath,$prefix){
    if ($this->isRandName){
      $name = $prefix.uniqid().'.'.$this->type;
    }else {
      $name = $prefix.pathinfo($imagePath)['filename'].'.'.$this->type;
    }
    return $name;
  }
  //根据位置计算水印图片的坐标
  protected function getPosition($postion,$imageInfo,$waterInfo){
    switch ($postion){
      case 1:
        $x = 0;
        $y = 0;
        break;
      case 2:
        $x = ($imageInfo['width']-$waterInfo["width"])/2;
        $y = 0;
        break;
      case 3:
        $x = $imageInfo["width"]- $waterInfo["width"];
        $y = 0;
        break;
      case 4:
        $x = 0;
        $y = ($imageInfo["height"]-$waterInfo["height"])/2;
        break;
      case 5:
        $x = ($imageInfo['width']-$waterInfo["width"])/2;
        $y = ($imageInfo["height"]-$waterInfo["height"])/2;
        break;
      case 6:
        $x = $imageInfo["width"]- $waterInfo["width"];
        $y = ($imageInfo["height"]-$waterInfo["height"])/2;
        break;
      case 7:
        $x = 0;
        $y = $imageInfo['height'] - $waterInfo["height"];
        break;
      case 8:
        $x = ($imageInfo['width']-$waterInfo["width"])/2;
        $y = $imageInfo['height'] - $waterInfo["height"];
        break;
      case 9:
        $x = $imageInfo["width"]- $waterInfo["width"] -30;
        $y = $imageInfo['height'] - $waterInfo["height"] - 30;
        break;
      case 0:
        $x = mt_rand(0, $imageInfo["width"]- $waterInfo["width"]);
        $y = mt_rand(0, $imageInfo['height'] - $waterInfo["height"]);
        break;
    }
    return ['x'=>$x , 'y'=>$y];
  }
  protected function checkImage($imageInfo,$waterInfo){
    if (($waterInfo['width'] > $imageInfo['width'])||($waterInfo['height'] > $imageInfo['height'])){
      return false;
    }
    return true;
  }
  //静态方法。根据图片的路径得到图片的信息，宽度，高度、mime类型
  static function getImageInfo($imagePath){
    $info = getimagesize($imagePath);
    $data['width']=$info[0];
    $data['height']=$info[1];
    $data['mime'] = $info['mime'];
    return $data;
  }
  static function openAnyImage($imagePath){
    //得到图像的mime类型
    $mime = self::getImageInfo($imagePath)['mime'];
    //根据不同的mime类型打开不同的图像
    switch ($mime){
      case 'image/png':
          $image = imagecreatefrompng($imagePath);
          break;
      case 'image/gif':
          $image = imagecreatefromgif($imagePath);
          break;
      case 'image/jpeg':
          $image = imagecreatefromjpeg($imagePath);
          break;
      case 'image/wbmp':
          $image = imagecreatefromwbmp($imagePath);
          break;
    }
    return $image;
  }
   
}




?>



 

