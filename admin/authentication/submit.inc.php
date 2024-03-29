<?php
/**
 * Submit
 *
 * @package Ambrogio\Admin\Authentication
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 // switch action
 switch(ACTION){
  // authentication
  case "login":authentication_login();break;
  case "logout":authentication_logout();break;
  // default
  default:
   api_alert("Submit function for action <em>".ACTION."</em> was not found in module <em>".MODULE."</em>..","danger");
   api_redirect("admin.php?mod=".MODULE);
 }

 /**
  * Authentication Login
  */
 function authentication_login(){
  api_dump($_REQUEST,"_REQUEST");
  // build and include configuration
  $configuration=new stdClass();
  include("config.inc.php");
  api_dump($configuration);
  // check authentication
  if(md5($_REQUEST['password'])===$configuration->authentication){
   // renew session
   session_destroy();
   api_session_start();
   // set authentication flag into session
   $_SESSION['ambrogio']['authenticated']=true;
   // debug session
   api_dump($_SESSION['ambrogio']);
   // alert and redirect
   api_alert("Authenticated succesfully","success");
   api_redirect("admin.php?mod=administration");
  }else{
   // alert and redirect
   api_alert("Invalid authentication code","danger");
   api_redirect("admin.php?mod=authentication");
  }
 }

 /**
  * Authentication Logout
  */
 function authentication_logout(){
  api_dump($_REQUEST,"_REQUEST");
  // renew session
  session_destroy();
  api_session_start();
  // set authentication flag into session
  $_SESSION['ambrogio']['authenticated']=false;
  // debug session
  api_dump($_SESSION['ambrogio']);
  // redirect
  api_redirect("admin.php?mod=authentication");
 }
