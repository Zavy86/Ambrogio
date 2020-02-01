<?php
/**
 * Submit
 *
 * @package Ambrogio\Admin\Chats
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // switch action
 switch(ACTION){
  // chats
  case "chat_save":chat_save();break;
  case "chat_remove":chat_remove();break;
  case "chat_notification":chat_notification();break;
  // default
  default:
   api_alert("Submit function for action <em>".ACTION."</em> was not found in module <em>".MODULE."</em>..","danger");
   api_redirect("admin.php?mod=".MODULE);
 }

 /**
  * Chat Save
  */
 function chat_save(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $chat_obj=new Chat($_REQUEST['idChat']);
  api_dump($chat_obj,"chat object");
  // build query object
  $chat_qobj=new stdClass();
  $chat_qobj->id=$chat_obj->id;
  $chat_qobj->title=addslashes($_REQUEST['title']);
  // debug
  api_dump($chat_qobj,"chat query object");
  // check object
  if($chat_obj->id){
   // update
   $GLOBALS['DB']->queryUpdate("ambrogio__chats",$chat_qobj);
   // alert
   api_alert("Chat updated","success");
  }else{
   // insert
   $chat_qobj->key=api_random(32);
   $chat_qobj->id=$GLOBALS['DB']->queryInsert("ambrogio__chats",$chat_qobj);
   // alert
   api_alert("Chat created","success");
  }
  // redirect
  api_redirect("admin.php?mod=".MODULE."&scr=".api_return_script("chat_view")."&idChat=".$chat_qobj->id);
 }

 /**
  * Chat Remove
  */
 function chat_remove(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $chat_obj=new Chat($_REQUEST['idChat']);
  api_dump($chat_obj,"chat object");
  // check object
  if(!$chat_obj->id){api_alert("Chat not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=chat_list");}
  // remove division
  $deleted=$GLOBALS['DB']->queryDelete("ambrogio__chats",$chat_obj->id);
  // check query result
  if(!$deleted){api_alert("An error has occurred","danger");api_redirect("admin.php?mod=".MODULE."&scr=chat_list&idChat=".$chat_obj->id);}
  // alert and redirect
  api_alert("Chat removed","warning");
  api_redirect("admin.php?mod=".MODULE."&scr=chat_list");
 }

 /**
  * Chat Notification
  */
 function chat_notification(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $chat_obj=new Chat($_REQUEST['idChat']);
  api_dump($chat_obj,"chat object");
  // check object
  if(!$chat_obj->id){api_alert("Chat not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=chat_list");}
  if(!$chat_obj->telegram_id){api_alert("Chat was not binded to telegram","danger");api_redirect("admin.php?mod=".MODULE."&scr=chat_view&idChat=".$chat_obj->id);}
  // get variables
  $r_message=$_REQUEST['message'];
  // send message
  if($GLOBALS['BOT']->sendMessage($chat_obj->telegram_id,$r_message)){
   // alert and redirect
   api_alert("Notification sended","success");
   api_redirect("admin.php?mod=".MODULE."&scr=".api_return_script("chat_view")."&idChat=".$chat_obj->id);
  }else{
   // alert and redirect
   api_alert("An error has occurred","danger");
   api_redirect("admin.php?mod=".MODULE."&scr=chat_view&idChat=".$chat_obj->id);
  }
 }
