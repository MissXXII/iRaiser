<?php

$dbname = "base.db";
$mytable = "tablename";

$query = "SELECT id, post_title FROM $mytable";

$base = new SQLite3($dbname);
$results = $base->query($query);

while ($row = $results->fetchArray()) {
    $id = $row['id'];
    $title = $row['post_title'];
    echo $id." : ".$title."<br/>";
}