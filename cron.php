<?php
/**
 * Cron
 *
 * @package Ambrogio
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
 set_time_limit(0);
 ignore_user_abort(true);
 // load application
 require_once("loader.inc.php");
 // debug
 api_dump($APP,"Ambrogio");
 api_dump($DB,"Database");
