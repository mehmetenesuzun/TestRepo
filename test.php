<?php
$conn = new mysqli("localhost", "root", "", "testdb");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// ✅ Use prepared statements with parameterized queries to prevent SQL Injection
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $username, $password); // "ss" indicates two string parameters
$stmt->execute();
$result = $stmt->get_result(); // Get the result set

if ($result->num_rows > 0) {
    echo "Login başarılı";
} else {
    echo "Login başarısız";
}

$stmt->close();
$conn->close();
?>

<form method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
</form>