<?php

$dbname="base.db";
$mytable ="tablename";

$texte = "balbla";

$query = "INSERT INTO $mytable (post_title) VALUES ('$texte')";

$base = new SQLite3($dbname);
$results = $base->exec($query);
