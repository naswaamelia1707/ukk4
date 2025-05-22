<?php
session_start();
include('koneksi.php');

$message = "";
if(isset($_GET['no_buku'])){
    $id = $_GET['no_buku'];

    $delete = mysqli_query($koneksi, "DELETE FROM perpustaka WHERE no_buku= '$id'");

    if($delete){
        $message = "Buku dengan No Buku $id berhasil dihapus.";
    } else {
        $message = "Gagal menghapus buku dengan No Buku $id.";
    }
} else {
    $message = "No Buku tidak ditemukan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="3;url=admin.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hapus Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .message-box {
            background-color: rgba(0,0,0,0.6);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.5);
            text-align: center;
            max-width: 400px;
            animation: fadeIn 1s ease forwards;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        p {
            font-size: 1.2rem;
            margin-top: 0;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>Status Hapus Buku</h1>
        <p><?= htmlspecialchars($message) ?></p>
        <p>Anda akan dialihkan ke halaman admin dalam 3 detik...</p>
    </div>
</body>
</html>