<?php
// Start the session
session_start();

// Clear session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: website.html");
exit;
?>
