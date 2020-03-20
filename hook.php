<?php
/**
 * Hook
 *
 * @package Ambrogio
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 // load application
 require_once("loader.inc.php");
 // get and decode content
 $content_raw=file_get_contents("php://input");
 $content=json_decode($content_raw,true);
 api_dump($content,"content");
 //file_put_contents("tmp/hook.log",json_encode($content,JSON_PRETTY_PRINT));
 // check for content
 if(!$content['update_id']){exit;}
 // check for telegram bot id
 if(!$GLOBALS['BOT']->telegram_id){exit;}
 // build hook query object
 $hook_qobj=new stdClass();
 $hook_qobj->timestamp=$content['message']['date'];
 $hook_qobj->chat_id=$content['message']['chat']['id'];
 $hook_qobj->chat_title=$content['message']['chat']['title'];
 $hook_qobj->username=$content['message']['from']['username'];
 $hook_qobj->fullname=$content['message']['from']['first_name']." ".$content['message']['from']['last_name'];
 $hook_qobj->request=json_encode($content,JSON_PRETTY_PRINT);
 // debug
 api_dump($hook_qobj,"chat query object");
 // insert hook
 $hook_qobj->id=$GLOBALS['DB']->queryInsert("ambrogio__hooks",$hook_qobj);
 // get chat object
 $chat_obj=new Chat($content['message']['chat']['id']);
 api_dump($chat_obj,"chat");
 // check for unbinded chat
 if(!$chat_obj->telegram_id){
  // check for start command
  if(substr(strtolower($content['message']['text']),0,6)=="/start"){
   // welcome message
   $response="Welcome ".$content['message']['from']['first_name'].", please enter your registration token:";
  }else{
   // check for token
   if(strlen($content['message']['text'])!=32){
    // token error
    $response="Sorry, the registration token is a 32 character string..";
   }else{
    // get chat object
    $chat_obj=new Chat($content['message']['text']);
    api_dump($chat_obj,"chat");
    // check for chat
    if(!$chat_obj->id){
     // chat not found
     $response="Sorry, this registration was not found..";
    }else{
     // check for binded chat
     if($chat_obj->telegram_id){
      // chat already binded
      $response="Sorry, this registration token is already binded to another account..";
     }else{
      // chat found and bindable
      $response="Ok, your account was succesfully binded!";
      // build chat query object
      $chat_qobj=new stdClass();
      $chat_qobj->id=$chat_obj->id;
      $chat_qobj->telegram_id=$content['message']['chat']['id'];
      // debug
      api_dump($chat_qobj,"chat query object");
      // try to update chat telegram id
      if(!$GLOBALS['DB']->queryUpdate("ambrogio__chats",$chat_qobj)){
       $response="Error updating chat telegram id!";
      }
     }
    }
   }
  }
 }else{
  // binded chat
  //$response="ciao ciao ciao";
  exit;
  // @todo parse commands
 }
 // make response parameter
 $parameters=array(
  "method"=>"sendMessage",
  'chat_id' => $content['message']['chat']['id'],
  "text" => $response
 );
 // add hook response
 $hook_qobj->response=json_encode($parameters,JSON_PRETTY_PRINT);
 // update hook
 $GLOBALS['DB']->queryUpdate("ambrogio__hooks",$hook_qobj);
 // check for debug
 if(DEBUG){
  api_dump($parameters,"response parameters");
 }else{
  header("Content-Type: application/json");
  echo json_encode($parameters);
 }
?>