<?php
/**
 * Chat Edit
 *
 * @package Ambrogio\Admin\Chats
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // get object
 $chat_obj=new Chat($_REQUEST['idChat']);
 // include template
 require_once("template.inc.php");
 // set title
 if(!$chat_obj->id){$bootstrap->setTitle("Add new chat");}
 else{$bootstrap->setTitle("Edit ".$chat_obj->title);}
 // build form
 $form=new strForm("admin.php?mod=".MODULE."&scr=submit&act=chat_save&idChat=".$chat_obj->id."&return_scr=".api_return_script("chat_view"),"POST",null,"chat_edit");
 $form->addField("text","name","Name",$chat_obj->name,"Chat name",null,null,null,"required");
 $form->addControl("submit","Submit");
 $form->addControl("button","Cancel","admin.php?mod=".MODULE."&scr=".api_return_script("chat_view")."&idChat=".$chat_obj->id);
 if($chat_obj->id){$form->addControl("button","Remove","admin.php?mod=".MODULE."&scr=submit&act=chat_remove&idChat=".$chat_obj->id,"btn-danger","Are you sure you want to remove definitively this chat?");}
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize description list into grid
 $grid->addCol($form->render(0,6),"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
