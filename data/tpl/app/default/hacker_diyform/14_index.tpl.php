<?php defined('IN_IA') or exit('Access Denied');?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script src="../addons/hacker_diyform/template/mobile/image/address.js"></script>
</head>

<style>




	.help-block img{display:inline-block;max-width:100%;height:auto;padding:4px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}
</style>
<body style="background:#fbf9fe">





<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width:100%">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php  if(is_array($nav)) { foreach($nav as $key => $values) { ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php  echo $key;?>" <?php  if($key==0) { ?>class="active<?php  } ?>"></li>
 	<?php  } } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" style="width:100%">
  
  <?php  if(is_array($nav)) { foreach($nav as $key => $values) { ?>
	<div class="item <?php  if($key==0) { ?>active<?php  } ?>">
      <a  href="<?php  echo $values['src'];?>"><img src="<?php  echo tomedia($values['image'])?>"  style="width:100%" alt="..."></a>
      <div class="carousel-caption">
        
      </div>
    </div>
  <?php  } } ?>
   
  </div>
<?php  if(count($nav)>1) { ?>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
 <?php  } ?> 
  
</div>



<?php  if($reply['title']) { ?>
<div class="panel panel-default" style="margin-top:10px">
  <div class="panel-body">
   <?php  echo $reply['title'];?>
  </div>
</div>
<?php  } ?>
<div class="panel panel-default">
  <div class="panel-body">
   请填写您的信息
 

 		<form style="margin-top:10px" action="" method="post" id="form">
         <?php  if(is_array($list)) { foreach($list as $key => $values) { ?>
          <div class="form-group">
            <div style="width:100%; overflow:hidden"><?php  echo $values['name'];?></div>
            <?php  if($values['type']==3) { ?>
            <input type="text" class="form-control" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>">
            <?php  } else if($values['type']==4) { ?>
            <textarea class="form-control" rows="3" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>"></textarea>
            <?php  } else if($values['type']==5) { ?>
            <?php  echo tpl_form_field_image('type'.$key);?>
    
    
    <?php  } else if($values['type']==6) { ?>
           <input type="tel" class="form-control" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>">


       
<?php  } else if($values['type']==7) { ?>
           <input type="email" class="form-control" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>">
           
  <?php  } else if($values['type']==8) { ?>
           <input type="date" class="form-control" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>">
         
   
  <?php  } else if($values['type']==9) { ?>
<br />
<select  name="type<?php  echo $key;?>1" class="form-control" style="width:30%; float:left; margin-right:3%"></select>
<select name="type<?php  echo $key;?>2" class="form-control" style="width:30%; float:left;margin-right:3%"></select>
<select  name="type<?php  echo $key;?>3" class="form-control" style="width:30%; float:left"></select>

<br /><br />


  <?php  } else if($values['type']==10) { ?>
           <input type="tel" class="form-control" id="type<?php  echo $key;?>" placeholder="<?php  echo $values['name'];?>" name="type<?php  echo $key;?>">
           
             
            
           <?php  } else if($values['type']==2) { ?>   
<select class="form-control" name="type<?php  echo $key;?>" id="type<?php  echo $key;?>">
<?php  if(is_array($o[$values['id']])) { foreach($o[$values['id']] as $keys => $valuess) { ?>
  <option value="<?php  echo $valuess['name'];?>"><?php  echo $valuess['name'];?></option>
 <?php  } } ?>  
</select>


       <?php  } else if($values['type']==0) { ?>   
<br />
  <div class="radio">
  
 <div class="row">
<?php  if(is_array($o[$values['id']])) { foreach($o[$values['id']] as $keys => $valuess) { ?>

		<div  style="float:left; width:48%; margin-right:2%; padding-left:15px">
  <label>
            <input type="radio" name="type<?php  echo $key;?>" id="type<?php  echo $key;?>" value="<?php  echo $valuess['name'];?>"  style="float:left">
            <?php  echo $valuess['name'];?>
            <br />
            <?php  if($valuess['image']) { ?>
             <div><img src="<?php  echo tomedia($valuess['image'])?>"   style="width:100%"/></div>
             <?php  } ?>
          </label>
       </div>



        
 

 <?php  } } ?>  
</div>

</div>

    <?php  } else if($values['type']==1) { ?>   
 <div class="checkbox">
  <div class="row">
 
<?php  if(is_array($o[$values['id']])) { foreach($o[$values['id']] as $keys => $valuess) { ?>
<div  style="float:left; width:48%; margin-right:2%;padding-left:15px">
  <label>
    <input type="checkbox" value="<?php  echo $valuess['name'];?>" name="type<?php  echo $key;?>[]" id="type<?php  echo $key;?>" <?php  if($keys==0) { ?>checked<?php  } ?>>
    <?php  echo $valuess['name'];?>
    <?php  if($valuess['image']) { ?>
    <img src="<?php  echo tomedia($valuess['image'])?>"  style="width:100%"/>
    <?php  } ?>
  </label>
</div>
 <?php  } } ?> 
</div>
</div>


            <?php  } ?>
          </div>
           <?php  } } ?>
           
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
           <input type="submit" class="btn btn-success" value="提交" style="width:100%" name="submit">
 </form>
  

  </div>
</div>


<?php  if($reply['description']) { ?>
<div class="panel panel-default" >
  <div class="panel-body">
   <?php  echo $reply['description'];?>
  </div>
</div>
<?php  } ?>

<script>
     
window.onload=function(){
	 <?php  if(is_array($list)) { foreach($list as $key => $values) { ?>
	  <?php  if($values['type']==9) { ?>
	new PCAS("type<?php  echo $key;?>1","type<?php  echo $key;?>2","type<?php  echo $key;?>3");
	<?php  } ?>
	<?php  } } ?>
	}

</script> 
   
   
	<script>
	$('#form').submit(function(){
		<?php  if(is_array($list)) { foreach($list as $key => $values) { ?>
			
		type<?php  echo $key;?>=$('input[name="type<?php  echo $key;?>"]').val();
		
	  
	<?php  if($values['ischeck']==1 ) { ?>	
	

	
	
		if(type<?php  echo $key;?>==''){
		
			alert("<?php  echo $values['name'];?>不能为空");
			return false;
		}
			
	 <?php  } ?>
	 
	 
	 <?php  if($values['type']==10 ) { ?>	
	

	
	
		if($('input[name="type<?php  echo $key;?>"]').val().length!=11){
		
			alert("<?php  echo $values['name'];?>格式不正确");
			return false;
		}
			
	 <?php  } ?>
	 
	 
	 
	<?php  } } ?>
	
		})
		
    	
    </script>
    
   

<div style="display:none"><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?></div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=hacker_diyform"></script></body>
</html>
