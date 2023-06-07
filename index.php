<?php
$validCredentials = [
  ['username' => 'test', 'password' => 'test'],
  ['username' => 'test2', 'password' => 'test2'],
];

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] > 10) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $bannedIPs = file('banned.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (in_array($ip, $bannedIPs)) {
            header("Location: /banned.html");
            exit();
        } else {
            file_put_contents('banned.txt', $ip . PHP_EOL, FILE_APPEND);
            header("Location: /banned.html");
            exit();
        }
    }



    $authenticated = false;

    foreach ($validCredentials as $credential) {
        if ($username === $credential['username'] && $password === $credential['password']) {
            $authenticated = true;
            break;
        }
    }

   if ($authenticated) {
        $referrer = $_SERVER['HTTP_REFERER'] ?? 'fallback_url_here';
        $referrerParts = parse_url($referrer);
        $referrerDomain = $referrerParts['scheme'] . '://' . $referrerParts['host'] ?? 'fallback_url_here';
        $redirectUrl = $referrerDomain . '/directories/landing.html';

        // Show redirecting page with loading icon for 3 seconds
        echo '<html>
<head>
<script>
    function getRandomQuote() {
      var quotes = [];
      var rawFile = new XMLHttpRequest();
      rawFile.open("GET", "quotes.txt", false);
      rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4 && rawFile.status === 200) {
          var allQuotes = rawFile.responseText;
          quotes = allQuotes.split("\n");
        }
      }
      rawFile.send(null);

      var randomChance = Math.random(); 
      if (randomChance < 0.01) {
        return "SECRET QUOTE - SCREENSHOT NOW";
      } else {
        var randomIndex = Math.floor(Math.random() * quotes.length);
        return quotes[randomIndex];
      }
    }

    window.onload = function() {
      var quoteElement = document.getElementById("quote");
      quoteElement.textContent = getRandomQuote();
    };
  </script>
  <style>
    @import url(\'https://fonts.googleapis.com/css2?family=Dekko:wght@400;700&display=swap\');
    @import url(\'https://fonts.googleapis.com/css2?family=Overlock:wght@400;700&display=swap\');
    @import url(\'https://fonts.googleapis.com/css2?family=Catamaran:wght@400;700&display=swap\');

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      background-color: black;
      font-family: Catamaran;
      user-select: none;
      color: white;
    }

    .loading-icon {
      display: inline-block;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: 5px solid #ffffff;
      border-top-color: transparent;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

  </style>
</head>
<body>
  <h1>Redirecting...</h1>
  <div class="loading-icon"></div>
  <p id="quote"></p>
  <script>
    setTimeout(function() {
      window.location.href = "' . $redirectUrl . '";
    }, 5000);
  </script>
</body>
</html>';
        exit();
    } else {
        $remainingAttempts = 10 - $_SESSION['login_attempts'];
        echo "
        <html>
        <style>
    @import url('https://fonts.googleapis.com/css2?family=Dekko:wght@400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Overlock:wght@400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Catamaran:wght@400;700&display=swap');

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background-color: black;
      font-family: Catamaran;
      user-select: none;
      color: white;
    }

  </style>
       <h3> You have entered an incorrect password. You have $remainingAttempts attempts left before your IP is permanently banned from our servers.</h3>
       <html>";
        exit();
    }
}
?>
<html>
<head>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Dekko:wght@400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Overlock:wght@400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Catamaran:wght@400;700&display=swap');

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background-color: black;
      font-family: Catamaran;
      user-select: none;
      color: white;
    }

  </style>
</head>
<body>
  <h1>Request handle not recognized</h1>
  <html>
    <head>
  <style>
    @import url(\'https://fonts.googleapis.com/css2?family=Dekko:wght@400;700&display=swap\');
    @import url(\'https://fonts.googleapis.com/css2?family=Overlock:wght@400;700&display=swap\');
    @import url(\'https://fonts.googleapis.com/css2?family=Catamaran:wght@400;700&display=swap\');

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      background-color: black;
      font-family: Catamaran;
      user-select: none;
      color: white;
    }

    .loading-icon {
      display: inline-block;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: 5px solid #ffffff;
      border-top-color: transparent;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    #quote {
      bottom: 1;
    }

  </style>
      <script>
    function getRandomQuote() {
      var quotes = [];
      var rawFile = new XMLHttpRequest();
      rawFile.open("GET", "quotes.txt", false);
      rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4 && rawFile.status === 200) {
          var allQuotes = rawFile.responseText;
          quotes = allQuotes.split("\n");
        }
      }
      rawFile.send(null);

      var randomChance = Math.random(); 
      if (randomChance < 0.0000000000000000000000000000000000000000000000000000000000000000000000000000001) {
        return "Nice try, you'll never get the secret quote. (If you see this you're a cheater. The secret quote is something else) But if you swear on youre life you didn't cheat, congratulations! There's a 0.0000000000000000000000000000000000000000000000000000000000000000000000000000001% chance you got this message without cheating. Don't worry tho, the real secret quote has a 0.01% chance ;)";
      } else {
        var randomIndex = Math.floor(Math.random() * quotes.length);
        return quotes[randomIndex];
      }
    }

    window.onload = function() {
      var quoteElement = document.getElementById("quote");
      quoteElement.textContent = getRandomQuote();
    };
  </script>
    </head>
<body>
  <h3>Redirecting you back to Skyhax...</h3>
  <div class="loading-icon"></div>
  <script>
    setTimeout(function() {
      window.location.href = "https://skyhax.lol";
    }, 5000);
  </script>
  <p id="quote"></p>
</body>
</html>
