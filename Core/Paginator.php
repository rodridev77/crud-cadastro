<?php

namespace Core;

use \PDO;

class Paginator {

    // declare all internall (private) variables,only acessible within this class
    private $conn;
    private $limit; // records (rows) to show per page
    private $page; // current page;
    private $query;
    private $total;
    private $rowstart;

    // constuct method is called automatically when object is instantiated
    public function __construct($conn, $query) {
        // $this-> variables become availables anywhere within THIS class
        $this->conn = $conn; // mysql connection resource
        $this->query = $query; // mysql query string

        try {
            $stmt = $this->conn->query($this->query);
            $this->total = $stmt->rowCount(); // total number of rows

            $this->total = $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }
    }

    // LIMIT DATA
    // all it does is limits the data returned and returns everything as $result object
    public function getData($limit = 10, $page = 1) { // set default arguments values
        $results = array();
        $this->limit = $limit;
        $this->page = $page;

        // no limiting necessary, use query as it is
        if ($this->limit == 'all') {
            $query = $this->query;
        } else {
            // echo (($this->page - 1) * $this->limit); die;
            // create the query, limiting records from page, to limit
            $this->rowstart = (($this->page - 1) * $this->limit);
            // add to original query: (minus one because of the way SQL works)
            $query = $this->query . " LIMIT {$this->rowstart}, $this->limit";
        }

        try {
            $stmt = $this->conn->query($query);

            if ($stmt->execute()):
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            endif;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }

        return $results; // object
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getPage() {
        return $this->page;
    }

}
