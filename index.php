<?php
session_start();
include('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>USER</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 40px;
            text-align: center;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            background-color: white;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        img {
            border-radius: 6px;
            max-width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku</h1>
    <table>
        <thead>
            <tr>
                <th>KODE BUKU</th>
                <th>NO BUKU</th>
                <th>JUDUL BUKU</th>
                <th>TAHUN TERBIT</th>
                <th>PENULIS</th>
                <th>PENERBIT</th>
                <th>JUMLAH HALAMAN</th>
                <th>HARGA</th>
                <th>GAMBAR BUKU</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM perpustaka");
            if ($sql) {
                while ($data = mysqli_fetch_array($sql)) {
                    // Pastikan data gambar valid agar tidak rusak tampilan
                    $gambar = htmlspecialchars($data['gambar_buku']);
                    // Jika gambar kosong, tampilkan placeholder (bisa Anda sesuaikan)
                    if (empty($gambar)) {
                        $gambar = 'placeholder.jpg'; // ganti sesuai lokasi placeholder Anda
                    }
        ?>
            <tr>
                <td><?= htmlspecialchars($data['kode_buku']); ?></td>
                <td><?= htmlspecialchars($data['no_buku']); ?></td>
                <td><?= htmlspecialchars($data['judul_buku']); ?></td>
                <td><?= htmlspecialchars($data['tahun_terbit']); ?></td>
                <td><?= htmlspecialchars($data['penulis']); ?></td>
                <td><?= htmlspecialchars($data['penerbit']); ?></td>
                <td><?= htmlspecialchars($data['jumlah_halaman']); ?></td>
                <td><?= htmlspecialchars($data['harga']); ?></td>
                <td>
                    <img src="<?= $gambar; ?>" alt="Cover Buku" />
                    <td>
                    <a href="pinjaman.php?no_buku=<?=$data['no_buku'];?>">pinjaman</a>
                    <a href="pengembalian.php?no_buku=<?=$data['no_buku'];?>">pengembalian</a>
                </td>
            </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='9'>Gagal mengambil data dari database.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</body>
</html>
