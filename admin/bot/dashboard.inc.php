<?php
/**
 * Bot Dashboard
 *
 * @package Ambrogio\Admin\Bot
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // get object
 $bot_obj=new Bot();

 // debug
 //api_dump($bot_obj,"Bot");
 //api_dump($bot_obj->setWebhook(),"setWebhook");
 //api_dump($bot_obj->getWebhookInfo(),"getWebhookInfo");

 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Bot ".$bot_obj->title);
 // build description list
 $dl=new strDescriptionList("br","dl-horizontal");
 $dl->addElement("Bot",api_tag("strong",$bot_obj->title));
 $dl->addElement("Link",api_link($bot_obj->link,"@".$bot_obj->username,null,null,false,null,null,null,"_blank"));
 $dl->addElement("Telegram ID",api_tag("samp",$bot_obj->telegram_id));

 if($bot_obj->getWebhookInfo()->url==$APP->url."hook.php"){
  $dl->addElement("Webhook",api_icon("check"));
 }else{
  $dl->addElement("Webhook",api_icon("remove")."&nbsp;&nbsp;&rarr;&nbsp;&nbsp;".api_link("admin.php?mod=".MODULE."&scr=submit&act=bot_setWebhook","Set Webhook"));
 }

 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize description list into grid
 $grid->addCol($dl->render(6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
