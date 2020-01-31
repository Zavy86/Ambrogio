<?php
/**
 * Chat View
 *
 * @package Ambrogio\Admin\Chats
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // get object
 $chat_obj=new Chat($_REQUEST['idChat']);
 if(!$chat_obj->id){api_alert("Chat not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=chat_list");}
 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Chat ".$chat_obj->name);
 // build description list
 $dl=new strDescriptionList("br","dl-horizontal");
 $dl->addElement("Chat",api_tag("strong",$chat_obj->name));
 $dl->addElement("Key",api_tag("samp",$chat_obj->key));
 $dl->addElement("Telegram ID",($chat_obj->telegram_id?strtoupper($chat_obj->telegram_id):api_tag("em","Unbinded")));
 // build form
 $form=new strForm("admin.php?mod=".MODULE."&scr=submit&act=chat_notification&idChat=".$chat_obj->id."&return_scr=".api_return_script("chat_view"),"POST",null,"chat_edit");
 $form->addField("textarea","message","Notification",null,"Notification message for this chat",null,null,null,"required rows=9");
 $form->addControl("submit","Send message");
 $form->addControl("reset","Reset");
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize description list into grid
 $grid->addCol($dl->render(6),"col-xs-12");
 // add grid separator
 $grid->addSeparator();
 // add grid row
 $grid->addRow();
 // renderize form into grid
 $grid->addCol($form->render(null,6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
