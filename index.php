<?php
/*
  you need to download mustache.php and run composer
*/
if (!is_file("libs/mustache.php/vendor/autoload.php")) {
    throw new Exception("Please install or link 'mustache.php' into 'libs/mustache.php/'.");
    die;
}
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
        );
    }

    function _load_template($template_file) {
        if (!stristr($template_file, ".mustache"))
            $template_file = $template_file . ".mustache";
        $template = file_get_contents("templates/" . $template_file);
        return $template;
    }

    function _render($template, $view_data) {
        $html = $this->mustache->render($template, $view_data);
        return $html;
    }

    function index() {
        $data1 = [
            ['id' => '1001', "name" => "müller", 'birthday' => '23.05.2001', 'prename' => "Hans", 'cityOfBirth' => 'München'],
            ['id' => '1002', "name" => "müller", 'birthday' => '23.04.1976', 'prename' => "Maria", 'cityOfBirth' => "Berlin"],
        ];
//        $data1 = [];
        $template = $this->_load_template("index");
        $view = new ViewObject();
        $view->data = [];
        foreach ($data1 as $k => $v) {
            $v['index'] = $k;
            $view->data[] = new Item($v);
        }
        $view->data_json = json_encode($view->data);
        echo $this->_render($template, $view);
    }

}

class Object
{
    public function __construct($values = null) {
        if (!is_null($values)) {
            foreach ($values as $k => $v) {
                $this->$k = $v;
            }
        }
    }
}

class ViewObject extends Object
{
    public function data_info() {
        return (object) [
            'count' => count($this->data),
            'one' => (count($this->data) === 1)? true : false,
        ];
    }
}

class Item extends Object
{
    public $dump = 123;
    public function sallery() {
        return number_format(@$this->sallery) . " EURO";
    }

    public function name() {
        return ucfirst(@$this->name);
    }

    public function age() {
        $dt = new DateTime($this->birthday);
        $now = new DateTime();
        $diff = $now->diff($dt);
        return $diff->format('%y');
    }

    public function dump() {
        return var_export($this, true);
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

