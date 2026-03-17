<?php
$conn = new mysqli("localhost", "root", "", "testdb");

$username = $_POST['username'];
$password = $_POST['password'];

// Ensure $conn is an mysqli object and is connected.
// Assuming $username and $password are already defined from user input.

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");

if ($stmt === false) {
    // Handle error appropriately, e.g., log it and return a generic error message.
    error_log('MySQL prepare error: ' . $conn->error);
    // In a production environment, avoid exposing raw database errors to users.
    die('Database error. Please try again later.');
}

$stmt->bind_param("ss", $username, $password); // 'ss' indicates two string parameters

$stmt->execute();

$result = $stmt->get_result();

// Continue with fetching results from $result


if ($result->num_rows > 0) {
    echo "Login başarılı";
} else {
    echo "Login başarısız";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
</form>