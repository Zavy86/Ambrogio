<?php
/**
 * Dashboard
 *
 * @package Ambrogio\Admin\Administration
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 api_checkAuthorizations();
 // include template
 require_once("template.inc.php");
 // set title
 $bootstrap->setTitle("Administration");
 // definitions
 $dashboard=null;
 // build dashboard buttons
 $dashboard.=str_repeat(" ",6).api_link("admin.php?mod=bot",api_icon("ticket",null,"fa-4x")."<br><br>Bot","Bot settings","btn btn-default btn-lg btn-dashboard")."\n";
 $dashboard.=str_repeat(" ",6).api_link("admin.php?mod=chats",api_icon("comment",null,"fa-4x")."<br><br>Chats","Manage chats","btn btn-default btn-lg btn-dashboard")."\n";
 $dashboard.=str_repeat(" ",6).api_link("admin.php?mod=hooks",api_icon("anchor",null,"fa-4x")."<br><br>Hooks","Hook logs","btn btn-default btn-lg btn-dashboard")."\n";
 $dashboard.=str_repeat(" ",6).api_link("admin.php?mod=authentication&scr=submit&act=logout",api_icon("lock",null,"fa-4x")."<br><br>Lock","Administration logout","btn btn-default btn-lg btn-dashboard")."\n";
 // build grid
 $grid=new strGrid();
 // add grid row
 $grid->addRow();
 // renderize dashboard list into grid
 $grid->addCol($dashboard,"col-xs-12");
 // renderize grid into bootstrap sections
 $bootstrap->addSection($grid->render(true,3));
