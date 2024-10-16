<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Retrieve Form Data
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

       // Validate User ID format
        if (!preg_match('/^\d{8}$/', $user_id)) {
            echo "<script>alert('User ID is not valid. Please enter an 8-digit number.');</script>";
            exit();
        }

        // Connect Database
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "auth";

        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        if ($conn -> connect_error){
            die("Connection failed: ". $conn -> connect_error);
        }
        
        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM login WHERE id = ?");
        $stmt->bind_param("i", $user_id); 
        $stmt->execute();
        $result = $stmt->get_result();

        // Initialize a flag to check login success
        $loginSuccess = false;

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];

            // Verify the password
            if ($password === $storedPassword) { 
                session_start();
                $_SESSION['user_id'] = $row['id']; // Store user ID in session
                $loginSuccess = true;
            } else {
                // Incorrect password, redirect to error page
                header("Location: error.html");
                exit();
            }
        } else {
            // User ID not found, redirect to error page
            header("Location: error.html");
            exit();
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Redirect based on login success
        if ($loginSuccess) {
            header("Location: elections.html");
            exit();
        } else {
            // Redirect to error if login failed
            header("Location: error.html");
            exit();
        }
    }
?>