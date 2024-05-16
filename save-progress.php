<?php


// Databasekonfigurasjon
$host = "localhost";
$username = "root";
$password = "admin";
$database = "game2024";

// Etabler tilkobling til databasen
$dbc = mysqli_connect($host, $username, $password, $database) or die('Feil ved tilkobling til MySQL-serveren.');



// Check if it's an AJAX request
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Process the AJAX request
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["chapter"])) {
        // Extract chapter from POST data
        $chapter = $_POST["chapter"];
        
        // Save the game progress
        saveGameProgress($_SESSION['username'], $chapter);
        
        // Send JSON response
        echo json_encode(["success" => true, "message" => "Game progress saved successfully!"]);
    } else {
        // Invalid request
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
} 

/// Function to save game progress
function saveGameProgress($username, $chapter) {
    global $dbc; // Access the database connection object
    
    // Prepare the SQL statement to insert data into the save_files table
    $query = "INSERT INTO save_files (username, chapter) VALUES (?, ?)";
    
    // Prepare the statement
    $statement = mysqli_prepare($dbc, $query);
    
    if ($statement) {
        // Bind parameters
        mysqli_stmt_bind_param($statement, "ss", $username, $chapter);
        
        // Execute the statement
        if (mysqli_stmt_execute($statement)) {
            // Data inserted successfully
            return true;
        } else {
            // Error occurred while executing the statement
            return false;
        }
    } else {
        // Error occurred while preparing the statement
        return false;
    }
}

