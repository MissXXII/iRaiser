<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/monitoring">iRaiser</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                echo ( isset($_GET['page']) && $_GET['page'] === "monthly" ) ?
                        '<li role="presentation" class="active"><a>Dons réguliers</a></li>' :
                        '<li role="presentation"><a href="donations.php?page=monthly">Dons réguliers</a></li>';
                echo ( isset($_GET['page']) && $_GET['page'] === "one-off" ) ?
                        '<li role="presentation" class="active"><a>Dons ponctuels</a></li>' :
                        '<li role="presentation"><a href="donations.php?page=one-off">Dons ponctuels</a></li>';
                echo ( isset($_GET['page']) && $_GET['page'] === "notifications" ) ?
                        '<li role="presentation" class="active"><a>Notifications</a></li>' :
                        '<li role="presentation"><a href="notifications.php?page=notifications">Notifications</a></li>';
                ?>
<!--                <li role="presentation"><a href="test.php"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>-->
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
