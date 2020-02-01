<?php
/**
 * Bot Dashboard
 *
 * @package Ambrogio\Admin\Bot
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();

 // debug
 //api_dump($BOT,"Bot");
 //api_dump($BOT->setWebhook(),"setWebhook");
 //api_dump($BOT->getWebhookInfo(),"getWebhookInfo");

 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle($BOT->title);
 // build description list
 $dl=new strDescriptionList("br","dl-horizontal");
 $dl->addElement("Bot",api_tag("strong",$BOT->title));
 $dl->addElement("Link",api_link($BOT->link,"@".$BOT->username,null,null,false,null,null,null,"_blank"));
 $dl->addElement("Telegram ID",api_tag("samp",$BOT->telegram_id));

 if($BOT->getWebhookInfo()->url==$APP->url."hook.php"){
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
