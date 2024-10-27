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

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'] ?? null;
    
    // Check if user is logged in
    if ($user_id === null) {
        die("User is not logged in.");
    }

    // Check if the user has already voted
    $checkVote = $conn -> prepare("SELECT has_voted FROM vote_status WHERE id = ?");
    $checkVote -> bind_param("i", $user_id);
    $checkVote -> execute();
    $checkVote -> store_result();

    if ($checkVote -> num_rows > 0) {
        // If the user has already voted, deny them from voting again
        $checkVote -> bind_result($has_voted);
        $checkVote -> fetch();
        if ($has_voted) {
            echo"<script> 
            alert('You have already voted.');
            window.location.href = 'elections.html';
            </script>";
            return;
        }
    } else {
        // If no record exists for the user, insert a new one
        $insertStatus = $conn -> prepare("INSERT INTO vote_status (id, has_voted) VALUES (?, 0)");
        $insertStatus -> bind_param("i", $user_id);
        $insertStatus -> execute();
    }

    $checkVote -> close();

    // Check if user is logged in
    if ($user_id === null) {
        die("User is not logged in.");
    }
    
    // Prepare SQL insert query
    $sbmt = $conn -> prepare("INSERT INTO votes(id, candidate_name, position, vote_time) VALUES (?, ?, ?, ?)");

    // Get the current time
    $vote_time = date('Y-m-d H:i:s');

    // Check if [Position] candidates are selected
    if (isset($_POST['president'])) {
        foreach ($_POST['president'] as $candidate) {
            // Bind values
            $position = "President";
            $sbmt -> bind_param("isss", $user_id, $position, $candidate, $vote_time);
            $sbmt -> execute();
        }
    }

    // Check if [Position] candidates are selected
    if (isset($_POST['vpinternal'])) {
        foreach ($_POST['vpinternal'] as $candidate) {
            // Bind values
            $position = 'Vice President Internal';
            $sbmt -> bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt -> execute();
        }
    }

    if (isset($_POST['vpexternal'])) {
        foreach ($_POST['vpexternal'] as $candidate) {
            // Bind values
            $position = 'Vice President External';
            $sbmt -> bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt -> execute();
        }
    }

    if (isset($_POST['secretary'])) {
        foreach ($_POST['secretary'] as $candidate) {
            // Bind values
            $position = 'Secretary';
            $sbmt -> bind_param('isss', $user_id, $position, $candidate, $vote_time);
            $sbmt -> execute();
        }
    }

    // Mark the user as having voted after votes are submitted
    $updateVoteStatus = $conn -> prepare("UPDATE vote_status SET has_voted = 1 WHERE id = ?");
    $updateVoteStatus -> bind_param("i", $user_id);
    $updateVoteStatus -> execute();

    $sbmt -> close();
    $conn -> close();

    echo "Your votes have been successfully recorded!";
?> 