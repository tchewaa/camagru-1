<?php
    namespace Core;
    use Core\Application;


class Controller extends Application {
    protected $_controller;
    protected $_action;
    public $view;
    public $request;

    public function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->request = new Input();
        $this->view = new View();
    }

    //TODO go through this method line by line
    protected function load_model($model) {
        $modelPath = 'App\Models\\' . $model;
        if(class_exists($modelPath)) {
            $this->{$model.'Model'} = new $modelPath();
        }
    }

    public function jsonResponse($resp){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: applicaton/json; charset=UTF-8");
        http_response_code(200);
        echo json_encode($resp);
        exit;
    }
}