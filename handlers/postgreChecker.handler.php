<?php
function checkPostgreConnection() {
    $host = "host.docker.internal";
    $port = "5112";
    $username = "user";
    $password = "password";
    $dbname = "aiden017database";

    $conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";
    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        $result = "❌ PostgreSQL Connection Failed: " . pg_last_error();
    } else {
        $result = "✔️ PostgreSQL Connection";
        pg_close($dbconn);
    }
    return $result;
}