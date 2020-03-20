<?php
/**
 * Hook View
 *
 * @package Ambrogio\Admin\Hooks
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // get object
 $hook_obj=new Hook($_REQUEST['idHook']);
 if(!$hook_obj->id){api_alert("Hook not found","danger");api_redirect("admin.php?mod=".MODULE."&scr=hook_list");}
 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Hook ".api_timestamp_format($hook_obj->timestamp));
 // build description list
 $dl=new strDescriptionList("br","dl-horizontal");
 $dl->addElement("Timestamp",api_timestamp_format($hook_obj->timestamp));
 if($hook_obj->username){$dl->addElement("Username",api_link("https://t.me/".$hook_obj->username,"@".$hook_obj->username,null,null,false,null,null,null,"_blank"));}
 $dl->addElement("Fullname",$hook_obj->fullname);
 $dl->addElement("Channel",($hook_obj->chat_title?$hook_obj->chat_title:"Private"));
 $dl->addElement("Request","<pre>".print_r($hook_obj->request,true)."</pre>");
 $dl->addElement("Response","<pre>".print_r($hook_obj->response,true)."</pre>");
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize description list into grid
 $grid->addCol($dl->render(6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
