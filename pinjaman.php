<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "buku";

$conn = new mysqli($host, $user,$pass , $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form ketika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_buku = $_POST['nama_buku'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $alasan = $_POST['alasan'];

    // Validasi sederhana
    if ($nama_buku && $tanggal && $jumlah && $alasan) {
        $sql = "INSERT INTO peminjaman (nama_buku, tanggal, jumlah, alasan)
                VALUES ('$nama_buku', '$tanggal', '$jumlah', '$alasan')";

        if ($conn->query($sql) === TRUE) {
            $message = "Peminjaman berhasil disimpan!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Harap isi semua data!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman </title>
</head>
<body>
    <h2>Form Peminjaman </h2>
    
    <?php if (!empty($message)) echo "<p><strong>$message</strong></p>"; ?>

    <form method="POST" action="">
        <label>Nama buku:</label><br>
        <input type="text" name="nama_buku" required><br><br>

        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required><br><br>

        <label>Jumlah:</label><br>
        <input type="text" name="jumlah" required><br><br>

        <label>Alasan:</label><br>
        <input type="text" name="alasan" required><br><br>

        <input type="submit" value="Simpan Peminjaman">
    </form>
</body>
</html>