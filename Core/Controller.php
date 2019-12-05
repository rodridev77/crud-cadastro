<?php

namespace Core;

class Controller {

    public function loadView($viewName, $viewData = array()) {
        extract($viewData);

        require "views/" . $viewName . ".php";
    }

    public function loadTemplate($viewName, $viewData = array()) {
        require_once "views/template.php";
    }

    public function loadViewInTemplate($viewName, $viewData = array()) {
        extract($viewData);
        require_once "views/" . $viewName . ".php";
    }

}
