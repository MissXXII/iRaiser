<?php

require_once('ClientInfo.php');
require_once('Config.php');
require_once('Data.php');

class Donation {

    private $server;
    private $failedColor = "252,189,189";
    private $validatedColor = "200,255,181";
    private $waitingColor = "255,231,151";

    // Displaying charts
    public function displayCharts() {
        // if the page exists
        if ($_GET['page'] === "one-off" || $_GET['page'] === "monthly") {
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];

            //  If dates are set
            if (isset($startDate) && isset($endDate)) {
                // but start date is superior to end date
                if ($startDate > $endDate) {
                    echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>La date de début doit être inférieure à la date de fin !</span>
                    </div>';
                    // If start date is inferior to end date or equal
                } else if ($startDate < $endDate || $startDate === $endDate) {
                    // if the end date is superior to actual date (Month version)
                    if ($_GET['page'] === "monthly" && $endDate > date('Y-m')) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>La date de fin ne peut être supérieur au mois actuel !</span>
                    </div>';
                        // if the end date is superior to actual date (Day version)
                    } else if ($_GET['page'] === "one-off" && $endDate > date('Y-m-d')) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>La date de fin ne peut être supérieur au jour actuel !</span>
                    </div>';
                        // if Year inferior to 0 (end date version)
                    } else if (substr($endDate, 0, 4) < 0) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>L\'année de fin n\'existe pas !</span>
                    </div>';
                        // if Year inferior to 0 (start date version)
                    } else if (substr($startDate, 0, 4) < 0) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>L\'année de début n\'existe pas !</span>
                    </div>';
                        // if month doesn't exist (end date version)
                    } else if (substr($endDate, 5, 7) > 12 || substr($endDate, 5, 7) <= 0) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>Le mois de la date de fin n\'existe pas !</span>
                    </div>';
                        // if month doesn't exist (start date version)
                    } else if (substr($startDate, 5, 7) > 12 || substr($startDate, 5, 7) <= 0) {
                        echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>Le mois de la date de début n\'existe pas !</span>
                    </div>';
                    } else {
                        $this->buildDisplay();
                    }
                }
                // If missing end date
            } else if (isset($startDate) && !isset($endDate)) {
                echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>Date de fin non renseignée</span>
                    </div>';
                // If missing start date
            } else if (!isset($startDate) && isset($endDate)) {
                echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>Date de début non renseignée</span>
            </div>';
            } else {
                $this->buildDisplay();
            }
            // Or if page's param doesn't exist
        } else {
            echo '<div class="alert alert-warning" role="alert">
                        <strong>Attention ! </strong><span>La page n\'existe pas !</span>
                    </div>';
        }
    }

    // build what will be displayed
    public function buildDisplay() {
        $dbList = $this->getAvailableDb();
        $premiumDbList = array();
        $lowcostDbList = array();

        // Separation of lowcost and premium client databases
        for ($i = 0; $i < count($dbList); $i++) {
            if ($dbList[$i]->getValid() == 1) {
                $premiumDbList[] = $dbList[$i];
            } elseif ($dbList[$i]->getValid() == 2) {
                $lowcostDbList[] = $dbList[$i];
            }
        }
        // If it have data from premium app to dipslay
        if (count($premiumDbList) > 0) {
            echo '<div class="row" id="premiumcharts">';
            echo '<div class="col-sm-12 title"><h2 class="text-primary">Premium</h2></div>';
            for ($i = 0; $i < count($premiumDbList); $i++) {
                $this->createThumbnail($premiumDbList[$i]->getDatabase(), $premiumDbList[$i]->getName());
                $this->sendToJs($this->server, $premiumDbList[$i]->getDatabase());
            }
            echo '</div>';
        }
        // If it have data from lowcost app to dipslay
        if (count($lowcostDbList) > 0) {
            echo '<div class="row" id="lowcostcharts">';
            echo '<div class="col-sm-12 title"><h2 class="text-primary">Lowcost</h2></div>';
            for ($i = 0; $i < count($lowcostDbList); $i++) {
                $this->createThumbnail($lowcostDbList[$i]->getDatabase(), $lowcostDbList[$i]->getName());
                $this->sendToJs($this->server, $lowcostDbList[$i]->getDatabase());
            }
            echo '</div>';
        }
        $this->server = null;
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
    }

    // Get the datas needed to fill the charts
    public function createData($server, $database) {

        $dates = array();
        $validated = array();
        $failed = array();
        $waiting = array();
        $colors = array("failedColor" => $this->failedColor,
            "validatedColor" => $this->validatedColor,
            "waitingColor" => $this->waitingColor);
        $arraysIndex = 0;

        $server->exec('USE ' . $database);
        // For one-off transactions
        if ($_GET['page'] === 'one-off') {

            $format = 'Y-m-d';
            $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date($format);
            $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date($format, strtotime('-6days'));

            $sql = $server->prepare(
                    "SELECT donation_status_computed AS status," .
                    "substring(create_dt,1,10) AS date, COUNT(*) AS total " .
                    "FROM anonymous_donations WHERE donation_regular_transaction = 0 " .
                    "AND substring(create_dt,1,10) BETWEEN '" . $startDate . "' AND '" . $endDate . "' " .
                    "GROUP BY donation_status_computed, substring(create_dt,1,10) " .
                    "ORDER BY substring(create_dt,1,10)");
            $sql->execute();
            // initializing arrays
            while ($startDate <= $endDate) {
                $dates[] = $startDate;
                $startDate = date($format, strtotime($startDate . '+1day'));
                $validated[] = 0; // Default value to 0 to avoid the "NULL" value later
                $failed[] = 0;
                $waiting[] = 0;
            }
            // For monthly transactions
        } else if ($_GET['page'] === 'monthly') {

            $format = 'Y-m';
            $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date($format);
            $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date($format, strtotime('-5month'));

            $sql = $server->prepare(
                    "SELECT donation_status_computed AS status, " .
                    "substring(create_dt,1,7) AS date, COUNT(*) AS total " .
                    "FROM anonymous_donations WHERE donation_regular_transaction = 1 " .
                    "AND substring(create_dt,1,7) BETWEEN '" . $startDate . "' AND '" . $endDate . "' " .
                    "GROUP BY donation_status_computed, substring(create_dt,1,7) " .
                    "ORDER BY substring(create_dt,1,7)");
            $sql->execute();
            // initializing arrays
            while ($startDate <= $endDate) {
                $dates[] = $startDate;
                $startDate = date($format, strtotime($startDate . '+1month'));
                $validated[] = 0; // Default value to 0 to avoid the "NULL" value later
                $failed[] = 0;
                $waiting[] = 0;
            }
        }
        while ($row = $sql->fetch()) {
            // If the dates are not the sames
            while ($dates[$arraysIndex] !== $row['date'] && $arraysIndex < count($dates)) {
                $arraysIndex++;
            }
            // If dates are the sames i can fill the arrays
            if ($dates[$arraysIndex] === $row['date']) {
                // Status validated found
                if ($row['status'] === 'validated') {
                    $validated[$arraysIndex] = intval($row['total']);
                    // Status failed found
                } else if ($row['status'] === 'failed') {
                    $failed[$arraysIndex] = intval($row['total']);
                    // Status waiting found
                } else if ($row['status'] === 'waiting') {
                    $waiting[$arraysIndex] = intval($row['total']);
                }
            }
        }
        $sql->closeCursor();
        $data = new Data($dates, $validated, $failed, $waiting, $colors);
        return $data;
    }

    // Creation of a div in the page that will contain a chart
    public function createThumbnail($databaseName, $clientName) {
        echo '<div class="col-sm-6 col-md-4 col-lg-4 chartContainer" id="' . $clientName . '">';
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading"><h3 class="panel-title">' . $this->truncate($clientName) . '</h3></div>';
        echo '<div class="panel-body"><canvas class="chart" id="' . $databaseName . '"></canvas></div></div></div>';
    }

    // Sending datas required by the chart app
    public function sendToJs($server, $database) {
        $data = $this->createData($server, $database)->toString();
        echo "<script>$( document ).ready(function(){createChart(\"" . $database . "\"," . $data . ")});</script>";
    }

    public function truncate($str, $nb = 47) {
        if (strlen($str) > $nb) {
            $texte = substr($str, 0, $nb);
            $str = $texte . "...";
        }
        return $str;
    }

    public function getFailedColor() {
        return $this->failedColor;
    }

    public function setFailedColor($failedColor) {
        $this->failedColor = $failedColor;
    }

    public function getValidatedColor() {
        return $this->validatedColor;
    }

    public function setValidatedColor($validatedColor) {
        $this->validatedColor = $validatedColor;
    }

    public function getWaitingColor() {
        return $this->waitingColor;
    }

    public function setwaitingColor($waitingColor) {
        $this->waitingColor = $waitingColor;
    }

}
