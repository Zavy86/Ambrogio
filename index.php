<?php
/**
 * Index
 *
 * @package Ambrogio
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 // load application
 require_once("loader.inc.php");
 // include dashboard class
 require_once(DIR."classes/Dashboard.class.php");
 // acquire variables
 $r_dashboard=$_REQUEST['dashboard'];
 if(!$r_dashboard){$r_dashboard="default";}
 // initialize dashboard
 $dashboard=new Dashboard($r_dashboard);
 // renderize dashboard
 $dashboard->render();
 // debug
 api_dump($dashboard,"Dashboard");
 api_dump($APP,"Ambrogio");
 api_dump($DB,"Database");
