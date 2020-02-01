<?php
/**
 * Template
 *
 * @package Ambrogio\Admin\Chats
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
api_checkAuthorizations();
// build navigation
$nav=new strNav("nav-tabs");
$nav->setTitle("Chats");
$nav->addItem("Chats","admin.php?mod=".MODULE."&scr=chat_list");
// operations
if($chat_obj->id && in_array(SCRIPT,array("chat_view","chat_edit"))){
 $nav->addItem("Operations",null,null,"active");
 $nav->addSubItem("Edit chat","admin.php?mod=".MODULE."&scr=chat_edit&idChat=".$chat_obj->id);
 //$nav->addSubItem("Send message","admin.php?mod=".MODULE."&scr=chat_send&idChat=".$chat_obj->id);
}else{$nav->addItem("Add new chat","admin.php?mod=".MODULE."&scr=chat_edit");}
// renderize nav into bootstrap sections
$bootstrap->addSection($nav->render(false,3));
