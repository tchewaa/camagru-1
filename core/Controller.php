<?php


    class Controller extends Application {
        protected $_controller, $_action;
        public $view;

        public function __construct($controller, $action) {
            $this->_controller = $controller;
            $this->_action = $action;
            $this->view = new View();
        }

        //TODO go through this method line by line
        protected function load_model($model) {
            if (class_exists($model)) {
                $this->{$model.'Model'} = new $model(strtolower($model));
            }
        }
    }