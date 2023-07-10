
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

  $sql = "SELECT * FROM Users WHERE email = :username LIMIT 1";
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
        header("Location: index.html"); // Redirect to the login page
      exit;
    }
  } else {
    // User not found
    echo "User not found. Invalid username or password.";
      header("Location: index.html"); // Redirect to the login page
      exit;
  }
}
?>
