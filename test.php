<?php
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'secure_user';
$db_pass = getenv('DB_PASS'); // Ensure this environment variable is set in production. Connection will fail if not set.
$db_name = getenv('DB_NAME') ?: 'testdb';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("An unexpected error occurred. Please try again later.");
}

$username = $_POST['username'];
$password = $_POST['password']; // This is the plain-text password from the form
// This comment highlights a critical prerequisite for the secure login to function correctly. The change is outside the scope of this specific diff, but essential for overall system security. Example for registration/password update: $hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

// First, retrieve the hashed password for the given username
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
if ($stmt === false) {
    // In a production environment, log the error details and display a generic message to the user.
    error_log('MySQL prepare error: ' . $conn->error);
    die('An unexpected error occurred during login. Please try again later.');
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $hashed_password_from_db = $user['password'];

    // Verify the provided plain-text password against the stored hashed password
    if (password_verify($password, $hashed_password_from_db)) {
        echo "Login başarılı";
        // Example for session management:
        session_start();
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id'] = $user['id'];
        // header('Location: dashboard.php'); // Redirect to a protected page
        // exit();
    } else {
        echo "Kullanıcı adı veya şifre hatalı"; // Always use a generic message for security
    }
} else {
    echo "Kullanıcı adı veya şifre hatalı"; // Always use a generic message for security
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
</form>