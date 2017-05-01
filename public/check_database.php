<?php

/**
 * Check the database connection details are ok.
 *
 * *** Temporary script that should be deleted before putting live! ***
 *
 * PHP version 5.4
 */

/**
 * Database connection data
 */
$host = "127.0.0.1";
$db_name = "mvc";
$user = "root";
$password = "NEW-ROOT-PASSWORD";

/**
 * Create a connection
 */
$conn = new mysqli($host, $user, $password, $db_name);

/**
 * Check the connection
 */
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connected successfully, connection data are ok.";
}
