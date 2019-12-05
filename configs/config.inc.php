<?php

require_once "environment.php";

// CONFIGURAÇÃO DO AMBIENTE #####################
if (ENVIRONMENT == "development") {
    define("BASE_URL", "http://localhost/cadastro-produto/");
} else {
    define("BASE_URL", "http://meusite.com.br/");
}

// CONFIGURAÇÃO DO BANDO DE DADOS #####################
define('HOST', 'localhost');
define('DBNAME', 'cadastro_produto');
define('USER', 'root');
define('PASS', '123');
define('DRIVER', 'mysql');
define('CHARSET', 'utf8');
