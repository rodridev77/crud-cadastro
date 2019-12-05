<?php

namespace Models;

use \Core\Connection;
use \PDO;

class Products {

    private $conn;

    public function __construct() {
        $this->conn = Connection::connect();
    }

    public function getAllProducts() {
        $items = array();

        $sql = "SELECT * FROM eletronicos GROUP BY id LIMIT 7";

        $stmt = $this->conn->query($sql);

        if ($stmt->rowCount() > 0):
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        endif;

        return $items;
    }

    public function add($cod = 0, $name = "", $price = '0', $import = 0, $units = 0) {

        try {
            $query = "SELECT codigo, unidades FROM eletronicos WHERE codigo = :cod";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":cod", $cod, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $units = $stmt->fetch()['unidades'] + $units;
                $query = "UPDATE eletronicos SET unidades = :units WHERE codigo = :cod";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(":units", $units, PDO::PARAM_INT);
                $stmt->bindValue(":cod", $cod, PDO::PARAM_STR);

                if ($stmt->execute()):
                    return true;
                endif;
            } else {
                $query = "INSERT INTO eletronicos SET codigo = :cod, nome = :name, preco = :price, unidades = :units, importado = :import";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(":cod", $cod, PDO::PARAM_STR);
                $stmt->bindValue(":name", $name, PDO::PARAM_STR);
                $stmt->bindValue(":price", $price, PDO::PARAM_STR);
                $stmt->bindValue(":units", $units, PDO::PARAM_INT);
                $stmt->bindValue(":import", $import, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    return true;
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }
    }

    public function edit($id, $cod, $name, $price, $import, $units) {
        try {
            $query = "UPDATE eletronicos SET codigo = :cod, nome = :name, preco = :price, unidades = :units, importado = :import WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":cod", $cod, PDO::PARAM_STR);
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":price", $price, PDO::PARAM_STR);
            $stmt->bindValue(":units", $units, PDO::PARAM_INT);
            $stmt->bindValue(":import", $import, PDO::PARAM_INT);
            $stmt->bindValue(":id", $id, PDO::PARAM_STR);

            if ($stmt->execute()):
                return true;
            endif;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }

        return false;
    }

    public function removeById($id) {

        try {
            $query = "DELETE FROM eletronicos WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()):
                return true;
            endif;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMesage();
            die;
        }

        return false;
    }

    public function search($cod) {
        $result = array();

        try {
            $query = "SELECT * FROM eletronicos WHERE codigo = :cod";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":cod", $cod, PDO::PARAM_STR);

            if ($stmt->execute()):
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            endif;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }

        return $result;
    }

}
