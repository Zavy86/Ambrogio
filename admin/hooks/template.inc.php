<?php
/**
 * Template
 *
 * @package Ambrogio\Admin\Hooks
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
api_checkAuthorizations();
// build navigation
$nav=new strNav("nav-tabs");
$nav->setTitle("Hooks");
$nav->addItem("Hooks","admin.php?mod=".MODULE."&scr=hook_list");
// operations
if($hook_obj->id && in_array(SCRIPT,array("hook_view"))){
 $nav->addItem("Hook",null,null,"active");
 //$nav->addItem("Operations",null,null,"active");
 //$nav->addSubItem("Edit hook","admin.php?mod=".MODULE."&scr=hook_edit&idHook=".$hook_obj->id);
}
// renderize nav into bootstrap sections
$bootstrap->addSection($nav->render(false,3));
