<?php
session_start();
require_once('save-progress.php');
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloodborne</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <h1>Bloodborne</h1>
    <a href="index.php">Home</a>
    
    <?php
    // Check if the user is logged in
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<span>Hi $username!</span>";
        // Display logout button
        echo '<form action="" method="post" class="logout-form">';
        echo '<a><button type="submit" class="logout-button" name="logout">Logout</button></a>';
        echo '</form>';
    } else {
        echo '<a href="login.php">Login</a>';
        echo '<a href="registration.php">Register</a>';
    }

    if(isset($_SESSION['user_id']) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
        echo '<a href="admin.php">Admin Panel</a>';}

    



    if(isset($_POST['logout'])) {
        // Destroy the session
        session_destroy();
        // Redirect the user to the login page or any other desired location
        header('Location: login.php');
        exit;
    }



    ?>
</nav>

<div class="introduction-container">
    <h1 class="game-title">TellTale Game 2024</h1>
    <div class="tutorial">
        <h3 class="tutorial-title">How to Play</h3>
        <p class="tutorial-text">Welcome to TellTale Game 2024! This interactive story game puts you in the driver's seat, allowing you to make choices that shape the outcome of the narrative. Here's how it works:</p>
        <ol class="tutorial-steps">
            <li><strong>Starting the Game:</strong> To begin your adventure, simply click on the "Start" button or select a chapter from the choices provided.</li>
            <li><strong>Navigating Chapters:</strong> As you progress through the story, you'll encounter different chapters marked by numbers. Each chapter presents you with choices that influence the direction of the plot.</li>
            <li><strong>Making Choices:</strong> When presented with options, click on the corresponding buttons to choose your path. Consider each decision carefully, as it may lead to different outcomes.</li>
            <li><strong>Exploring Consequences:</strong> Your choices have consequences that ripple throughout the story. Pay attention to how your decisions impact characters, events, and the overall narrative.</li>
            <li><strong>Reaching Endings:</strong> Eventually, you'll reach the end of the story or a point where no more choices are available. At this stage, reflect on your journey and see how it concludes.</li>
            <li><strong>Restarting:</strong> Want to experience a different path or explore alternate endings? Click on the "Restart" button to reset the game and make new choices.</li>
        </ol>
        <p class="tutorial-text">Now that you're familiar with the basics, dive into the world of TellTale Game 2024 and let your decisions shape the narrative!</p>
    </div>
</div>



<div class="game-container">
    <div id="buttonContainer" class="button-container">
        <!-- Buttons will be added here -->
    </div>

    <div class="save-game">
        <h1>Save Game</h1>
        <form id="saveForm">
            <button type="button" id="saveButton">Save Game</button>
        </form>
    </div>
</div>












<script>
    console.log("hey")

    const buttonContainer = document.getElementById("buttonContainer");
    var chapter = "1";

    // Define chapter choices mapping
    const chapterChoices = {

        // part 1
        "1": ["11", "12"],
        "11": ["111", "112"],
        "12": ["121", "122"],
         
        // part 2
        "111": ["1111", "1112"],
        "112": ["1121", "1122"],
        "121": ["1211", "1212"],
        "122": ["1221", "1222"],

        // part 3
        "1111": ["11111", "11112"],
        "1112": ["11121", "11122"],
        "1121": ["11211", "11212"],
        "1122": ["11221", "11222"],
        "1211": ["12111", "12112"],
        "1212": ["12121", "12122"],
        "1221": ["12211", "12212"],
        "1222": ["12221", "12222"],

        // part 4
        "11111": [],
        "11112": [],
        "11121": [],
        "11122": [],
        "11211": [],
        "11212": [],
        "11221": [],
        "11222": [],
        "12111": [],
        "12112": [],
        "12121": [],
        "12122": [],
        "12211": [],
        "12212": [],
        "12221": [],
        "12222": [],
        

        


        // Add more chapters and their choices as needed
    };







    
    
// Function to create buttons based on chapter number
function createButtons() {
    buttonContainer.innerHTML = ''; // Clear previous buttons
    
    // Get the choices for the current chapter
    const choices = chapterChoices[chapter];

    // Create buttons for each choice
    choices.forEach((choice, index) => {
        const button = document.createElement("button");
        button.textContent = choice;
        button.addEventListener("click", () => {
            // Save the game progress before proceeding
            saveGameProgress(chapter);
            
            // Update the current chapter
            chapter = choice;
            console.log("Current chapter:", chapter); // Log the current chapter
            
            // Re-render buttons and chapter information
            createButtons();
            displayChapterInfo();
        });
        buttonContainer.appendChild(button);
    });

    // If there are no more choices, add an "End of story" message and a restart button
    if (choices.length === 0) {
        const endMessage = document.createElement("h1");
        endMessage.textContent = "End of story";
        buttonContainer.appendChild(endMessage);
        console.log("End of story");

        const restartButton = document.createElement("button");
        restartButton.textContent = "Restart";
        restartButton.addEventListener("click", () => {
            // Save the game progress before restarting
            saveGameProgress("1");
            
            // Reset to the beginning
            chapter = "1";
            createButtons(); // Restart the story
            displayChapterInfo(); // Call the function to display chapter information initially
        });
        buttonContainer.appendChild(restartButton);
    }
}

