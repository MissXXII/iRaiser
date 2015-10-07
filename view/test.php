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
            <div class="row">
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ajouter un monitoring personnalisé</h3>
                        </div>
                        <div class="panel-body">
                            <form action="custom_monitoring.php" method="POST" id="mymonitoring-form">
                                <fieldset>
                                    <div class="form-group">
                                        <p>
                                            <label for="name">Nom</label>
                                            <input type="text" class="form-control"
                                                   name="name" id="name" 
                                                   placeholder="Entrer un nom">
                                        </p>
                                        <p>
                                            <label for="request">Requête</label>
                                            <textarea class="form-control" rows="3" 
                                                      name="request" id="request" 
                                                      placeholder="Entrer une requête" 
                                                      form="mymonitoring-form">
                                            </textarea>
                                        </p>
                                    </div>
                                    <hr>
                                    <div class="form-group" id="stat-inputs">
                                        <p>
                                            <strong>Ajouter une statistique</strong>
                                            <button type="button" class="btn btn-primary btn-xs" id="btn-creation-add" name="add">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                        <p class="stat-row">
                                            <span class="stat-column">&nbsp;</span>
                                            <label class="stat-column" for="color">Couleur</label>
                                            <label class="stat-column" for="label">Label</label>
                                        </p>
                                        <p class="stat-row" id="stat1">
                                            <span class="stat-column">
                                                <button type="button" 
                                                        class="btn btn-danger btn-xs" id="btn-creation-delete1" style="visibility: hidden">
                                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                                </button>
                                                <strong>Statistique 1 :</strong>
                                            </span>
                                            <input type="text" class=" form-control stat-column"
                                                   id="color" name="color-stat[1]" placeholder="#000000">
                                            <input type="text" class="form-control stat-column" 
                                                   id="label" name="label-stat[1]" placeholder="Rentrer un nom">
                                        </p>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-default" id="btn-creation-save">Valider</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SCRIPTS -->
        <script type="text/javascript" src="../../dist/js/bootstrap.min.js"></script>
        <script src="../js/creation-form.js"></script>
    </body>
</html>
