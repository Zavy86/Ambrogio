<?php
/**
 * Hook
 *
 * @package Ambrogio\Classes
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */

/**
 * Hook class
 */
class Hook{

 /** Properties */
 protected $id;
 protected $timestamp;
 protected $chat_id;
 protected $chat_title;
 protected $username;
 protected $fullname;
 protected $request;
 protected $response;

 /**
  * Constructor
  */
 public function __construct($hook){
  // load object
  if(is_numeric($hook)){$hook=$GLOBALS['DB']->queryUniqueObject("SELECT * FROM `ambrogio__hooks` WHERE `id`='".$hook."'");}
  if(!$hook->id){return false;}
  // initialize properties
  $this->id=(int)$hook->id;
  $this->timestamp=(int)$hook->timestamp;
  $this->chat_id=$hook->chat_id;
  $this->chat_title=stripslashes($hook->chat_title);
  $this->username=stripslashes($hook->username);
  $this->fullname=stripslashes($hook->fullname);
  $this->request=json_decode($hook->request,true);
  $this->response=json_decode($hook->response,true);
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
