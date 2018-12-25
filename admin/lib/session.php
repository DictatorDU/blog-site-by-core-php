<?php
class session{
 public static function init(){
   if(version_compare(phpversion(),'5.0.4','<')){
     if(session_id() == ""){
       session_start();
     }
   }else{
     if(session_status() == PHP_SESSION_NONE){
       session_start();
     }
   }
  }
   public static function set($key,$value){
     $_SESSION[$key] = $value;
   }

   public static function get($key){
     if(isset($_SESSION[$key])){
       return $_SESSION[$key];
     }else{
       return false;
     }
   }
   public static function chkSession(){
     self::init();
     if(self::get("login") == false){
       self::sessionDestroy();
     }
   }
   public static function chkSessionStared(){
     self::init();
     if(self::get("login") == true){
       header("location:index.php");;
     }
   }

   public static function sessionDestroy(){
     session_destroy();
     session_unset();
     header("location:login.php");
   }
 }
?>
