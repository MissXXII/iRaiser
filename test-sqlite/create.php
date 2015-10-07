<?php

$dbname="my_requests_db.db";
$mytable ="custom_requests";

if(!class_exists('SQLite3'))    
  die("SQLite 3 NOT supported.");


$base = new SQLite3($dbname,SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);

$query = "CREATE TABLE $mytable (id INTEGER PRIMARY KEY,post_title text)";
$results = $base->exec($query);