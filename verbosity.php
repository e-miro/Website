<html>
<head>
<title>Verbosity</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <div class="verb-holder">
            <h1>Verbosity!</h1>
                <p id="verb-explain">The idea is that you write a sentence into the box below, press the button,
                then this application will write back a far more complicated sentence that will hopefully 
                mean basically the same thing. My thanks to Mirriam-Webster's Thesaurus API.
                </p>

            <form method="post" action="results.php">
                <label for="input">Input:</label><br>
                <input type="text" id="input" name="input"><br>
                <input type="submit">
            </form>
            
            <a href="index.php"><img class="icon" src="res/return.png" alt="Link to my homepage"></a>
            <img id="dictLogo" src="res/MWLogo.png" alt="Mirriam-Webster's Logo">
        </div>
    </div>
</body>
</html>