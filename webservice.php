<?php
/**
 * Web Service
 *
 * @package Ambrogio
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 // php settings
 set_time_limit(0);
 ignore_user_abort(true);
 // load application
 require_once("loader.inc.php");
 // debug request
 api_dump($_REQUEST,"REQUEST");
 // check for actions
 if(!$_REQUEST['act']){die("ERROR EXECUTING WEB SERVICE: The action was not defined");}
 // build return class
 $RESPONSE=new stdClass();
 $RESPONSE->error=false;
 $RESPONSE->errors=array();
 $RESPONSE->result=array();
 // switch action
 switch($_REQUEST['act']){
  // message
  case "message":message($RESPONSE);break;
  // default
  default:
   // action not found
   $RESPONSE->error=true;
   $RESPONSE->errors[]=array("Action \"".$_REQUEST['act']."\" not found");
 }
 // check for debug
 if(DEBUG){
  // debug
  api_dump($RESPONSE,"RESPONSE");
  api_dump($BOT,"BOT");
  api_dump($APP,"Application");
  api_dump($DB,"Database");
 }else{
  // encode return
  header("Content-Type: application/json");
  echo json_encode($RESPONSE);
 }

 /**
  * Message
  */
 function message(&$RESPONSE){
  // check for token
  if(!$_REQUEST['token']){$RESPONSE->error=true;$RESPONSE->errors[]=array("Token is mandatory");return;}
  // check for message
  if(!$_REQUEST['message']){$RESPONSE->error=true;$RESPONSE->errors[]=array("Message is mandatory");return;}
  // get chat from token
  $chat_obj=new Chat($_REQUEST['token']);
  api_dump($chat_obj,"chat object");
  // check chat
  if(!$chat_obj->id){$RESPONSE->error=true;$RESPONSE->errors[]=array("Token not found");return;}
  if(!$chat_obj->telegram_id){$RESPONSE->error=true;$RESPONSE->errors[]=array("Chat not binded");return;}
  // send message
  if(!$GLOBALS['BOT']->sendMessage($chat_obj->telegram_id,$_REQUEST['message'])){
   $RESPONSE->error=true;$RESPONSE->errors[]=array("Error sending message");return;
  }
  // set result
  $RESPONSE->result=array("ok"=>true);
 }
