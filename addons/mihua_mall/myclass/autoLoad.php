<?php 
//自动加载函数
function myClassLoader($class){
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = str_replace("myclass",'',$path);
    $file = __DIR__ . '/' . $path . '.php';
    if (file_exists($file)){
        require_once $file;
    }
} 
//注册自动函数
spl_autoload_register('myClassLoader');
//dao 
function D($class_name){
    $class_name  = 'myclass\\dao\\'.$class_name;
    $class       = new $class_name;
    return $class;
}
//ctl 
function C($class_name){
    $class_name  = 'myclass\\ctl\\'.$class_name;
    $class       = new $class_name;
    return $class;
}
//静态函数调用
//dao
function SD($class_name,$function,$params){
      $class_name  = 'myclass\\dao'.$class_name;
      $result      = call_user_func_array(array($class_name,$function),$params);
      return  $result;
}
//ctl
function SC($class_name,$function,$params){
      $class_name  = 'myclass\\ctl'.$class_name;
      $result      = call_user_func_array(array($class_name,$function),$params);
      return  $result;
}