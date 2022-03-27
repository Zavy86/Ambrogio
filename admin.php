<?php
/**
 * Administration
 *
 * @package Ambrogio
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 *
 * @var Application $APP
 * @var Database $DB
 * @var Bot $BOT
 */
 // load application
 require_once("loader.inc.php");
 // include bootstrap structures
 require_once($APP->dir."structures/strBootstrap.class.php");
 // acquire variables
 $r_module=$_REQUEST['mod']??'administration';
 $r_script=$_REQUEST['scr']??'dashboard';
 $r_action=$_REQUEST['act']??null;
 // module, script ad action definitions
 define('MODULE',$r_module);
 define('SCRIPT',$r_script);
 define('ACTION',$r_action);
 // globals variables
 global $bootstrap;
 // build bootstrap structure
 $bootstrap=new strBootstrap();
 // build navbar
 $navbar=new strNavbar("Ambrogio");
 $navbar->addNav();
 $navbar->addElement("Administration","admin.php?mod=administration");
 $navbar->addElement("Bot","admin.php?mod=bot");
 $navbar->addElement("Chats","admin.php?mod=chats");
 $navbar->addElement("Hooks","admin.php?mod=hooks");
 $navbar->addNav("navbar-right");                                                                                  /** todo right */
 $navbar->addElement(api_icon("lock","Lock"),"admin.php?mod=authentication&scr=submit&act=logout");
 // add navbar to bootstrap
 $bootstrap->addSection($navbar->render(3));
 // check and import script
 if(!is_dir($APP->dir."admin/".MODULE)){api_alert("Module <em>".MODULE."</em> was not found..","danger");api_redirect($APP->path."admin.php");}
 if(!file_exists($APP->dir."admin/".MODULE."/".SCRIPT.".inc.php")){api_alert("Script <em>".SCRIPT."</em> was not found in module <em>".MODULE."</em>..","danger");}
 else{require_once($APP->dir."admin/".MODULE."/".SCRIPT.".inc.php");}
 // build footer grid
 $footer_grid=new strGrid();
 $footer_grid->addRow("footer");
 $footer_grid->addCol(str_repeat(" ",6).api_tag("div","Copyright 2018-".date("Y")." &copy; <a href=\"https://github.com/Zavy86/Ambrogio\" target=\"_blank\">Ambrogio</a> - All Rights Reserved","text-right")."\n","col-xs-12");
 // add footer grid to bootstrap
 $bootstrap->addSection(str_repeat(" ",3)."<hr>\n".$footer_grid->render(true,3));
 // renderize bootstrap
 $bootstrap->render();
 // debug
 api_dump($BOT,"Bot");
 api_dump($APP,"Application");
 api_dump($DB,"Database");