// Function to handle manual saving when the save button is clicked
document.getElementById("saveButton").addEventListener("click", function() {
    // Save the game progress
    saveGameProgress(chapter);
});

// Function to save game progress using AJAX
function saveGameProgress(chapter) {
    // Send an AJAX request to save the game progress
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save-progress.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Indicate it's an AJAX request
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                if (response.success) {
                    console.log("Game progress saved successfully!");
                } else {
                    console.error("Error saving game progress:", response.message);
                }
            } else {
                console.error("Error saving game progress:", xhr.statusText);
            }
        }
    };
    xhr.send("chapter=" + encodeURIComponent(chapter));
}





    

    createButtons(); // Call the function to create buttons initially
    


    




    function displayChapterInfo() {
    // Check if chapter information already exists
    if (buttonContainer.getElementsByTagName("h2").length === 0) {
        const chapterInfo = {
            "1": "This is chapter 1. It sets the stage for the story.",
    "11": "You are now in chapter 11. Make your choice wisely.",
    "12": "Chapter 12 presents new challenges. Choose your path.",
    "111": "Welcome to chapter 111. The plot thickens.",
    "112": "Chapter 112 brings unexpected twists. What will you do?",
    "121": "In chapter 121, the stakes are raised. Your decisions matter.",
    "122": "Chapter 122 intensifies the narrative. What will happen next?",

    "1111": "Welcome to chapter 1111. The story takes a surprising turn.",
    "1112": "Chapter 1112 brings new challenges. Choose wisely.",
    "1121": "In chapter 1121, mysteries unravel. What will you uncover?",
    "1122": "Chapter 1122 presents dilemmas. How will you proceed?",
    "1211": "You are now in chapter 1211. The tension rises. What's your next move?",
    "1212": "Chapter 1212 introduces new characters. How will they impact the story?",
    "1221": "Welcome to chapter 1221. Secrets are revealed. How will you react?",
    "1222": "Chapter 1222 brings unexpected alliances. What will you do?",


    "11111": "In chapter 11111, the truth is revealed. How will you handle it?",
    "11112": "Chapter 11112 takes unexpected turns. What choices will you make?",
    "11121": "You are now in chapter 11121. The climax approaches. What's your plan?",
    "11122": "Chapter 11122 presents challenges. How will you overcome them?",
    "11211": "In chapter 11211, decisions have consequences. What path will you choose?",
    "11212": "Welcome to chapter 11212. Allies become adversaries. What's your strategy?",
    "11221": "Chapter 11221 brings closure. How will you resolve the story?",
    "11222": "In chapter 11222, the epilogue unfolds. What's the final outcome?",
    "12111": "You are now in chapter 12111. The climax approaches. What's your plan?",
    "12112": "Chapter 12112 presents challenges. How will you overcome them?",
    "12121": "Welcome to chapter 12121. Allies become adversaries. What's your strategy?",
    "12122": "In chapter 12122, the epilogue unfolds. What's the final outcome?",
    "12211": "Chapter 12211 brings closure. How will you resolve the story?",
    "12212": "You are now in chapter 12212. The climax approaches. What's your plan?",
    "12221": "Chapter 12221 presents challenges. How will you overcome them?",
    "12222": "Welcome to chapter 12222. Allies become adversaries. What's your strategy?",
        };

        // Check if the current chapter has information
        if (chapterInfo.hasOwnProperty(chapter)) {
            const infoHeader = document.createElement("h2");
            infoHeader.textContent = "Chapter " + chapter;
            buttonContainer.appendChild(infoHeader);

            const infoParagraph = document.createElement("p");
            infoParagraph.textContent = chapterInfo[chapter];
            buttonContainer.appendChild(infoParagraph);
        } else {
            // Handle the case where there's no information available for the current chapter
            console.log("No information available for chapter " + chapter);
        }
    }
}

displayChapterInfo(); // Call the function to display chapter information initially
</script>
    
</body>
</html>
