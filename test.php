<?php
$conn = new mysqli("localhost", "root", "", "testdb");

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
echo

$result = $conn->query($query);


if ($result->num_rows > 0) {
    echo "Login başarılsddı";
} else {
    echo "Login başarısız";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
</form>
