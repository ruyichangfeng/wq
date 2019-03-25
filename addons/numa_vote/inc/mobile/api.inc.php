<?php 
global $_W,$_GPC;
$operation=empty($_GPC['op'])?'index':$_GPC['op'];
 if($operation=='upload'){//上传图片
	  if($_W['ispost']){
	  	      load()->func("file"); 
	  		 $myImage =   $_FILES['myImage']; 
       	      if(empty($myImage) || (isset($myImage['name']) && $myImage['name']=="")){
       	        		exit(json_encode(array("status"=>0,"message"=>"图片不能为空")));
       	       }else{
       	        		$myImage_file = file_upload($myImage,"image");
		       	        if(is_error($myImage_file)){
		       	        		  exit(json_encode(array("status"=>0,"message"=>$myImage_file['message'])));
		       	        }else{
		       	        	      exit(json_encode(array("status"=>1,"data"=>$myImage_file['path'],"message"=>$myImage_file['message'])));
		       	       }
       	        } 
	  }
}elseif($operation=='resize'){
			 //图片的等比缩放   
		     $file_url=trim($_GPC['url']); 
		     $max = empty($_GPC['width'])?300:intval($_GPC['width']);
		     if (strexists($file_url, 'http://') || strexists($file_url, 'https://') || substr($file_url, 0, 2) == '//') {
			      	$src =  $file_url;
			 }else{
					if (empty($_W['setting']['remote']['type']) || file_exists(IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/' . $file_url)) {
						$src = IA_ROOT . '/'  . $_W['config']['upload']['attachdir'] . '/' . $file_url;
					} else {
						$src = $_W['attachurl_remote'] . $file_url;
					}	
			 }   
			 $exten_name=pathinfo($src,PATHINFO_EXTENSION);//获取图片的扩展名
              if($exten_name!="png") { 
					$image = imagecreatefromjpeg($src); //png图片压缩函数   
			  } else { 
					$image = imagecreatefrompng($src); //jpg图片压缩函数  
			 } 
		     $size_src=getimagesize($src);
     		 $w=$size_src['0'];
   	 		 $h=$size_src['1'];  
		   //根据最大值为300，算出另一个边的长度，得到缩放后的图片宽度和高度
		     if($w > $h){
		        $w=$max;
		         $h=$h*($max/$size_src['0']);
		   }else{
		         $h=$max;
		         $w=$w*($max/$size_src['1']);
		     } 
  			 //声明一个$w宽，$h高的真彩图片资源
     		 $image2=imagecreatetruecolor($w, $h); 
		    //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
		     imagecopyresampled($image2, $image, 0, 0, 0, 0, $w, $h, $size_src['0'], $size_src['1']);
		     
   			//告诉浏览器以图片形式解析
     		header('content-type:image/png');
	        imagepng($image2);
	        imagedestroy($image);
	       //销毁资源
     		imagedestroy($image2);
		    exit;
}
?>