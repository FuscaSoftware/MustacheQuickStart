<?php
/*
  you need to download mustache.php and run composer
*/
require "libs/mustache.php/vendor/autoload.php";
class Controller
{
  public $mustache;
  function __construct() {
    $this->mustache = new Mustache_Engine(
    [
//        'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates/partials'),
    'partials' => [
      'head' => file_get_contents("templates/partials/head.mustache"),
      'table' => file_get_contents("templates/partials/table.mustache"),
      ]
    ]
  }
  function _load_template($template_file) {
    if (!stristr($template_file, ".mustache"))
      $template_file = $template_file . ".mustache";
    $template = file_get_contents("templates/".$template_file);
  }
  function index() {
    $template = $this->_load_template("index");
    echo $template;
  }
}

$controller = new Controller();
$controller->index();
