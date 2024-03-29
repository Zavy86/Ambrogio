<?php
/**
 * Chat List
 *
 * @package Ambrogio\Admin\Chats
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Chats");
 // set database
 $database=$GLOBALS['APP']->db;
 // build table
 $table=new strTable("There is no chat to show..");
 // add table headers
 $table->addHeader("&nbsp;");
 $table->addHeader("Chat",null,"100%");
 $table->addHeader("Token","nowrap text-right");
 $table->addHeader("&nbsp;");
 // get chats
 $chats_array=array();
 $results=$GLOBALS['DB']->queryObjects("SELECT * FROM `ambrogio__chats` ORDER BY `title` ASC");
 foreach($results as $result){$chats_array[$result->id]=new Chat($result);}
 // cycle all chats
 foreach($chats_array as $chat_fobj){
  // add table datas
  $table->addRow();
  $table->addRowFieldAction("admin.php?mod=chats&scr=chat_view&idChat=".$chat_fobj->id,api_icon("search","View chat"));
  $table->addRowField($chat_fobj->title);
  $table->addRowField(api_tag("samp",$chat_fobj->token),"nowrap text-right");
  if($chat_fobj->telegram_id){$table->addRowField(api_icon("check"));}else{$table->addRowField(api_icon("remove"));}
 }
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize table into grid
 $grid->addCol($table->render(6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
