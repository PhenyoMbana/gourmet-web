<?php
function connect_db() {
    $host = '10.0.0.172'; // Oracle host
    $port = '1521';       // Oracle port
    $sid = 'XE';          // Oracle SID
    $username = 'SYS';    // Oracle username
    $password = 'Kidsyri020507'; // Oracle password

    // Build the connection string
    $connection_string = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))";

    // Connect to the database with SYSDBA privilege
    $conn = oci_connect($username, $password, $connection_string, 'AL32UTF8', OCI_SYSDBA);

    if (!$conn) {
        $error = oci_error();
        die("Connection failed: " . $error['message']);
    }

    return $conn;
}
?>