<?php
require_once('../CustomMonitoring.php');
$myRequest = new CustomMonitoring();
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
        <title>Monitoring</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body role="document">
        <?php
        include 'menu_test.php';
        ?>
        <div class="container-fluid theme-showcase" role="main">
            <?php
            $myRequest->displayCustomMonitoring();
            ?>
            <form action="custom_monitoring.php" method="GET">
                <fieldset>
                    <input type="hidden" name="id" value=<?= $_GET['id'] ?> />
                    <button type="submit" name="delete" value="true" class="btn btn-default">Supprimer</button>
                </fieldset>
            </form>
        </div>
        <!-- SCRIPTS -->
        <script type="text/javascript" src="../../dist/js/bootstrap.min.js"></script>
    </body>
</html>