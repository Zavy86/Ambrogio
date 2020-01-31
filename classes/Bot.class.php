<?php
/**
 * Bot
 *
 * @package Ambrogio\Classes
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */

/**
 * Bot class
 */
class Bot{

 /** Properties */
 protected $token;
 protected $title;
 protected $username;
 protected $telegram_id;
 protected $link;
 protected $url;

 /**
  * Constructor
  */
 public function __construct(){

  // set parameters
  $this->token=$GLOBALS['APP']->bot;
  $this->url="https://api.telegram.org/bot".$this->token."/";

  // call telegram api and get response
  $response=json_decode(file_get_contents($this->url."getMe"),true);
  // debug
  //api_dump($response,"getMe response");
  // check response
  if(!$response['ok']){api_alert("Bot token error","danger");}
  // set parameters
  $this->title=$response['result']['first_name'];
  $this->telegram_id=$response['result']['id'];
  $this->username=$response['result']['username'];
  $this->link="https://t.me/".$this->username;
  //api_dump($this);
  // return
  return $this->id;
 }

 /**
  * Get Property
  *
  * @param string $property Property name
  * @return type Property value
  */
 public function __get($property){return $this->$property;}

 /**
  * Get Webhook Info
  *
  * @return object
  */
 public function getWebhookInfo(){
  // call telegram api and get response
  $response=json_decode(file_get_contents($this->url."getWebhookInfo"),true);
  // debug
  //api_dump($response,"getWebhookInfo response");
  // check response
  if(!$response['ok']){return false;}
  // return
  return (object)$response['result'];
 }

 /**
  * Set Webhook
  *
  * @return object
  */
 public function setWebhook(){
  $url=str_replace("http://","https://",$GLOBALS['APP']->url);
  // call telegram api and get response
  $response=json_decode(file_get_contents($this->url."setWebhook?url=".$url."hook.php"),true);
  // debug
  //api_dump($response,"setWebhook response");
  // check response
  if(!$response['ok']){return false;}
  // return
  return true;
 }

 /**
  * Send Message
  *
  * @param double $chat Chat ID
  * @param string $message HTML Message
  * @return object
  */
 public function sendMessage($chat,$message){
  // make parameters
  $parameters=array(
   "chat_id"=>$chat,
   "parse_mode"=>"html",
   "text"=>$message
  );
  // make url
  $url=$this->url."sendMessage?".http_build_query($parameters);
  // debug
  api_dump($url,"sendMessage call");
  // call telegram api and get response
  $response=json_decode(file_get_contents($url),true);
  // debug
  api_dump($response,"sendMessage response");
  
  // check response
  if(!$response['ok']){return false;}
  // return
  return true;
 }

}
