<?php
/**
 * Application
 *
 * @package Ambrogio\Classes
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    https://github.com/Zavy86/Ambrogio
 */

/**
 * Application class
 */
class Application{

 /** Properties */
 protected $version;
 protected $path;
 protected $host;
 protected $root;
 protected $url;
 protected $dir;
 protected $bot;
 protected $db;

 /**
  * Constructor
  *
  * @param string $configuration
  * @param string $theme [dark|light]
  */
 public function __construct($configuration){
  if(!is_object($configuration)){die("Configuration not defined..");}
  // initialize properties
  $this->version=VERSION;
  $this->path=PATH;
  $this->host=HOST;
  $this->root=ROOT;
  $this->url=URL;
  $this->dir=DIR;
  $this->bot=$configuration->bot_token;
  $this->db=$configuration->db_name;
 }

 /**
  * Get Property
  *
  * @param string $property Property name
  * @return type Property value
  */
 public function __get($property){return $this->$property;}

}
