<?php
$showAlert = 'false';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $cpassword = $_POST['signupCpassword'];

    //check whether this email exist
    $existSql = "SELECT * FROM `user` where user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $showError = "Email already Exist";
    } else {
        if (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email','$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        } else {
            $showError = "Password do not match";
        }
    }
    header("Location: /forum/index.php?signupsuccess=false&error=' . $showError . '");
}
