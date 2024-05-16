<?php
session_start(); // Starter en økt for å kunne lagre brukersesjonsdata.

?>

<!DOCTYPE html>
<html lang="no"> <!-- Språket er satt til norsk -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloodborne</title>
    <link rel="stylesheet" href="style.css"> <!-- Kobler til CSS-filen for styling -->
</head>
<body>
<nav class="navbar">
    <h1>Bloodborne</h1> <!-- Tittelen på nettstedet -->
    <a href="index.php">Hjem</a> <!-- Lenke til hjemmesiden -->

    <?php
    // Sjekker om brukeren er logget inn
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username']; // Henter brukernavnet fra sesjonsdata
        echo "<span>Hei $username!</span>"; // Viser en hilsen med brukernavnet
        // Viser logg ut-knapp hvis brukeren er logget inn
        echo '<form action="" method="post" class="logout-form">';
        echo '<a><button type="submit" class="logout-button" name="logout">Logg ut</button></a>';
        echo '</form>';
    } else {
        // Viser lenker til innlogging og registrering hvis brukeren ikke er logget inn
        echo '<a href="login.php">Logg inn</a>';
        echo '<a href="registration.php">Registrer</a>';
    }
    // Sjekker om brukeren er en administrator
    if(isset($_SESSION['user_id']) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
        echo '<a href="admin.php">Admin Panel</a>'; // Viser en lenke til administrasjonspanelet
    }
    ?>

</nav>

<div class="introduction-container">
    <h1 class="game-title">TellTale Game 2024</h1> <!-- Tittelen på spillet -->
    <div class="tutorial">
        <h3 class="tutorial-title">Slik spiller du</h3> <!-- Tittel for spillinstruksjoner -->
        <p class="tutorial-text">Velkommen til TellTale Game 2024! Dette interaktive historienspillet setter deg i førersetet og lar deg ta valg som former utfallet av historien. Her er hvordan det fungerer:</p> <!-- Instruksjonstekst -->
        <ol class="tutorial-steps">
            <li><strong>Starte spillet:</strong> For å begynne ditt eventyr, klikk på "Start" -knappen eller velg et kapittel fra de tilgjengelige valgene.</li>
            <li><strong>Navigere kapitler:</strong> Mens du fortsetter gjennom historien, vil du støte på forskjellige kapitler markert med numre. Hvert kapittel gir deg valg som påvirker historiens retning.</li>
            <li><strong>Ta valg:</strong> Når du blir presentert med alternativer, klikk på de tilsvarende knappene for å velge din vei. Vurder hvert valg nøye, da det kan føre til ulike utfall.</li>
            <li><strong>Utforske konsekvenser:</strong> Dine valg har konsekvenser som sprer seg gjennom historien. Vær oppmerksom på hvordan dine beslutninger påvirker karakterer, hendelser og den overordnede fortellingen.</li>
            <li><strong>Å nå sluttpunkter:</strong> Til slutt vil du nå slutten av historien eller et punkt der det ikke er flere valg tilgjengelig. På dette stadiet, reflekter over reisen din og se hvordan den avsluttes.</li>
            <li><strong>Starte på nytt:</strong> Vil du oppleve en annen vei eller utforske alternative avslutninger? Klikk på "Start på nytt" -knappen for å tilbakestille spillet og ta nye valg.</li>
        </ol>
        <p class="tutorial-text">Nå som du er kjent med grunnleggende, dykk inn i TellTale Game 2024-verdenen og la dine beslutninger forme historien!</p> <!-- Instruksjonstekst fortsettelse -->
    </div>
</div>

<?php
// Sjekker om brukeren er logget inn og har administratorrettigheter
if(isset($_SESSION['user_id']) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
    // Henter og viser listen over brukere hvis brukeren er en administrator
    $users = getUsers(); // Funksjon for å hente brukere fra databasen
    foreach($users as $user) {
        echo $user['username'] . ' - <a href="view-user.php?id=' . $user['user_id'] . '">Vis</a> | <a href="delete-user.php?id=' . $user['user_id'] . '">Slett</a><br>'; // Viser brukernavn med lenker for å vise og slette brukeren
    }
} else {
    // Omdirigerer brukeren til en annen side hvis de ikke har administratorrettigheter
    header('Location: index.php');
    exit;
}
?>

</body>
</html>
