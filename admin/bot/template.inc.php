<?php
/**
 * Template
 *
 * @package Ambrogio\Admin\Bots
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */
api_checkAuthorizations();
// build navigation
$nav=new strNav("nav-tabs");
$nav->setTitle("Bot");
$nav->addItem("Informations","admin.php?mod=".MODULE);
// renderize nav into bootstrap sections
$bootstrap->addSection($nav->render(false,3));
