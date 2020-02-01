<?php
/**
 * Chat
 *
 * @package Ambrogio\Classes
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */

/**
 * Chat class
 */
class Chat{

 /** Properties */
 protected $id;
 protected $key;
 protected $name;
 protected $telegram_id;

 /**
  * Constructor
  */
 public function __construct($chat){
  // load object
  if(is_numeric($chat)){$chat=$GLOBALS['DB']->queryUniqueObject("SELECT * FROM `ambrogio__chats` WHERE `id`='".$chat."' OR `telegram_id`='".$chat."'");}
  if(is_string($chat)){$chat=$GLOBALS['DB']->queryUniqueObject("SELECT * FROM `ambrogio__chats` WHERE `key`='".$chat."'");}
  if(!$chat->id){return false;}
  // initialize properties
  $this->id=(int)$chat->id;
  $this->key=stripslashes($chat->key);
  $this->name=stripslashes($chat->name);
  $this->telegram_id=$chat->telegram_id;
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

}
