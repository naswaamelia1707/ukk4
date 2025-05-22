<?php
session_start();
include('koneksi.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($data['role'] == 'user') {
            header('Location: index.php');
            exit();
        } else if ($data['role'] == 'admin') {
            header('Location: admin.php');
            exit();
        } else {
            header('Location: superadmin.php');
            exit();
        }
    } else {
        echo 'LOGIN GAGAL';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LOGIN</title>
    <style>
        /* Global body styling */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Box container for the form */
        .box {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
        }
        /* Inputs style */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px 0;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        /* Focus effect on inputs */
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 5px #667eea;
        }
        /* Submit button style */
        input[type="submit"] {
            width: 100%;
            background-color: #667eea;
            color: white;
            border: none;
            padding: 14px 0;
            font-size: 18px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        /* Hover effect on submit button */
        input[type="submit"]:hover {
            background-color: #5a67d8;
        }
        /* Error message styling */
        .error-message {
            color: #e53e3e;
            margin-bottom: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="box">
        <form action="login.php" method="post" novalidate>
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="submit" name="login" value="Login" />
        </form>
    </div>
</body>
</html>