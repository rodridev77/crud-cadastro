<?php

namespace Controllers;

use Core\Connection;
use Core\Controller;
use Models\Products;
use Core\Paginator;

class HomeController extends Controller {

    public function index() {
        $data = array();

        $data = $this->createPaginator();
        $data['msg_add'] = "";

        if (isset($_POST['enviar'])) {

            if ($this->add()):
                $data['msg_add'] = "Produto cadastrado com sucesso";
                $data['class_msg'] = 'alert-success';
            else:
                $data['msg_add'] = "Não foi possivel efetuar o cadastro";
                $data['class_msg'] = 'alert-warning';
            endif;
        }

        $this->loadTemplate('home', $data);
    }

    public function add() {

        $name = filter_input(INPUT_POST, "input-name", FILTER_SANITIZE_STRING);
        $cod = filter_input(INPUT_POST, "input-cod", FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, "input-price", FILTER_SANITIZE_STRING);
        $units = filter_input(INPUT_POST, "input-units", FILTER_VALIDATE_INT);


        if (($name && $cod && $price && $units !== FALSE) || ($name && $cod && $price && $units !== NULL)) {
            $name = filter_var($name, FILTER_SANITIZE_STRING);
            $cod = filter_var($cod, FILTER_SANITIZE_STRING);
            $price = floatval(filter_var($price, FILTER_SANITIZE_STRING));
            $units = filter_var($units, FILTER_VALIDATE_INT);

            $import = substr($cod, 0, 3);

            if (strcmp($import, "789")):
                $import = 1;
            else:
                $import = 0;
            endif;

            $prod = new Products();
            if ($prod->add($cod, $name, $price, $import, $units)):
                return true;
            endif;
        }

        return false;
    }

    public function edit() {
        $id = intval(abs(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT)));
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $cod = filter_input(INPUT_POST, "cod", FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_STRING);
        $units = filter_input(INPUT_POST, "units", FILTER_VALIDATE_INT);


        if (($id && $name && $cod && $price && $units !== FALSE) || ($id && $name && $cod && $price && $units !== NULL)) {
            $name = filter_var($name, FILTER_SANITIZE_STRING);
            $cod = filter_var($cod, FILTER_SANITIZE_STRING);
            $price = floatval(filter_var($price, FILTER_SANITIZE_STRING));
            $units = filter_var($units, FILTER_VALIDATE_INT);

            $import = substr($cod, 0, 3);

            if (strcmp($import, "789")):
                $import = 1;
            else:
                $import = 0;
            endif;

            $prod = new Products();
            if ($prod->edit($id, $cod, $name, $price, $import, $units)):
                echo "success";
            endif;
        } else {
            echo "$cod";
        }
    }

    public function remove() {
        $id = intval(abs(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT)));

        if ($id) {
            $prod = new Products();

            if ($prod->removeById($id)):
                echo "success";
            endif;
        } else {
            echo "";
        }
    }

    public function createPaginator() {
        $results = array();
        $limit = 2;
        $page = 1;
        $links = 3;

        // DO NOT limit this query with LIMIT keyword, or...things will break!
        $query = "SELECT * FROM eletronicos";

        if (filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT)):
            $page = intval(abs(filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT)));
        endif;

        $conn = Connection::connect();
        $paginator = new Paginator($conn, $query);
        $results['items'] = $paginator->getData($limit, $page);
        $results['links'] = get_object_vars($this->createLinks($links, $paginator));

        return $results;
    }

    public function createLinks($links, $paginator) {
        $pag = new \stdClass();

        // return empty result string, no links necessary
        if ($paginator->getLimit() == 'all'):
            $pag->limit = $paginator->getLimit();
            return $pag;
        endif;

        // get current page
        $pag->page = $paginator->getPage();

        $pag->limit = $paginator->getLimit();

        // get the last page number
        $pag->last = ceil($paginator->getTotal() / $paginator->getLimit());

        // calculate start of range for link printing
        $pag->start = (($paginator->getPage() - $links) > 0) ? $paginator->getPage() - $links : 1;

        // calculate end of range for link printing
        $pag->end = (($paginator->getPage() + $links) < $pag->last) ? $paginator->getPage() + $links : $pag->last;

        return $pag;
    }

    public function search() {
        $word = filter_input(INPUT_GET, "cod");
        $result = array();

        if ($word) {
            $prod = new Products();
            $result = $prod->search($word);
        }

        echo json_encode($result);
    }

}
