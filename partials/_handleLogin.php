<?php

$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"]  ==  "POST") {
    include './_dbconnect.php';

    $email = $_POST["loginEmail"];
    $pass = $_POST["loginPassword"];

    // $sql = "SELECT * FROM users WHERE  username = '$username' AND password = '$password'";
    $sql = "SELECT * FROM `user` WHERE  `user_email` = '$email'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);  // returns the number of rows in the result set.
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['user_pass'])) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['useremail'] = $email;
        }
        header("Location: /forum/index.php");
    }
}
