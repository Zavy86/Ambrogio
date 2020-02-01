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
 // get, decode and store for debug content
 $content_raw=file_get_contents("php://input");
 //file_put_contents("tmp/debug_".time().".json",$content_raw,JSON_PRETTY_PRINT);
 $content_raw=file_get_contents("tmp/debug.json");
 $content=json_decode($content_raw,true);
 api_dump($content,"content");
 // check for content
 if(!$content['update_id']){exit;}
 // get bot object
 $bot_obj=new Bot();
 api_dump($bot_obj,"bot");
 if(!$bot_obj->telegram_id){exit;}
 // get chat object
 $chat_obj=new Chat($content['message']['chat']['id']);
 api_dump($chat_obj,"chat");
 // check for unbinded chat
 if(!$chat_obj->telegram_id){
  // check for start command
  if(substr(strtolower($content['message']['text']),0,6)=="/start"){
   // welcome message
   $response="Welcome ".$content['message']['from']['first_name'].", please enter your registration key:";
  }else{
   // check for key
   if(strlen($content['message']['text'])!=32){
    // key error
    $response="Sorry, the registration key is a 32 character string..";
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
      $response="Sorry, this registration key is already binded to another account..";
     }else{
      // chat found and bindable
      $response="Ok, your account was succesfully binded!";
      // build query object
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
  $response="ciao ciao ciao";
  // @todo parse commands
 }
 // make response parameter
 $parameters=array(
  "method"=>"sendMessage",
  'chat_id' => $content['message']['chat']['id'],
  "text" => $response
 );
 // check for debug
 if(DEBUG){
  api_dump($parameters,"response parameters");
 }else{
  header("Content-Type: application/json");
  echo json_encode($parameters);
 }
?>