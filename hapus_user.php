<?php
include('koneksi.php');

$id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$stmt = $koneksi->prepare("DELETE FROM user WHERE user_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $message = "User  Berhasil Dihapus";
} else {
    $message = "Terjadi kesalahan saat menghapus user.";
}

$stmt->close();
$koneksi->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdecea;
            color: #b71c1c;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #fff;
            border: 1px solid #b71c1c;
            border-radius: 8px;
            display: inline-block;
            padding: 30px 40px;
            box-shadow: 0 0 10px rgba(183, 28, 28, 0.2);
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        a {
            display: inline-block;
            text-decoration: none;
            background-color: #b71c1c;
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #7f1212;
        }
    </style>
    <meta http-equiv="refresh" content="3;url=superadmin.php" />
</head>
<body>
    <div class="container">
        <h1><?php echo $message; ?></h1>
        <p>Anda akan dialihkan kembali dalam 30 detik.</p>
        <a href="superadmin.php">Kembali Sekarang</a>
    </div>
</body>
</html>