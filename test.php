<?php
$conn = new mysqli("localhost", "root", "", "testdb");

$username = $_POST['username'];
$password = $_POST['password']; // This is the plain-text password from the form

// First, retrieve the hashed password for the given username
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
if ($stmt === false) {
    // In a production environment, log the error details and display a generic message to the user.
    die('MySQL prepare error: ' . $conn->error);
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
        // session_start();
        // session_regenerate_id(true); // Prevent session fixation
        // $_SESSION['user_id'] = $user['id'];
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