<?php

session_start();

$title = 'Data Barang';
include_once '../class/database.php';

// Inisialisasi objek Database
$db = new Database('host', 'username', 'password', 'db_name');
$conn = $db->getConn(); // Menggunakan metode getConn untuk mendapatkan koneksi

if (isset($_POST['submit'])) {

    $user = $db->escapeString($_POST['username']);
    $password = $db->escapeString($_POST['password']);

    $sql = "SELECT * FROM user WHERE username = '{$user}' AND password = md5('{$password}')";

    $result = $db->query($sql);
    if ($result && $result->num_rows != 0) {
        $_SESSION['isLogin'] = true;
        $_SESSION['username'] = $result->fetch_array();

        header('location: artikel/index.php');
        exit();
    } else {
        $errorMsg = "<p style=\"color:red;\">Gagal Login, silakan ulangi lagi. Error: " . $db->getConn()->error . "</p>";
    }
}

if (isset($errorMsg)) {
    echo $errorMsg;
}

// Menutup koneksi database
$db->closeConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        .login-container h2 {
            text-align: center;
            color: #333;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 90%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #87CEEB;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #98AFC7;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required autocomplete="off"/>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required/>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </div>
    
</body>
</html>
