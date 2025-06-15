<?php
// filepath: /c:/wamp64/www/gourmet-bakery/test_connection.php

require_once 'db_connect.php';
$conn = connect_db();
if ($conn) {
    echo "Connected to the Oracle database successfully!";
} else {
    $error = oci_error();
    echo "Connection failed: " . $error['message'];
}
?>