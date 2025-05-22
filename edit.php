<?php
session_start();
include('koneksi.php');

if (isset($_POST['edit'])) {
    $no_lama = $_POST['no_lama'];
    $kode_buku = $_POST['kode_buku'];
    $no_buku = $_POST['no_buku'];
    $judul_buku = $_POST['judul_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penulis = $_POST['penulis']; // Corrected variable name
    $penerbit = $_POST['penerbit'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $harga = $_POST['harga'];
    $gambar_buku = $_POST['gambar_buku'];

    // Update query
    $update_query = "UPDATE perpustaka SET 
        kode_buku='$kode_buku', 
        no_buku='$no_buku', 
        judul_buku='$judul_buku', 
        tahun_terbit='$tahun_terbit', 
        penulis='$penulis', 
        penerbit='$penerbit', 
        jumlah_halaman='$jumlah_halaman', 
        harga='$harga', 
        gambar_buku='$gambar_buku' 
        WHERE no_buku='$no_lama'";

    if (mysqli_query($koneksi, $update_query)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}

if (isset($_GET['no_buku'])) {
    $id = $_GET['no_buku'];
    $sql = mysqli_query($koneksi, "SELECT * FROM perpustaka WHERE no_buku='$id'");

    if (mysqli_num_rows($sql) === 0) {
        header('Location: admin.php');
        exit();
    }

    $data = mysqli_fetch_assoc($sql);
} else {
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <input type="hidden" name="no_lama" value="<?= htmlspecialchars($data['no_buku']) ?>" required>
        <input type="text" name="kode_buku" value="<?= htmlspecialchars($data['kode_buku']) ?>" required placeholder="Kode Buku">
        <input type="text" name="no_buku" value="<?= htmlspecialchars($data['no_buku']) ?>" required placeholder="No Buku">
        <input type="text" name="judul_buku" value="<?= htmlspecialchars($data['judul_buku']) ?>" required placeholder="Judul Buku">
        <input type="number" name="tahun_terbit" value="<?= htmlspecialchars($data['tahun_terbit']) ?>" required placeholder="Tahun Terbit">
        <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>" required placeholder="Nama Penulis">
        <input type="text" name="penerbit" value="<?= htmlspecialchars($data['penerbit']) ?>" required placeholder="Penerbit">
        <input type="number" name="jumlah_halaman" value="<?= htmlspecialchars($data['jumlah_halaman']) ?>" required placeholder="Jumlah Halaman">
        <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required placeholder="Harga">
        <input type="text" name="gambar_buku" value="<?= htmlspecialchars($data['gambar_buku']) ?>" required placeholder="Gambar Buku">

        <input type="submit" name="edit" value="EDIT">
    </form>
</body>
</html>