<?php

require_once('Config.php');
require_once('ClientInfo.php');

class CustomMonitoring {

    private $dbname = "../myrequests.db";
    private $mytable = "";

    // Main function that redirects to the action depending of GET variables
    public function displayCustomMonitoring() {
        // Get database
        $database = $this->createOrOpenDb();
        // If the id of the page is set
        if ( isset($_GET['id']) ) {
            $id = $_GET['id'];
            if ( isset($_GET['delete']) ){
               $this->deleteMonitoring($database, $id);
            } else {
            // Display the information related to id
            $this->getMonitoring($database, $id);
            }
        } else {
            // if not
            $this->addMonitoring($database);
            $lastId = $this->lastInsertId($database);
            header("Location: custom_monitoring.php?id=" . $lastId);
        }
        $database->close();
    }

    // Open the database and create it if not exists - return a sqlite3 object
    public function createOrOpenDb() {
        if (!class_exists('SQLite3'))
            die("SQLite 3 NOT supported.");
        try {
            // Create or open the database
            $database = new SQLite3($this->dbname, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
            // If the table attribute of the class have not been set, create the table
            if ($this->mytable !== "custom_requests") {
                $this->createTable($database);
            }
            return $database;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    // Creation of the tables
    public function createTable($base) {
        $table = "custom_requests";
        $query = "CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY,name TEXT, request TEXT, statistics TEXT)";
        $base->exec($query);
        $this->mytable = $table;
    }

    // Add in base monitoring's informations
    public function addMonitoring($base) {
        $newName = $_POST['name'];
        $newRequest = $_POST['request'];
        $query = "INSERT INTO $this->mytable (name,request) VALUES ('$newName','$newRequest')";
        $base->exec($query);
    }

    // Get monitoring's informations from database
    public function getMonitoring($base, $id) {
        $query = "SELECT id, name, request, statistics FROM $this->mytable WHERE id = $id ";
        $results = $base->query($query);

        while ($row = $results->fetchArray()) {
            $id = $row['id'];
            $name = $row['name'];
            $request = $row['request'];
            $statistics = $row['statistics'];
            echo $id . " : " . $name . " : " . $request . " : " . $statistics . " <br/>";
        }
    }

    // Delete monitoring's informations from database - redirection to the creation page
    public function deleteMonitoring($base,$id) {
        $query = "DELETE FROM $this->mytable WHERE id = $id";
        $base->query($query);
        header("Location: test.php");
    }

    // Get the last ID inserted in database
    public function lastInsertId($base) {
        $result = $base->query('SELECT last_insert_rowid() as last_insert_rowid')->fetchArray();
        return $result['last_insert_rowid'];
    }

    // Updating the menu depending on the number of custom monitoring have been saved
    public function updateMenu() {
        $database = $this->createOrOpenDb();
        $query = "SELECT id, name FROM $this->mytable";
        $results = $database->query($query);

        while ($row = $results->fetchArray()) {
            $idPage = (int) $_GET['id'];
            $idBase = $row['id'];
            // Deactivates and changes the appearance of the page's button
            echo ( isset($idPage) && $idPage === $idBase ) ?
                    '<li role="presentation" class="active"><a>' . $row["name"] . '</a></li>' :
                    '<li role="presentation"><a href="custom_monitoring.php?id=' . $idBase . '">' . $row["name"] . '</a></li>';
        }
        $database->close();
    }
    
    public function statsValuesToJson(){
        
    }
}