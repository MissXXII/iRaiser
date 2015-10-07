<?php

require_once('NotificationInfo.php');
require_once('Config.php');
require_once('ClientInfo.php');

class Notification {

    private $server;

    public function __construct() {
        
    }

    // Display the notifications
    public function displayNotifications() {
        $dbList = $this->getAvailableDb();
        for ($i = 0; $i < count($dbList); $i++) {
            // Get all notifications
            $notifications = $this->getNotifications($this->server, $dbList[$i]->getDatabase());
            // At least one notification to display ?
            if ($notifications) {
                $this->createHTML($notifications, $dbList[$i]->getName());
            } elseif (!$notifications && $i === count($dbList) - 1) {
                echo '<h3>Pas de logs</h3>';
            }
        }
    }

    // Connexion to server and get the list of available databases
    public function getAvailableDb() {
        $dbList = array();
        try {
            // Connect to server
            $serverConnect = new PDO(
                    Config::DATASOURCE .
                    ':host=' . Config::HOST .
                    ';port=' . Config::PORT .
                    ';dbname=' . Config::DATABASE, Config::LOGIN, Config::PASSWORD);
            $this->server = $serverConnect;

            // Get the name of the available databases and the corresponding name of the client
            $sql = $serverConnect->prepare(
                    "SELECT db_database, name, valid " .
                    "FROM ira_donations D, clients C " .
                    "WHERE D.client_id = C.id AND C.valid > 0");
            $sql->execute();
            // Browse the datas of the result of the SQL request and create an array of database list
            while ($row = $sql->fetch()) {
                // Client's name and corresponding database
                $clientInfo = new ClientInfo($row['name'], $row['db_database'], $row['valid']);
                $dbList[] = $clientInfo;
            }
            $sql->closeCursor();
            return $dbList;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        $serverConnect = null;
    }

    // Get the datas from the databases to create the notifications
    public function getNotifications($server, $database) {

        $server->exec('USE ' . $database);
        $notificationsList = array();

        // SQL Request for CURL ERRORS, return a string
        $sql = $server->prepare(
                "SELECT * FROM tmp " .
                "WHERE value LIKE '%curl%' " .
                "AND value NOT LIKE '%CURLE_OK%'");
        $sql->execute();

        // Parsing the result of the SQL request
        while ($row = $sql->fetch()) {
            // This will return the original form of the string which is an associative array
            $result = unserialize(substr($row['value'], strlen('$serial$')));
            // Using regular expression to found the id of the notification in the 'action' cell of the array
            preg_match('#/var/exports/push/(\d+)#', $result['action'], $matchId);
            // $result['returnValue'] : return the text of the notification
            $notificationInfo = new NotificationInfo($matchId[1], $result['startdate'], $result['returnValue']);
            $notificationsList[] = $notificationInfo;
        }
        $sql->closeCursor();

        // SQL Request for HTTP ERRORS, return a part of a string
        $sql2 = $server->prepare(
                "SELECT * FROM tmp " .
                "WHERE value LIKE '%iRaiser/DonationForm/PushNotification%HTTP/1.1%' " .
                "AND value NOT LIKE '%HTTP/1.1 2%' AND value NOT LIKE '%HTTP/1.1 1%'");
        $sql2->execute();

        // Parsing the result of the SQL request
        while ($row = $sql2->fetch()) {
            // This will return the original form of the string which is an associative array
            $result = unserialize(substr($row['value'], strlen('$serial$')));
            // Using regular expression to found the id of the notification in the 'action' cell of the array
            preg_match('/Notification-Id:(\d+)/', $result['action'], $matchId);
            // Using regular expression to found the text of the notification in the 'returnValue' of the array
            preg_match('/HTTP\/1\.1 (.*)\n/', $result['returnValue'], $matchError);
            $notificationInfo = new NotificationInfo($matchId[1], $result['startdate'], $matchError[1]);
            $notificationsList[] = $notificationInfo;
        }
        $sql2->closeCursor();
        
        return $notificationsList;
    }

    // Create the HTML array to display.
    public function createHTML($notifications, $clientName) {
        echo '<table class="table .table-responsive sortable-theme-bootstrap" data-sortable="" data-sortable-initialized="true">
                        <thead>
                            <tr><h4 class="text-primary">' . $clientName . '<h4></tr>
                              <tr>
                                <th class="col-xs-1">ID</th>
                                <th class="col-xs-2">Date</th>
                                <th class="col-xs-8">Message</th>
                                <th class="col-xs-1">Nombre</th>
                              </tr>
                        </thead>
                        <tbody>';
        $nb = 1;
        $oldId = 0;
        $oldDate = "";
        
        for ($i = 0; $i < count($notifications); $i++) {
            
            $id = $notifications[$i]->getId() ? $notifications[$i]->getId() : "Pas d'id";
            $date = $notifications[$i]->getCreationDate() ? $notifications[$i]->getCreationDate() : "Pas de date";
            $message = $notifications[$i]->getMessage() ? $notifications[$i]->getMessage() : "Pas de message";

            if ($id !== $oldId && $date !== $oldDate) {
                echo '<tr><th scope = "ID">' . $id . '</th>';
                echo '<td>' . date("d-m-Y", strtotime($date)) . '</td>';
                echo '<td>' . $message . '</td>';
                echo '<td>' . $nb . '</td><tr>';
                $nb = 1;
                $oldId = $id;
            } else {
                $nb++;
            }
        }
        echo '</tbody></table>';
    }
}
