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

    function adminPanelTxtShort($txt){
      $txt = substr($txt,0,70);
      $txt = substr($txt,0,strrpos($txt," "));
      $txt = $txt." ..";
      return $txt;
    }

    function adminMsgTxtShort($txt){
      $txt = substr($txt,0,38);
      $txt = substr($txt,0,strrpos($txt," "));
      $txt = $txt." ..";
      return $txt;
    }

    function validation($data){
      $data = trim($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  }
?>
