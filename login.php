<?php
session_start();

// Databasekonfigurasjon
$host = "localhost";
$username = "root";
$password = "admin";
$database = "game2024";

// Etabler tilkobling til databasen
$dbc = mysqli_connect($host, $username, $password, $database) or die('Feil ved tilkobling til MySQL-serveren.');

// Sjekk om skjemaet er sendt inn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Hent bruker-ID, brukernavn, e-post og passord fra skjemaet
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Saner brukerinput for å forhindre SQL-injeksjon
    $username = mysqli_real_escape_string($dbc, $username);
    $email = mysqli_real_escape_string($dbc, $email);
    $password = mysqli_real_escape_string($dbc, $password);

    // Bygg og utfør spørringen
    $query = "SELECT user_id, username, email FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
    $result = mysqli_query($dbc, $query) or die('Feil ved spørring til databasen.');

    // Sjekk om spørringen returnerte noen rader
    if (mysqli_num_rows($result) == 1) {
        // Hent brukerdetaljer
        $row = mysqli_fetch_assoc($result);

        // Lagre brukerdetaljer i sesjonen
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];

        // Omdiriger til startsiden eller annen side etter vellykket innlogging
        header('Location: index.php');
        exit;
    } else {
        // Hvis innloggingen mislykkes, sett feilmelding og omdiriger tilbake til innloggingssiden
        $_SESSION['login_error'] = true;
        header('Location: login.php');
        exit;
    }
}

// Lukk tilkoblingen til databasen
mysqli_close($dbc);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginSite</title>
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

<div class="login-container">
    <div class="login-content">
        <h1>Logg inn:</h1>
        <form method="post" action="login.php">
            <label for="username">Brukernavn:</label>
            <input type="text" class="input-box" name="username" /><br />

            <label for="email">E-post:</label>
            <input type="email" class="input-box" name="email" /><br />

            <label for="password">Passord:</label>
            <input type="password" class="input-box" name="password" /><br />

            <input type="submit" value="Logg inn" name="submit" class="LoginButton"/>
            
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p class="error"> Feil brukernavn, e-post eller passord</p>';
                unset($_SESSION['login_error']);
            }
            ?>
            
        </form>
        <p class="register-link">Eller klikk <a href="registration.php">her</a> for å registrere ny bruker</p>
    </div>           
</div>
 
</body>
</html>
