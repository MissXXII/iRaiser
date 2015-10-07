<?php
require_once('../Notification.php');
$notifications = new Notification();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href='../css/myStyle.css' rel='stylesheet'>
        <!-- Bootstrap core CSS -->
        <link href='../../dist/css/bootstrap.min.css' rel='stylesheet'>
        <!-- Bootstrap theme -->
        <link href='../../dist/css/bootstrap-theme.min.css' rel='stylesheet'>
        <title>Notifications</title>
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
                    Notifications
                    </h1>
                    <?php
                    $notifications->displayNotifications();
                    ?>
                </div>
            </div>
        </div>
        <!-- SCRIPTS -->
        <script src="../js/jquery-2.1.3.min.js"></script>
        <script type='text/javascript' src='../../dist/js/bootstrap.min.js'></script>
    </body>
</html>
