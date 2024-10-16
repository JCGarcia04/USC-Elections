<?php
session_start();

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vote_db";

    // Create a Connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Checking Connection
    if ($conn -> connect_error) {
        die("Connection failed: ". $conn -> connect_error);
    }
    
    // Prepare SQL insert query
    $sbmt = $conn -> prepare("INSERT INTO votes(id, position, candidate_name, vote_time) VALUES (?, ?, ?)");

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'] ?? null; // Use null if not set

    // Check if user is logged in
    if ($user_id === null) {
        die("User is not logged in.");
    }

    // Get the current time
    $vote_time = date('Y-m-d H:i:s');

    // Check if [Position] candidates are selected
if (isset($_POST['president'])) {
    foreach ($_POST['president'] as $candidate) {
        // Bind values
        $position = "President";
        $sbmt->bind_param("isss", $user_id, $position, $candidate, $vote_time);
        $sbmt->execute();
    }
}

    // Check if [Position] candidates are selected
    if (isset($_POST['vpinternal'])) {
        foreach ($_POST['vpinternal'] as $candidate) {
            // Bind values
            $position = 'Vice President Internal';
            $sbmt->bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt->execute();
        }
    }

    if (isset($_POST['vpexternal'])) {
        foreach ($_POST['vpexternal'] as $candidate) {
            // Bind values
            $position = 'Vice President External';
            $sbmt->bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt->execute();
        }
    }

    if (isset($_POST['secretary'])) {
        foreach ($_POST['secretary'] as $candidate) {
            // Bind values
            $position = 'Secretary';
            $sbmt->bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt->execute();
        }
    }

    $sbmt -> close();
    $conn -> close();

    echo "Your votes have been successfully recorded!";
?>