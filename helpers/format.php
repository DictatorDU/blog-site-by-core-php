<?php
  class FormatClass{
    function dateFormat($date){
      return date('F j, Y, g:i a', strtotime($date));
    }
    function shortTxt($txt){
      $txt = substr($txt,0,450);
      $txt = substr($txt,0,strrpos($txt," "));
      $txt = $txt." .......";
      return $txt;
    }
    public function title(){
      $path = $_SERVER['SCRIPT_FILENAME'];
      $title = basename($path,".php");
      $title = str_replace("_"," ",$title);
      if($title == "index"){
        $title = "Home";
      }
      return ucwords($title);
    }
    
    function validation($data){
      $data = trim($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  }
?>
