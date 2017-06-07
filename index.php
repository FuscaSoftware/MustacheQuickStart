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
  function _render($template, $view_data) {
      $html = $this->mustache->render($template, $view_data);
      return $html;
  }
  function index() {
    $data1 = [
      ['id' => '1001', "name" => "müller1"],
      ['id' => '1002', "name" => "müller2"],
    ];
    $template = $this->_load_template("index");
    $view = new ViewObject();
    foreach ($data1 as $k => $v){
      $view['data'] = new Item($v);
    }
    echo $this->_render($template, $view);
  }
  function ajax() {
    $data2 = [
      ['id' => '1001', "sallery" => "5000"],
      ['id' => '1002', "sallery" => "6000"],
    ]
    return json_encode($data2);
  }
}
class Object
{
    public function __construct($values = null) {
        if (!is_null($values)) {
            foreach ($values as $k => $v) {
                $this->$k = $values[$k];
            }
        }
    }
}
class ViewObject extends Object
{
}
class Item extends Object
{
   public function sallery() {
    return number_format(@$this->sallery). " EURO";
  }
  public function name() {
    return strtoupper(@$this->name);)
  }
}


$controller = new Controller();
if (@$_GET['action']) {
  $action = $_GET['action'];
} else {
  $action = "index";
}
if (method_exists($controller, $action))
  call_user_func([$controller, $action]);
else
  $controller->index();

