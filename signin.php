<?php
session_start();

// Validate user credentials
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

// Perform validation against stored credentials
// ...
// Store the credentials in the database (Example: using MySQLi)
  $dbHost = 'agforallof.us';
  $dbName = 'sensorgarden';
  $dbUser = 'plants';
  $dbPass = 'watermePLEASE';

// Create a new PDO instance
  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
  }
  

  // If credentials are valid, create session and redirect to the dashboard
  if ($validCredentials) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.html");
    exit;
  } else {
    echo 'Invalid username or password.';
  }
}
?>


<?php
session_start();

$dbHost = 'agforallof.us';
$dbName = 'sensorgarden';
$dbUser = 'plants';
$dbPass = 'watermePLEASE';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    if (password_verify($password, $user['password'])) {
      // Valid credentials, the user is authenticated
      $_SESSION['username'] = $username;
      header("Location: dashboard.html"); // Redirect to the dashboard page
      exit;
    } else {
      // Invalid password
      echo "Invalid username or password.";
      (!isset($_SESSION['username'])) {
        header("Location: login.html"); // Redirect to the login page if not authenticated
        exit;
    }
  } else {
    // User not found
    echo "Invalid username or password.";
    (!isset($_SESSION['username'])) {
      header("Location: login.html"); // Redirect to the login page if not authenticated
      exit;
    }
  }
}
?>
