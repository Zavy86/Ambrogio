<?php
/**
 * Hook List
 *
 * @package Ambrogio\Admin\Hooks
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Hooks");
 // set database
 $database=$GLOBALS['APP']->db;
 // build table
 $table=new strTable("There is no hook to show..");
 // add table headers
 $table->addHeader("&nbsp;");
 $table->addHeader("Timestamp","nowrap");
 $table->addHeader("Fullname","nowrap");
 $table->addHeader("Request",null,"100%");
 $table->addHeader("Channel","nowrap text-right");
 // get hooks
 $hooks_array=array();
 $results=$GLOBALS['DB']->queryObjects("SELECT * FROM `ambrogio__hooks` ORDER BY `timestamp` DESC");
 foreach($results as $result){$hooks_array[$result->id]=new Hook($result);}
 // cycle all hooks
 foreach($hooks_array as $hook_fobj){
  // add table datas
  $table->addRow();
  $table->addRowFieldAction("admin.php?mod=hooks&scr=hook_view&idHook=".$hook_fobj->id,api_icon("search","View hook"));
  $table->addRowField(api_timestamp_format($hook_fobj->timestamp),"nowrap");
  $table->addRowField($hook_fobj->fullname,"nowrap");
  $table->addRowField(substr($hook_fobj->request['message']['text'],0,256));
  $table->addRowField(($hook_fobj->chat_title?$hook_fobj->chat_title:"Private"),"nowrap text-right");
 }
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize table into grid
 $grid->addCol($table->render(6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
