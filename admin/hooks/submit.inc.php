<?php
/**
 * Submit
 *
 * @package Ambrogio\Admin\Hooks
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // switch action
 switch(ACTION){
  // hooks
  case "hook_save":hook_save();break;
  case "hook_remove":hook_remove();break;
  case "hook_notification":hook_notification();break;
  // default
  default:
   api_alert("Submit function for action <em>".ACTION."</em> was not found in module <em>".MODULE."</em>..","danger");
   api_redirect("admin.php?mod=".MODULE);
 }

 /**
  * Hook Save
  */
 function hook_save(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $hook_obj=new Hook($_REQUEST['idHook']);
  api_dump($hook_obj,"hook object");
  // build query object
  $hook_qobj=new stdClass();
  $hook_qobj->id=$hook_obj->id;
  $hook_qobj->title=addslashes($_REQUEST['title']);
  // debug
  api_dump($hook_qobj,"hook query object");
  // check object
  if($hook_obj->id){
   // update
   $GLOBALS['DB']->queryUpdate("ambrogio__hooks",$hook_qobj);
   // alert
   api_alert("Hook updated","success");
  }else{
   // insert
   $hook_qobj->key=api_random(32);
   $hook_qobj->id=$GLOBALS['DB']->queryInsert("ambrogio__hooks",$hook_qobj);
   // alert
   api_alert("Hook created","success");
  }
  // redirect
  api_redirect("admin.php?mod=".MODULE."&scr=".api_return_script("hook_view")."&idHook=".$hook_qobj->id);
 }

 /**
  * Hook Remove
  */
 function hook_remove(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $hook_obj=new Hook($_REQUEST['idHook']);
  api_dump($hook_obj,"hook object");
  // check object
  if(!$hook_obj->id){api_alert("Hook not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=hook_list");}
  // remove division
  $deleted=$GLOBALS['DB']->queryDelete("ambrogio__hooks",$hook_obj->id);
  // check query result
  if(!$deleted){api_alert("An error has occurred","danger");api_redirect("admin.php?mod=".MODULE."&scr=hook_list&idHook=".$hook_obj->id);}
  // alert and redirect
  api_alert("Hook removed","warning");
  api_redirect("admin.php?mod=".MODULE."&scr=hook_list");
 }

 /**
  * Hook Notification
  */
 function hook_notification(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $hook_obj=new Hook($_REQUEST['idHook']);
  api_dump($hook_obj,"hook object");
  // check object
  if(!$hook_obj->id){api_alert("Hook not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=hook_list");}
  if(!$hook_obj->telegram_id){api_alert("Hook was not binded to telegram","danger");api_redirect("admin.php?mod=".MODULE."&scr=hook_view&idHook=".$hook_obj->id);}
  // get variables
  $r_message=$_REQUEST['message'];
  // send message
  if($GLOBALS['BOT']->sendMessage($hook_obj->telegram_id,$r_message)){
   // alert and redirect
   api_alert("Notification sended","success");
   api_redirect("admin.php?mod=".MODULE."&scr=".api_return_script("hook_view")."&idHook=".$hook_obj->id);
  }else{
   // alert and redirect
   api_alert("An error has occurred","danger");
   api_redirect("admin.php?mod=".MODULE."&scr=hook_view&idHook=".$hook_obj->id);
  }
 }
