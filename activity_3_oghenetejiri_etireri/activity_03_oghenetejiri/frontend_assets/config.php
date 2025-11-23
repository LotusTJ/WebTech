<?php
// Database configuration
define('hostname', 'localhost');
define('username', 'root');      
define('password', '');      
define('database', 'dash-1');

// Create connectkon
function getDBConnection() {
    $conn = new mysqli(hostname,username,password,database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    
    
    $conn->set_charset("utf8");
    
    return $conn;
}

// Start session if not already started bh the time this file is included
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>