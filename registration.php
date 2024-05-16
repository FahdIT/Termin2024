<?php
session_start();

// Databasekonfigurasjon
$host = "localhost";
$username = "root";
$password = "admin";
$database = "game2024";

// Opprett tilkobling til databasen
$dbc = mysqli_connect($host, $username, $password, $database) or die('Feil ved tilkobling til MySQL-serveren.');

// Sjekk om brukeren allerede er logget inn, hvis ja, omdiriger ham til velkomstsiden
// if(isset($_SESSION['username'])) {
//     header('Location: index.php');
//     exit;
// }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
        <h1>Bloodborne</h1>
        <a href="index.php">Home</a>
        <?php
        // Sjekker om brukeren er logget inn
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<span>Hi $username!</span>";
            // Viser logg ut-knapp
            echo '<form action="" method="post">';
            echo '<input type="submit" value="Logout" name="logout">';
            echo '</form>';
        } else {
            // Viser lenker til innlogging og registrering hvis brukeren ikke er logget inn
            echo '<a href="login.php">Login</a>';
            echo '<a href="registration.php">Register</a>';
        }
        if(isset($_POST['logout'])) {
            // Destroy the session
            session_destroy();
            // Redirect the user to the login page or any other desired location
            header('Location: login.php');
            exit;
        }
        ?>
    </nav>


    
<div class="registration-container">
    <div class="registration-content">
        <h1>Opprett ny bruker:</h1>
        <form method="post">
            <label for="username" >Brukernavn:</label>
            <input type="text" class="input-box" name="username" required /><br />

            <label for="epost">Epost:</label>
            <input type="email"  class="input-box" name="epost"  required /><br /> 

            <label for="password">Passord:</label>
            <input type="password" class="input-box" name="password" required /><br />

            <input type="submit" value="Registrer" name="submit" class="LoginButton"/>
        </form>    
    </div>
</div>

<?php
if(isset($_POST['submit'])){
    //Gjør om POST-data til variabler
    $brukernavn = $_POST['username'];
    $epost = $_POST['epost'];
    $passord = $_POST['password'];   
    
    //Koble til databasen
    $dbc = mysqli_connect('localhost', 'root', 'admin', 'game2024');
    

    
    //Gjør klar SQL-strengen
    $query = "INSERT INTO users (username, email, password) VALUES ('$brukernavn', '$epost', '$passord')";
    

    
    //Utfør spørringen
    $result = mysqli_query($dbc, $query)
        or die('Error querying database.');
    
    //Koble fra databasen
    mysqli_close($dbc);

    //Sjekker om spørringen gir resultater
    if($result){
        //Gyldig registrering
        header('location: index.php');
    }else{
        //Ugyldig registrering
        echo "Noe gikk galt, prøv igjen!";
    }
}
?>


</body>
</html>
