<?php
/**
 * Submit
 *
 * @package Ambrogio\Admin\Bots
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // switch action
 switch(ACTION){
  // dashboards
  case "bot_setWebhook":bot_setWebhook();break;
  // default
  default:
   api_alert("Submit function for action <em>".ACTION."</em> was not found in module <em>".MODULE."</em>..","danger");
   api_redirect("admin.php?mod=".MODULE);
 }

 /**
  * Bot Set Webhook
  */
 function bot_setWebhook(){
  api_dump($_REQUEST,"_REQUEST");
  // check authorizations
  api_checkAuthorizations();
  // get objects
  $bot_obj=new Bot();
  api_dump($bot_obj,"bot object");
  // set webhook
  if($bot_obj->setWebhook()){
   api_alert("Webhook setted","success");
  }else{
   api_alert("Error setting webhook","error");
  }
  // redirect
  api_redirect("admin.php?mod=".MODULE);
 }
