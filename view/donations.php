<?php
require_once('../Donation.php');
$myDonations = new Donation();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href='../css/myStyle.css' rel='stylesheet'>
        <!-- Bootstrap core CSS -->
        <link href='../../dist/css/bootstrap.min.css' rel='stylesheet'>
        <!-- Bootstrap theme -->
        <link href='../../dist/css/bootstrap-theme.min.css' rel='stylesheet'>
        <!-- JQuery -->
        <script src="../js/jquery-2.1.3.min.js"></script>
        <title>
            <?php
            if ($_GET['page'] === "monthly") {
                echo "Dons Réguliers";
            } else if ($_GET['page'] === "one-off") {
                echo "Dons Ponctuels";
            }
            ?>
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body role="document">
        <?php
        include 'menu.php';
        ?>
        <div class="container-fluid theme-showcase" role="main">
            <div class="row">
                <div class="col-xs-12">
                    <h1 id="page_title">
                        <?php
                        if ($_GET['page'] === "monthly") {
                            echo "Dons Réguliers ";
                        } else if ($_GET['page'] === "one-off") {
                            echo "Dons Ponctuels ";
                        }
                        ?>
                    </h1>
                    <span class="legend" style="background-color:rgb(<?= $myDonations->getFailedColor(); ?>)"></span> Échoué
                    <span class="legend" style="background-color:rgb(<?= $myDonations->getValidatedColor(); ?>)"></span> Validé
                    <span class="legend" style="background-color:rgb(<?= $myDonations->getWaitingColor(); ?>)"></span> En attente
                </div>
                <div class="col-md-5" id="checkboxes">
                    <span class="checkbox-version" id="cbxpremium"><h5 class="title-version">Premium : </h5><input type="checkbox" id="premium" name="premium" checked></span>
                    <span class="checkbox-version" id="cbxlowcost"><h5 class="title-version">Lowcost : </h5><input type="checkbox" id="lowcost" name="lowcost" checked></span>
                    <input type="search" class="form-control" id="search" placeholder="Recherche" name="search">
                </div>
                <div class="col-md-7">
                    <?php
                    if ($_GET['page'] === "monthly") {
                        include 'form_month_picker.php';
                    } else if ($_GET['page'] === "one-off") {
                        include 'form_day_picker.php';
                    }
                    ?>
                </div>
            </div>
            <div class="row" id="alert-zone">
                <div class="col-xs-12">
                    <div class="alert" role="alert">
                        <strong>Attention ! </strong><span id="alert-msg"></span>
                    </div>
                </div>
            </div>
            <?php
            $myDonations->displayCharts();
            ?>
        </div>
        <!-- SCRIPTS -->
        <script type="text/javascript" src="../../dist/js/bootstrap.min.js"></script>
        <script src="../js/Chart.min.js"></script>
        <script src="../js/mychart.js"></script>
        <script src="../js/sorting-search.js"></script>
        <script src="../js/datepicker-control.js"></script>
    </body>
</html>
